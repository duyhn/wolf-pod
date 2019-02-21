@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.extract-manager.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_view')
        </div>

        <div class="panel-body table-responsive">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>@lang('quickadmin.extract-manager.fields.title')</th>
                            <td field-key='title'>{{ $extract_manager->title }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.extract-manager.fields.branch')</th>
                            <td field-key='description'>{{ $extract_manager->branch }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.extract-manager.fields.asin')</th>
                            <td field-key='description'>{{ $extract_manager->asin}}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.extract-manager.fields.description')</th>
                            <td field-key='description'>{{ $extract_manager->description }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.extract-manager.fields.bullet_4')</th>
                            <td field-key='description'>{{ $extract_manager->bullet_4 }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.extract-manager.fields.bullet_5')</th>
                            <td field-key='description'>{{ $extract_manager->bullet_5 }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.extract-manager.fields.date_first_amazon')</th>
                            <td field-key='description'>{{ $extract_manager->date_first_amazon }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.extract-manager.fields.best_sellter_rank')</th>
                            <td field-key='description'>{{ $extract_manager->best_sellter_rank }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.extract-manager.fields.image_mockup')</th>
                            <td field-key='image_mockup'> <img class="img-responsive" src="{{$extract_manager->image_mockup}}"/></td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.extract-manager.fields.image_original')</th>
                            <td field-key='image_mockup'> <img class="img-responsive" src="{{$extract_manager->image_original}}"/></td>
                        </tr>
                    </table>
                </div>
            </div>

            <p>&nbsp;</p>

            <a href="{{ route('admin.extract_managers.index') }}" class="btn btn-default">@lang('quickadmin.qa_back_to_list')</a>
        </div>
    </div>
@stop


