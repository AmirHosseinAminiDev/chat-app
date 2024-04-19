<?php

namespace App\Http\Controllers;

use App\Events\SendMessageEvent;
use App\Http\Requests\SendMessageRequest;
use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ChatController extends Controller
{
    public function sendMessage(SendMessageRequest $request)
    {
        $sender_id = $request->getSenderId();
        $receiver_id = $request->getReceiverId();
        $message = $request->getMessage();

        if ($request->has('chat_code')) {
            $chat = Chat::where('code', $request->get('chat_code'))->first();
            if ($chat->sender_id != $sender_id || $receiver_id != $chat->receiver_id) {
                return response()->json([
                    'status' => 'چت یافت نشد',
                ], 403);
            }
            $chat_code = $chat->code;
            event(new SendMessageEvent($sender_id, $receiver_id, $message, $chat_code));
            return response()->json([
                'message' => 'پیام با موفقیت ارسال شد',
            ], 200);
        }
        $chat = $this->createChat($sender_id, $receiver_id);
        event(new SendMessageEvent($sender_id, $receiver_id, $message, $chat->code));
        return response()->json([
            'message' => 'پیام با موفقیت ارسال شد',
        ], 200);
    }


    protected function createChat($sender_id, $receiver_id)
    {
        return Chat::create([
            'sender_id' => $sender_id,
            'receiver_id' => $receiver_id,
            'code' => Str::uuid()->toString(),
        ]);
    }
}
