@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <form name="character" method="post" action="{{url('character')}}">
                        <div class="form">
                            <div class="errors">
                                @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div><br />
                                @endif
                            </div>


                            <div class="section">
                                Basics->
                                <div class="subSection">
                                    <label for="basic_playerName">Player Name</label>
                                    <input type="text" name="basic_playerName" maxlength="50" size="30">

                                    <label for="basic_characterName">Character Name</label>
                                    <input type="text" name="basic_characterName" maxlength="50" size="30">
                                </div>
                            </div><!-- end section -->
                            <div class="section">
                                Stats->
                                <div class="subSection">
                                    STR
                                    <select name=stat_STR>
                                        @for ($i = 1; $i < 21; $i++) <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                    </select>

                                    DEX
                                    <select name=stat_DEX>
                                        @for ($i = 1; $i < 21; $i++) <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                    </select>
                                    CON
                                    <select name=stat_CON>
                                        @for ($i = 1; $i < 21; $i++) <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                    </select>
                                    INT
                                    <select name=stat_INT>
                                        @for ($i = 1; $i < 21; $i++) <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                    </select>
                                    WIS
                                    <select name=stat_WIS>
                                        @for ($i = 1; $i < 21; $i++) <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                    </select>
                                    CHA
                                    <select name=stat_CHA>
                                        @for ($i = 1; $i < 21; $i++) <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                    </select>
                                </div>
                            </div><!-- end section -->
                            <div class="section">
                                Class->
                                <div class="subSection">
                                    ClassName
                                    HitDice
                                    ProficiencyChoices['one','two']
                                    Proficiencies
                                    SavingThrows['one','two']
                                    ClassLevels[]
                                </div>
                            </div><!-- end section -->
                            @csrf
                            <button type="submit" class="btn btn-primary">Add</button>
                        </div><!-- Form end -->
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection