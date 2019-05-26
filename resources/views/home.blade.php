@extends('layouts.app')

@section('content')
 <div class="">
    <!-- <div class="row"> -->
        <!-- <div class="col-md-8 col-md-offset-2"> -->
            <!-- <div class="panel panel-default"> -->
                <!-- <div class="row justify-content-center"> -->
                    <!-- <div class="col-md-10"> -->
                        <!-- <div class="row"> -->
                        <div id="mygallery" >
                            @foreach ($data as $item)
                            
                            <a href="{{asset($item['image'])}}">
                                    <!-- <i class="fas fa-camera-retro"></i> -->
                                    <img src="{{asset($item['thumbnail'])}}">
                                    </a>
                            
                            @endforeach
                            </div>
                            <script>
                            $("#mygallery").justifiedGallery();
                            </script>
                        <!-- </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> -->
</div>
@endsection