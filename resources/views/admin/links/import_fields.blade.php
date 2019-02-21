@extends('layouts.app')

@section('content')
<div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">@lang('quickadmin.qa_csvImport')</div>

                    <div class="panel-body">
                    {!! Form::open(['method' => 'POST', 'route' => ['admin.links.import.process']]) !!}

                            <table class="table">
                                @if (isset($csv_header_fields))
                                <tr>
                                    @foreach ($csv_header_fields as $csv_header_field)
                                        <th>{{ $csv_header_field }}</th>
                                    @endforeach
                                </tr>
                                @endif
                                @foreach ($csv_data as $row)
                                    <tr>
                                    @foreach ($row as $key => $value)
                                        <td>{{ $value }}</td>
                                    @endforeach
                                    </tr>
                                @endforeach
                            </table>

                            <button type="submit" class="btn btn-primary">
                                Import Data
                            </button>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

