@extends('layouts.app')
@section('css') 
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans" rel="stylesheet">
    <link href="{{ url('adminlte/css/pages/extract_result/detail.css') }}" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/min/dropzone.min.css">
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
                            <img src="/images/{{$extract_manager->asin}}/{{$extract_manager->image_mockup}}" alt="" />
                            <a href="#"><i class="fa fa-heart-o" aria-hidden="true"></i>Save</a>
                        </p>
                        <p class="download-btn"><a href="/images/{{$extract_manager->asin}}/{{$extract_manager->image_mockup}}" download="{{$extract_manager->image_mockup}}">Download</a></p>
                    </div>
                    <div class="col-md-4">
                        <p class="brand-img">
                            <img src="/images/{{$extract_manager->asin}}/{{$extract_manager->image_original}}" alt="" />
                            <a href="#"><i class="fa fa-heart-o" aria-hidden="true"></i>Save</a>
                        </p>
                        <p class="download-btn"><a href="/images/{{$extract_manager->asin}}/{{$extract_manager->image_original}}" download="{{$extract_manager->image_original}}">Download</a></p>
                    </div>
                    <div class="col-md-4">
                    <form method="post" action="{{route('admin.media.upload')}}" enctype="multipart/form-data" 
                  class="dropzone" id="dropzone">
                        </form>   
                    </div>
                </div>
            </div>
            <div class="brand-cnt">
                <p><span class="txt-bold">@lang('quickadmin.extract-manager.fields.rank'):</span> #{{ $extract_manager->rank }}</p>
                <p><span class="txt-bold">@lang('quickadmin.extract-manager.fields.asin'):</span><span class="txt-gray">{{ $extract_manager->asin}}</span><a class="link" href="#"><i class="fa fa-external-link" aria-hidden="true"></i></a></p>
                <p>
                    <span class="txt-bold">@lang('quickadmin.extract-manager.fields.feature'):</span>
                    <ul>
                    @foreach ($extract_manager->features as $feature)
                        <li>{{ $feature->feature }}</li>
                    @endforeach
                    </ul>
                </p>
                <p><span class="txt-bold">@lang('quickadmin.extract-manager.fields.price'):</span> {{ $extract_manager->price }}</p>
                <p><span class="txt-bold">@lang('quickadmin.extract-manager.fields.publish_date'):</span> {{ $extract_manager->updated_at }}</p>
            </div>
        </section>

            <p>&nbsp;</p>

            <a href="{{ route('admin.extract_managers.index') }}" class="btn btn-default">@lang('quickadmin.qa_back_to_list')</a>
        </div>
    </div>
@stop
@section('javascript') 
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/dropzone.js"></script>
<script type="text/javascript">
    Dropzone.options.dropzone =
         {
            maxFilesize: 12,
            renameFile: function(file) {
                var dt = new Date();
                var time = dt.getTime();
               return time+file.name;
            },
            acceptedFiles: ".jpeg,.jpg,.png,.gif",
            addRemoveLinks: true,
            timeout: 5000,
            success: function(file, response) 
            {
                console.log(response);
            },
            error: function(file, response)
            {
               return false;
            }
};
</script>
@endsection


