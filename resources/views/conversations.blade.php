@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">


                <div class="content">
                    <h1>conversation for users:</h1>
                    @foreach ($users  as $user)
                        <h3>{{$user}}</h3>
                    @endforeach

                    @if (sizeof($messages) > 0)
                        @foreach ($messages as $message)
                            <div>
                                @include('partials/message', ['message'=>$message])
                            </div>
                        @endforeach
                    @else
                        <h2>no messages</h2>
                    @endif


                    @include('partials/send-box', ['conversation'=>$conversation])

                </div>
            </div>
        </div>
    </div>
@endsection


