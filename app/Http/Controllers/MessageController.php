<?php

namespace App\Http\Controllers;

use App\Http\Requests\SendMessageRequest;
use App\Models\Message;
use Illuminate\Http\JsonResponse;

class MessageController extends Controller
{
    public function sendMessage(SendMessageRequest $request): JsonResponse
    {
        $message = Message::create([
            'body'        => $request->input('message'),
            'receiver_id' => $request->input('receiver_id'),
            'sent_at'     => now(),
        ]);

        return response()->json($message, 201);
    }

    public function getMessages(): JsonResponse
    {
        $messages = Message::where(function ($query) {
            $query->where('user_id', auth()->id())
                ->orWhere('receiver_id', auth()->id());
        })
            ->orderBy('sent_at', 'desc')
            ->get();

        return response()->json($messages, 200);
    }
}
