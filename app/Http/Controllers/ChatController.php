<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;

class ChatController extends Controller
{
    public function __invoke()
    {
        $users = User::where('id', '!=', auth()->id())
            ->get();

        return Inertia::render('Chat', [
            'users' => $users,
        ]);
    }
}
