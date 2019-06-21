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
                        <form method="post" action="{{url('character/')}}/{{$data->characterSheetId}}">
                            @method('PATCH')
                            @csrf
                            <div class="form-group">
                                <label for="Json">Json: </label>
                                <textarea class="form-control" id="CharacterJson" name="CharacterJson" rows="10" placeholder="JSON">{{ $data->characterJson }}</textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>
</div>
@endsection