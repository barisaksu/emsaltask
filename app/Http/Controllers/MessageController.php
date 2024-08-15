<?php

namespace App\Http\Controllers;

use App\Http\Requests\SendMessageRequest;
use App\Models\Message;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function sendMessage(SendMessageRequest $request): JsonResponse
    {
        $message = Message::create([
            'body'        => $request->input('body'),
            'receiver_id' => $request->input('receiver_id'),
            'sent_at'     => now(),
        ]);

        return response()->json($message, 201);
    }

    public function getMessages(Request $request): JsonResponse
    {
        $receiverId = $request->query('receiver_id');

        $messages = Message::where(function ($query) use ($receiverId) {
            $query->where(function ($q) use ($receiverId) {
                $q->where('user_id', auth()->id())
                    ->where('receiver_id', $receiverId);
            })->orWhere(function ($q) use ($receiverId) {
                $q->where('user_id', $receiverId)
                    ->where('receiver_id', auth()->id());
            });
        })
            ->orderBy('sent_at', 'asc')
            ->get();

        return response()->json($messages, 200);
    }
}
