@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.links.title')</h3>
    {!! Form::open(['method' => 'POST', 'route' => ['admin.links.store'], 'id' => 'link-form']) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_create')
        </div>
        
        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('link', trans('quickadmin.links.fields.link').'*', ['class' => 'control-label']) !!}
                    {!! Form::text('link', old('link'), ['class' => 'form-control', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('link'))
                        <p class="help-block">
                            {{ $errors->first('link') }}
                        </p>
                    @endif
                    <a id="add_link">
                        <span class="glyphicon glyphicon-plus"></span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    {!! Form::button(trans('quickadmin.qa_save_crawl'), ['class' => 'btn btn-primary', 'id' => 'save_crawl']) !!}
    {!! Form::submit(trans('quickadmin.qa_save'), ['class' => 'btn btn-danger']) !!}
    {!! Form::close() !!}
@stop
@section('javascript') 
<script src="{{ url('adminlte/js/pages/links.js') }}"></script>
@endsection
