<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat;
use App\Events\ChatMessageSent;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function sendMessage(Request $request)
    {
        $chat = Chat::create([
            'user_id' => Auth::guard('web')->user()->id,
            'vendor_id' => 1,
            'message' => $request->message,
        ]);

        broadcast(new ChatMessageSent($chat))->toOthers();

        return $chat;
    }

    public function getCustomerChat()
    {
        $messages = Chat::where('user_id', Auth::guard('web')->user()->id)->get();
        return view('front.customer.chat', compact('messages'));
    }

    public function getVendorChat()
    {
        $messages = Chat::where('vendor_id', Auth::guard('vendor')->user()->id)->get();
        return view('front.vendor.chat', compact('messages'));
    }
}
