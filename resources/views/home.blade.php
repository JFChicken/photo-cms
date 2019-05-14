@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <div class="row">
                            
                            @foreach ($data as $item)    
                                    <a href="{{asset($item['img'])}}" data-toggle="lightbox" data-gallery="example-gallery" class="col-sm-2">
                                    <i class="fas fa-camera-retro"></i>
                                    <!-- <img src="{{asset($item['thumb'])}}" class="img-fluid"> -->
                                    </a>
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection