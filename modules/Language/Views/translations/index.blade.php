@extends('admin.layouts.app')
@section('content')
    <div class="container">
        <div class="d-flex justify-content-between mb20">
            <h1 class="title-bar">{{__("Translation Manager")}}</h1>
            <a class="btn btn-primary" href="{{route('language.admin.translations,loadStrings')}}"><i class="icon ion-ios-search"></i> {{__("Find Translations")}}</a>
        </div>
        @include('admin.message')
        <div class="alert alert-warning">
            {{__("After translation. You must re-build language file to apply the change")}}
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel">
                    <div class="panel-title">{{__("All Languages")}}</div>
                    <div class="panel-body">
                        <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>{{__("Name")}}</th>
                                <th>{{__("Percent")}}</th>
                                <th>{{__("Translated")}}</th>
                                <th>{{__("Last build at")}}</th>
                                <th>{{__("Actions")}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($languages) > 0)
                                @foreach($languages as $language)
                                    <tr>
                                        <td class="title">
                                            <a href="{{route('language.admin.translations.detail',['id'=>$language->id])}}">
                                                <span class="flag-icon flag-icon-{{$language->flag}}"></span> {{$language->name}}
                                                - ({{$language->locale}})
                                            </a>
                                        </td>
                                        <td>{{$total_text ? number_format((float) $language->translated_number / $total_text * 100,2) : 0 }}%</td>
                                        <td>{{$language->translated_number}}/{{$total_text}}</td>
                                        <td>{{$language->last_build_at ? display_datetime($language->last_build_at) : ''}}</td>
                                        <td>
                                            <a href="{{route('language.admin.translations.detail',['id'=>$language->id])}}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i> {{__("Translate")}}</a>
                                            <a href="{{route('language.admin.translations.build',['id'=>$language->id])}}" class="btn btn-sm btn-info"><i class="fa fa-cubes"></i> {{__("Build")}}</a>
                                            <button type="button" class="btn btn-secondary dropdown-toggle btn-sm" data-bs-toggle="dropdown">
                                                {{__("More")}}
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="{{route('language.admin.translations.loadTranslateJson',['locale'=>$language->locale])}}">{{__
                                                ("Load Translate  Default")}}</a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5">{{__("No data")}}</td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                        </div>
                        <div class="d-flex justify-content-end">{{$languages->links()}}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
