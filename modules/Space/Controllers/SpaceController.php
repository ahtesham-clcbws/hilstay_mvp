<?php

namespace Modules\Space\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Modules\Location\Models\LocationCategory;
use Modules\Space\Models\Space;
use Illuminate\Http\Request;
use Modules\Location\Models\Location;
use Modules\Review\Models\Review;
use Modules\Core\Models\Attributes;
use DB;
use Modules\Booking\Models\Booking;
use Modules\Space\Models\SpaceDate;

class SpaceController extends Controller
{
    protected $spaceClass;
    protected $locationClass;
    /**
     * @var string
     */
    private $locationCategoryClass;

    public function __construct(Space $spaceClass)
    {
        $this->spaceClass = $spaceClass;
        $this->locationClass = Location::class;
        $this->locationCategoryClass = LocationCategory::class;
    }

    public function callAction($method, $parameters)
    {
        if (!Space::isEnable()) {
            return redirect('/');
        }
        return parent::callAction($method, $parameters); // TODO: Change the autogenerated stub
    }

    public function index(Request $request)
    {
        $layout = setting_item("space_layout_search", 'normal');
        if ($request->query('_layout')) {
            $layout = $request->query('_layout');
        }
        $is_ajax = $request->query('_ajax');
        $for_map = $request->query('_map', $layout === 'map');

        if (!empty($request->query('limit'))) {
            $limit = $request->query('limit');
        } else {
            $limit = !empty(setting_item("space_page_limit_item")) ? setting_item("space_page_limit_item") : 9;
        }
        $query = $this->spaceClass->search($request->input());
        $list = $query->paginate($limit);
        $markers = [];
        if (!empty($list) and $for_map) {
            foreach ($list as $row) {
                $markers[] = [
                    "id"      => $row->id,
                    "title"   => $row->title,
                    "lat"     => (float)$row->map_lat,
                    "lng"     => (float)$row->map_lng,
                    "gallery" => $row->getGallery(true),
                    "infobox" => view('Space::frontend.layouts.search.loop-grid', ['row' => $row, 'disable_lazyload' => 1, 'wrap_class' => 'infobox-item'])->render(),
                    'marker' => get_file_url(setting_item("space_icon_marker_map"), 'full') ?? url('images/icons/png/pin.png'),
                ];
            }
        }
        $limit_location = 15;
        if (empty(setting_item("space_location_search_style")) or setting_item("space_location_search_style") == "normal") {
            $limit_location = 1000;
        }
        $data = [
            'rows' => $list,
            'layout' => $layout
        ];
        if ($is_ajax) {
            return $this->sendSuccess([
                "markers" => $markers,
                'fragments' => [
                    '.ajax-search-result' => view('Space::frontend.ajax.search-result' . ($for_map ? '-map' : ''), $data)->render(),
                    '.result-count' => $list->total() ? ($list->total() > 1 ? __(":count spaces found", ['count' => $list->total()]) : __(":count space found", ['count' => $list->total()])) : '',
                    '.count-string' => $list->total() ? __("Showing :from - :to of :total Spaces", ["from" => $list->firstItem(), "to" => $list->lastItem(), "total" => $list->total()]) : ''
                ]
            ]);
        }
        $data = [
            'rows'               => $list,
            'list_location'      => $this->locationClass::where('status', 'publish')->limit($limit_location)->with(['translation'])->get()->toTree(),
            'space_min_max_price' => $this->spaceClass::getMinMaxPrice(),
            'markers'            => $markers,
            "blank" => setting_item('search_open_tab') == "current_tab" ? 0 : 1,
            "seo_meta"           => $this->spaceClass::getSeoMetaForPageList()
        ];
        $data['attributes'] = Attributes::where('service', 'space')->orderBy("position", "desc")->with(['terms' => function ($query) {
            $query->withCount('space');
        }, 'translation'])->get();
        $data['layout'] = $layout;

        if ($layout == "map") {
            $data['body_class'] = 'has-search-map';
            $data['html_class'] = 'full-page';
            return view('Space::frontend.search-map', $data);
        }
        return view('Space::frontend.search', $data);
    }

