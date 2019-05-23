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
                            <div id="mygallery" >
                            <a href="{{asset($item['thumbnail'])}}">
                                    <!-- <i class="fas fa-camera-retro"></i> -->
                                    <img src="{{asset($item['thumbnail'])}}">
                                    </a>
                            </div>
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