@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')
@section('css') 
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans" rel="stylesheet">
    <link href="{{ url('adminlte/css/pages/extract_result/index.css') }}" rel="stylesheet"/>
@endsection
@section('content')
    <h3 class="page-title">@lang('quickadmin.extract-manager.title')</h3>

    @can('extract_manager_delete')
    <p>
        <ul class="list-inline">
            <li><a href="{{ route('admin.extract_managers.index') }}" style="{{ request('show_deleted') == 1 ? '' : 'font-weight: 700' }}">@lang('quickadmin.qa_all')</a></li> |
            <li><a href="{{ route('admin.extract_managers.index') }}?show_deleted=1" style="{{ request('show_deleted') == 1 ? 'font-weight: 700' : '' }}">@lang('quickadmin.qa_trash')</a></li>
        </ul>
    </p>
    @endcan


    <div class="panel panel-default">
        <div class="panel-heading shop_block">
            @lang('quickadmin.qa_list')
            <div class="change_style">
                    <span>
                        <a class="shop_grid_btn" href="#">
                            <i class="fa fa-th" aria-hidden="true"></i></i>
                        </a>
                    </span>
                    <span>
                        <a class="shop_list_btn active" href="#">
                            <i class="fa fa-list" aria-hidden="true"></i>
                        </a>
                    </span>
            </div>
        </div>
        <div class="panel-body table-responsive shop_block">
            <div class="shop_list shop_cnt">
                    <ul class="shop_item">
                    @if (count($extract_managers->items()) > 0)
                        @foreach ($extract_managers->items() as $extract_manager)
                            <li class="item_content">
                                <div class="media">
                                    <div class="media-left">
                                        <p>
                                            <img src="{{$extract_manager->image_mockup}}" alt="" width="150" height="150"/>
                                        </p>
                                    </div>
                                    <div class="media-body">
                                        <p class="item_name">{{$extract_manager->title}}</p>
                                        <span class="item_price">{{$extract_manager->branch}}</span>
                                        <span class="item_desc">{{$extract_manager->description}}</span>
                                        @can('extract_manager_view')
                                        <a href="{{ route('admin.extract_managers.show',[$extract_manager->id]) }}" class="btn btn-xs btn-primary">@lang('quickadmin.qa_view')</a>
                                        @endcan
                                        @can('extract_manager_delete')
                                            {!! Form::open(array(
                                                'style' => 'display: inline-block;',
                                                'method' => 'DELETE',
                                                'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                                'route' => ['admin.extract_managers.destroy', $extract_manager->id])) !!}
                                            {!! Form::submit(trans('quickadmin.qa_delete'), array('class' => 'btn btn-xs btn-danger')) !!}
                                            {!! Form::close() !!}
                                        @endcan
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    @endif
                    </ul>
                </div>
        </div>
        <nav>
            <ul class="pagination justify-content-end">
                {{$extract_managers->links('vendor.pagination.bootstrap-4') }}
            </ul>
        </nav>
    </div>
@stop

@section('javascript') 
    <script>
        @can('extract_manager_delete')
            @if ( request('show_deleted') != 1 ) window.route_mass_crud_entries_destroy = '{{ route('admin.extract_managers.mass_destroy') }}'; @endif
        @endcan

    </script>
    <script src="{{ url('adminlte/js/pages/extract_result/index.js') }}"></script>
@endsection