<div class="row">
    <div class="col-sm-4">
        <h3 class="form-group-title">{{__("Page List")}}</h3>
        <p class="form-group-desc">{{__('Config page list news of your website')}}</p>
    </div>
    <div class="col-sm-8">
        <div class="panel">
            <div class="panel-body">
                <div class="form-group">
                    <label class="" >{{__("Title Page")}}</label>
                    <div class="form-controls">
                        <input type="text" name="news_page_list_title" value="{{setting_item_with_lang('news_page_list_title',request()->query('lang'),$settings['news_page_list_title'] ?? '')}}" class="form-control">
                    </div>
                </div>

                @php do_action(\Modules\News\Hook::NEWS_SETTING_AFTER_BANNER_TITLE) @endphp

                @if(is_default_lang())
                <div class="form-group">
                    <label>{{__("Posts Per Page")}}</label>
                    <div class="form-controls">
                        <input type="number" class="form-control" name="news_posts_per_page" value="{{ setting_item('news_posts_per_page', 5) }}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="" >{{__("Banner Page")}}</label>
                    <div class="form-controls form-group-image">
                        {!! \Modules\Media\Helpers\FileHelper::fieldUpload('news_page_list_banner',$settings['news_page_list_banner'] ?? "") !!}
                    </div>
                </div>
                @php $layouts = config('news.layouts') @endphp
                    @if(!empty($layouts))
                        <div class="form-group">
                            <label class="" >{{__("Layout Search")}}</label>
                            <div class="form-controls">
                                <select name="news_layout_search" class="form-control" >
                                    @foreach(config('news.layouts') as $id=>$name)
                                        <option value="{{$id}}" {{ setting_item('news_layout_search','normal') == $id ? 'selected' : ''  }}>{{$name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endif
                @endif
                <div class="form-group">
                    <label class="" >{{__("SEO Options")}}</label>
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#seo_1">{{__("General Options")}}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#seo_2">{{__("Share Facebook")}}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#seo_3">{{__("Share Twitter")}}</a>
                        </li>
                    </ul>
                    <div class="tab-content" >
                        <div class="tab-pane active" id="seo_1">
                            <div class="form-group" >
                                <label class="control-label">{{__("Seo Title")}}</label>
                                <input type="text" name="news_page_list_seo_title" class="form-control" placeholder="{{__("Enter title...")}}" value="{{ setting_item_with_lang('news_page_list_seo_title',request()->query('lang'),$settings['news_page_list_seo_title'] ?? "")}}">
                            </div>
                            <div class="form-group">
                                <label class="control-label">{{__("Seo Description")}}</label>
                                <input type="text" name="news_page_list_seo_desc" class="form-control" placeholder="{{__("Enter description...")}}" value="{{setting_item_with_lang('news_page_list_seo_desc',request()->query('lang'),$settings['news_page_list_seo_desc'] ?? "")}}">
                            </div>
                            @if(is_default_lang())
                            <div class="form-group form-group-image">
                                <label class="control-label">{{__("Featured Image")}}</label>
                                {!! \Modules\Media\Helpers\FileHelper::fieldUpload('news_page_list_seo_image', $settings['news_page_list_seo_image'] ?? "" ) !!}
                            </div>
                            @endif
                        </div>
                        @php $seo_share = !empty($settings['news_page_list_seo_share']) ? json_decode($settings['news_page_list_seo_share'],true): false;
                        $seo_share = setting_item_with_lang('news_page_list_seo_share',request()->query('lang'),$seo_share)
                        @endphp
                        <div class="tab-pane" id="seo_2">
                            <div class="form-group">
                                <label class="control-label">{{__("Facebook Title")}}</label>
                                <input type="text" name="news_page_list_seo_share[facebook][title]" class="form-control" placeholder="{{__("Enter title...")}}" value="{{$seo_share['facebook']['title'] ?? "" }}">
                            </div>
                            <div class="form-group">
                                <label class="control-label">{{__("Facebook Description")}}</label>
                                <input type="text" name="news_page_list_seo_share[facebook][desc]" class="form-control" placeholder="{{__("Enter description...")}}" value="{{$seo_share['facebook']['desc'] ?? "" }}">
                            </div>
                            @if(is_default_lang())
                            <div class="form-group form-group-image">
                                <label class="control-label">{{__("Facebook Image")}}</label>
                                {!! \Modules\Media\Helpers\FileHelper::fieldUpload('news_page_list_seo_share[facebook][image]',$seo_share['facebook']['image'] ?? "" ) !!}
                            </div>
                            @endif
                        </div>
                        <div class="tab-pane" id="seo_3">
                            <div class="form-group">
                                <label class="control-label">{{__("Twitter Title")}}</label>
                                <input type="text" name="news_page_list_seo_share[twitter][title]" class="form-control" placeholder="{{__("Enter title...")}}" value="{{$seo_share['twitter']['title'] ?? "" }}">
                            </div>
                            <div class="form-group">
                                <label class="control-label">{{__("Twitter Description")}}</label>
                                <input type="text" name="news_page_list_seo_share[twitter][desc]" class="form-control" placeholder="{{__("Enter description...")}}" value="{{$seo_share['twitter']['title'] ?? "" }}">
                            </div>
                            @if(is_default_lang())
                            <div class="form-group form-group-image">
                                <label class="control-label">{{__("Twitter Image")}}</label>
                                {!! \Modules\Media\Helpers\FileHelper::fieldUpload('news_page_list_seo_share[twitter][image]', $seo_share['twitter']['image'] ?? "" ) !!}
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-sm-4">
        <h3 class="form-group-title">{{__("Sidebar Options")}}</h3>
        <p class="form-group-desc">{{__('Config sidebar for news')}}</p>
    </div>
    <div class="col-sm-8">
        <div class="panel">
            <div class="panel-body">
                <div class="form-group">
                    <div class="form-controls">
                        <div class="form-group-item">
                            <div class="g-items-header">
                                <div class="row">
                                    <div class="col-md-8">{{__("Title")}}</div>
                                    <div class="col-md-3">{{__('Type')}}</div>
                                    <div class="col-md-1"></div>
                                </div>
                            </div>
                            <div class="g-items">
                                <?php
                                $social_share = [];
                                if(!empty($settings['news_sidebar'])){
                                $social_share  = $settings['news_sidebar'];

                                $social_share = json_decode(setting_item_with_lang('news_sidebar',request()->query('lang'),$settings['news_sidebar'] ?? "[]"));
                                ?>
                                @foreach($social_share as $key=>$item)
                                    <div class="item" data-number="{{$key}}">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <input type="text" name="news_sidebar[{{$key}}][title]" class="form-control" placeholder="{{__('Title: About Us')}}" value="{{$item->title}}">
                                                <textarea name="news_sidebar[{{$key}}][content]" rows="2" class="form-control" placeholder="{{__("Content")}}">{{$item->content}}</textarea>
                                            </div>
                                            <div class="col-md-3">
                                                <select class="form-control" name="news_sidebar[{{$key}}][type]">
                                                    <option @if(!empty($item->type) && $item->type=='search_form') selected @endif value="search_form">{{__("Search Form")}}</option>
                                                    <option @if(!empty($item->type) && $item->type=='recent_news') selected @endif value="recent_news">{{__("Recent News")}}</option>
                                                    <option @if(!empty($item->type) && $item->type=='featured_listings') selected @endif value="featured_listings">{{__("Featured Listings")}}</option>
                                                    <option @if(!empty($item->type) && $item->type=='category') selected @endif value="category">{{__("Category")}}</option>
                                                    <option @if(!empty($item->type) && $item->type=='tag') selected @endif value="tag">{{__("Tags")}}</option>
                                                    <option @if(!empty($item->type) && $item->type=='content_text') selected @endif value="content_text">{{__("Content Text")}}</option>
                                                </select>
                                            </div>
                                            <div class="col-md-1">
                                                <span class="btn btn-danger btn-sm btn-remove-item"><i class="fa fa-trash"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                <?php } ?>
                            </div>
                            <div class="text-right">
                                <span class="btn btn-info btn-sm btn-add-item"><i class="icon ion-ios-add-circle-outline"></i> {{__('Add item')}}</span>
                            </div>
                            <div class="g-more hide">
                                <div class="item" data-number="__number__">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <input type="text" __name__="news_sidebar[__number__][title]" class="form-control" placeholder="{{__('Title: About Us')}}">
                                            <textarea __name__="news_sidebar[__number__][content]" rows="3" class="form-control" placeholder="{{__("Content")}}"></textarea>
                                        </div>
                                        <div class="col-md-3">
                                            <select class="form-control" __name__="news_sidebar[__number__][type]">
                                                <option value="search_form">{{__("Search Form")}}</option>
                                                <option value="recent_news">{{__("Recent News")}}</option>
                                                <option value="category">{{__("Category")}}</option>
                                                <option value="tag">{{__("Tags")}}</option>
                                                <option value="content_text">{{__("Content Text")}}</option>
                                            </select>
                                        </div>
                                        <div class="col-md-1">
                                            <span class="btn btn-danger btn-sm btn-remove-item"><i class="fa fa-trash"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-sm-4">
        <h3 class="form-group-title">{{__("Vendor News")}}</h3>
        <p class="form-group-desc">{{__('Config for vendor')}}</p>
    </div>
    <div class="col-sm-8">
        <div class="panel">
            <div class="panel-title"><strong>{{__("Vendor News")}}</strong></div>
            <div class="panel-body">
                <div>
                    <label ><input type="checkbox" name="news_vendor_need_approve" value="1" @if(setting_item('news_vendor_need_approve')) checked @endif> {{__("Admin need approve news to be publish")}}</label>
                </div>
            </div>
        </div>
    </div>
</div>
