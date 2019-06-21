@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Character</div>
                <div class="card uper">
                    <div class="card-header">Character ID: {{$data->characterSheetId}}</div>
                <div class="card-body">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                    <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                    </ul>
                    </div>
                    <br />
                    @endif
                <form method="post" action="">
                   
                    <div class="form-group">
                        <label for="Json">Json: </label>
                        <textarea class="form-control" id="CharacterJson" name="CharacterJson" rows="10" placeholder="JSON" readonly>{{ $data->characterJson }}</textarea>
                    </div>    
                    <a class="btn btn-primary" href="{{url('character/')}}/{{$data->characterSheetId}}/edit"> EDIT</a>
                
                    <div class="form-group">
                    @csrf
                    <label for="Created">Created:</label>
                    <input type="text" class="form-control" name="Created" value="{{$data->created_at}}" readonly />
                    </div>

                    <div class="form-group">
                    <label for="Modified">Modfided:</label>
                    <input type="text" class="form-control" name="Modified" value="{{$data->updated_at}}" readonly />
                    </div>

                </form>
                </div>
            </div>

        
            </div>
            </div>
        </div>
    </div>
</div>
@endsection