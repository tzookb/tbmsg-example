<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

use Tzookb\TBMsg\Domain\Exceptions\ConversationNotFoundException;

Route::get('/', function () {
    return view('welcome');
});



Route::group(['middleware' => ['web']], function () {
    Route::auth();

    Route::get('/home', 'HomeController@index');


    Route::group(['middleware' => 'auth'], function () {
        //page that displays all users conversations
        Route::get('/messages', function () {
            $user = Auth::user();
            /** @var Tzookb\TBMsg\TBMsg $tbmsg */
            $tbmsg = app('Tzookb\TBMsg\TBMsg');
            $conversations  = $tbmsg->getUserConversations($user->id);


            return view('messages', compact('user', 'conversations'));
        });

        //this route check if the logged user has a conversation with the user
        //in the url, if so it will redirect the user to their conversation
        //if not it will create a conversation and then redirect him
        Route::get('/messages/with-user/{user}', function ($userToSendToId) {
            $user = Auth::user();
            /** @var Tzookb\TBMsg\TBMsg $tbmsg */
            $tbmsg = app('Tzookb\TBMsg\TBMsg');

            //check conversation exist between two users
            try {
                $convId = $tbmsg->getConversationByTwoUsers($user->id, $userToSendToId);
                var_dump('FOUND');
            } catch (ConversationNotFoundException $ex) {
                //if not create one
                var_dump('creating');
                $convId = $tbmsg->createConversation([$user->id, $userToSendToId]);
            }

            //redirect to that conversation
            return redirect('/messages/' . $convId);
        });

        //page to display specific conversation
        Route::get('/messages/{conversation}', function ($conversation) {
            $user = Auth::user();
            /** @var Tzookb\TBMsg\TBMsg $tbmsg */
            $tbmsg = app('Tzookb\TBMsg\TBMsg');
            $messages = $tbmsg->getConversationMessages($conversation, $user->id);

            $users = [];
            return view('conversations', compact('users', 'messages', 'conversation'));
        });

        //this sends a message to conversation
        Route::post('/messages/{conversation}', function ($conversation, \Illuminate\Http\Request $request) {
            $user = Auth::user();
            $data = $request->only('content');

            /** @var Tzookb\TBMsg\TBMsg $tbmsg */
            $tbmsg = app('Tzookb\TBMsg\TBMsg');
            $res = $tbmsg->addMessageToConversation($conversation, $user->id, $data['content']);


            return $conversation;
        });

        //this sends a message to conversation
        Route::get('/users', function () {
            $me = Auth::user();
            $users = \App\User::all();
            return view('users', compact('users', 'me'));
        });
    });


});
