@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Character</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <a href="{{url('character/create')}}" class="btn btn-primary">NEW CHARACTER</a> 
                    <div class="panel-body">

                    <ul>
              @foreach ($data as $item)
                
                    <li style='padding:5px'>
                    <a href="{{url('character')}}/{{$item->characterSheetId}}" class="btn btn-primary">Name</a> 
                    ID: {{$item->characterSheetId}}
                    
                </li>
              @endforeach
              </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection