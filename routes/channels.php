<?php

use App\Http\Controllers\ChatController;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int)$user->id === (int)$id;
});

Broadcast::channel('chat-{chat_code?}', [ChatController::class, 'sendMessage']);
