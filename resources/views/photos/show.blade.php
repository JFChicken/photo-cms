@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-auto">
            <div class="card">
                <div class="card-header">Photos</div>

                <div class="card-body">
               IMAGE & MANAGMENT STUFF
               {{var_export($data)}}
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
