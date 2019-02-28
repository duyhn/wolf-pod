@extends('layouts.app')
@section('css') 
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans" rel="stylesheet">
    <link href="{{ url('adminlte/css/pages/extract_result/detail.css') }}" rel="stylesheet"/>
@endsection
@section('content')
    <h3 class="page-title">@lang('quickadmin.extract-manager.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_view')
        </div>

        <div class="panel-body table-responsive">
        <section class="brand-page">
            <h2>{{ $extract_manager->title }}</h2>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-4">
                        <p class="brand-img">
                            <img src="{{$extract_manager->image_mockup}}" alt="" />
                            <a href="#"><i class="fa fa-heart-o" aria-hidden="true"></i>Save</a>
                        </p>
                        <p class="download-btn"><a href="" download="{{$extract_manager->image_mockup}}">Download</a></p>
                    </div>
                    <div class="col-md-4">
                        <p class="brand-img">
                            <img src="{{$extract_manager->image_original}}" alt="" />
                            <a href="#"><i class="fa fa-heart-o" aria-hidden="true"></i>Save</a>
                        </p>
                        <p class="download-btn"><a href="" download="{{$extract_manager->image_original}}">Download</a></p>
                    </div>
                    <div class="col-md-4">
                        <p class="brand-img">
                            <img src="{{$extract_manager->image_original}}" alt="" />
                            <a href="#"><i class="fa fa-heart-o" aria-hidden="true"></i>Save</a>
                        </p>
                        <p class="download-btn"><a  href="" download="{{$extract_manager->image_original}}">Download</a></p>
                    </div>
                </div>
            </div>
            <div class="brand-cnt">
                <p><span class="txt-bold">@lang('quickadmin.extract-manager.fields.best_sellter_rank'):</span> {{ $extract_manager->best_sellter_rank }}</p>
                <p><span class="txt-bold">@lang('quickadmin.extract-manager.fields.asin'):</span><span class="txt-gray">{{ $extract_manager->asin}}</span><a class="link" href="#"><i class="fa fa-external-link" aria-hidden="true"></i></a></p>
                <p><span class="txt-bold">@lang('quickadmin.extract-manager.fields.branch'):</span> <a class="txt-blue" href="#">{{ $extract_manager->branch }}</a></p>
                <p><span class="txt-bold">@lang('quickadmin.extract-manager.fields.description'):</span> <a class="txt-blue" href="#">{{ $extract_manager->description }}</a></p>
                <p>
                    <span class="txt-bold">Feature:</span>
                    <ul>
                        <li>{{ $extract_manager->bullet_4 }}</li>
                        <li>{{ $extract_manager->bullet_5 }}</li>
                    </ul>
                </p>
            </div>
        </section>

            <p>&nbsp;</p>

            <a href="{{ route('admin.extract_managers.index') }}" class="btn btn-default">@lang('quickadmin.qa_back_to_list')</a>
        </div>
    </div>
@stop


