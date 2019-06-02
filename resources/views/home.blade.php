@extends('layouts.app')

@section('content')
<div class="">
    <div id="gallery">
        @foreach ($data as $item)
        <a href="{{asset($item['image'])}} " data-lightbox="gallery1" data-title="">
            <!-- <i class="fas fa-camera-retro"></i> -->
            <img src="{{asset($item['thumbnail'])}}">
        </a>
        @endforeach
    </div>
</div>
@endsection

@section('pageScripts')
<script>
        $("#gallery").justifiedGallery();
</script>
@endsection