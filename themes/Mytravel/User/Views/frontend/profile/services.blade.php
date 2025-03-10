<?php
$types = get_bookable_services();
if (empty($types)) return;
$list_service = [];
?>
<div class="profile-service-tabs">
    <div class="service-nav-tabs mb-4">
        <ul class="nav nav-tabs">
            @php $i = 0; @endphp
            @foreach($types as $type=>$moduleClass)
                @php
                    if(!$moduleClass::isEnable()) continue;
                    if(!$user->hasPermission($type.'_create')) continue;
                    $services = $moduleClass::getVendorServicesQuery($user->id)->orderBy('id','desc')->paginate(6);
                    if(empty($services->total())) continue;
                    $list_service[$type] = $services;
                @endphp
                    <li class="nav-item">
                        <a href="#" class="nav-link @if(!$i) active @endif" data-bs-toggle="tab" data-bs-target="#type_{{$type}}">{{$moduleClass::getModelName()}}</a>
                    </li>
                @php $i++; @endphp
            @endforeach
        </ul>
    </div>
    <div class="tab-content">
        @php $i = 0; @endphp
        @foreach($types as $type=>$moduleClass)
            @php
                if(!$moduleClass::isEnable()) continue;
                if(empty($list_service[$type])) continue;
            @endphp
                @if(view()->exists(ucfirst($type).'::frontend.profile.service') && $user->hasPermission($type.'_create'))
                    <div class="tab-pane fade @if(!$i) show active @endif" id="type_{{$type}}" role="tabpanel" aria-labelledby="pills-home-tab">
                        @include(ucfirst($type).'::frontend.profile.service',['services'=>$list_service[$type]])
                    </div>
                    @php $i++; @endphp
                @endif
        @endforeach
    </div>
</div>
