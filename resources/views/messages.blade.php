@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">


                <div class="content">
                    <h1>conversations for user: {{$user->name}}</h1>

                    @if (sizeof($conversations) > 0)
                        @foreach ($conversations as $conversation)
                            <h3>{{var_dump($conversation)}}</h3>
                        @endforeach
                    @else
                        <h2>no conversations</h2>
                    @endif
                </div>
            </div>

        </div>
    </div>
@endsection