    public function detail(Request $request, $slug)
    {
        $row = $this->spaceClass::where('slug', $slug)->with(['location', 'translation', 'hasWishList'])->first();
        if (empty($row) or !$row->hasPermissionDetailView()) {
            return redirect('/');
        }
        $translation = $row->translate();
        $space_related = [];
        $location_id = $row->location_id;
        if (!empty($location_id)) {
            $space_related = $this->spaceClass::where('location_id', $location_id)->where("status", "publish")->take($this->limitRelated ?? 4)->whereNotIn('id', [$row->id])->with(['location', 'translation', 'hasWishList'])->get();
        }
        $review_list = $row->getReviewList();
        $data = [
            'row'          => $row,
            'translation'       => $translation,
            'space_related' => $space_related,
            'location_category' => $this->locationCategoryClass::where("status", "publish")->with('location_category_translations')->get(),
            'booking_data' => $row->getBookingData(),
            'review_list'  => $review_list,
            'seo_meta'  => $row->getSeoMetaWithTranslation(app()->getLocale(), $translation),
            'body_class' => 'is_single',
            'breadcrumbs'       => [
                [
                    'name'  => __('Space'),
                    'url'  => route('space.search'),
                ],
            ],
        ];
        $data['breadcrumbs'] = array_merge($data['breadcrumbs'], $row->locationBreadcrumbs());
        $data['breadcrumbs'][] = [
            'name'  => $translation->title,
            'class' => 'active'
        ];
        $this->setActiveMenu($row);

        // full calendar

        $today = Carbon::today();

        // Current month calculations
        $currentMonthStart = Carbon::createFromDate($today->year, $today->month, 1)->startOfWeek();
        $currentMonthEnd = Carbon::createFromDate($today->year, $today->month, 1)->endOfMonth()->endOfWeek();
        $currentMonthStartDate = Carbon::createFromDate($today->year, $today->month, 1)->startOfMonth(); // Last date of next month
        $currentMonthDates = [];

        $tempDate = $currentMonthStart->copy();
        while ($tempDate <= $currentMonthEnd) {
            $currentMonthDates[] = $tempDate->copy();
            $tempDate->addDay();
        }

        // Next month calculations
        $nextMonth = $today->copy()->addMonth();
        $nextMonthStart = Carbon::createFromDate($nextMonth->year, $nextMonth->month, 1)->startOfWeek();
        $nextMonthEnd = Carbon::createFromDate($nextMonth->year, $nextMonth->month, 1)->endOfMonth()->endOfWeek();
        $nextMonthLastDate = Carbon::createFromDate($nextMonth->year, $nextMonth->month, 1)->endOfMonth(); // Last date of next month
        $nextMonthDates = [];

        $tempDate = $nextMonthStart->copy();
        while ($tempDate <= $nextMonthEnd) {
            $nextMonthDates[] = $tempDate->copy();
            $tempDate->addDay();
        }

        $data['today'] = $today;
        $data['currentMonthDates'] = $currentMonthDates;
        $data['nextMonthDates'] = $nextMonthDates;
        $data['nextMonth'] = $nextMonth;
        $data['startCalendar'] = $currentMonthStartDate->format('Y-m-d H:s:i');
        $data['endCalendar'] = $nextMonthLastDate->format('Y-m-d H:s:i'); // Add this to your data array
        $data['loadDates'] = null;

        $request2 = $request;
        $request2->merge([
            'id' => $row->id,
            'start' => $today,
            'end' => $nextMonthLastDate
        ]);

        $loadDates = (new AvailabilityController(new Space, new SpaceDate, new Booking))->loadDatesStatic($request2);

        if (isset($loadDates->original) && count($loadDates->original)) {
            // $data['loadDates'] = $loadDates->original;
            $data['availabilityMap'] = collect($loadDates->original)->keyBy('start');
        }


        return view('Space::frontend.detail', $data);
    }
}
