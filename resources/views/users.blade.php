@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">


                <div class="content">
                    <h1>List of users:</h1>

                    @if (sizeof($users) > 0)
                        @foreach ($users as $user)
                            @unless ($user->id == $me->id)
                                <h3>{{$user->name}} <a href="/messages/with-user/{{$user->id}}">msg</a></h3>
                            @endunless
                        @endforeach
                    @else
                        <h2>no users</h2>
                    @endif
                </div>
            </div>

        </div>
    </div>
@endsection

