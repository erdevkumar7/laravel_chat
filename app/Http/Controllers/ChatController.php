<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat;
use App\Events\ChatMessageSent;
use Illuminate\Support\Facades\Auth;
use Pusher\Pusher;

class ChatController extends Controller
{
    public function authenticatePusher(Request $request)
    {
        // \Log::info('Pusher auth request payload', $request->all());
        $pusher = new Pusher(
            config('broadcasting.connections.pusher.key'),
            config('broadcasting.connections.pusher.secret'),
            config('broadcasting.connections.pusher.app_id'),
            config('broadcasting.connections.pusher.options')
        );
        // Generate the authentication payload  

        return response()->json(
            json_decode($pusher->socket_auth($request->channel_name, $request->socket_id), true)
        );
        return response()->json(['error' => 'Unauthorized'], 403);
    }

    public function sendCustomerMessage(Request $request)
    {
        $chat = Chat::create([
            'user_id' => Auth::guard('web')->user()->id,
            'vendor_id' => 3,
            'message' => $request->message,
        ]);

        broadcast(new ChatMessageSent($chat))->toOthers();
        return $chat;
    }

    public function sendVendorMessage(Request $request)
    {
        $chat = Chat::create([
            'user_id' => 1,
            'vendor_id' => Auth::guard('vendor')->user()->id,
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
        return Chat::where('vendor_id', Auth::guard('vendor')->user()->id)
            ->orWhere('user_id', 1)
            // ->with('user', 'vendor')
            ->orderBy('created_at', 'asc')
            ->get();
    }


    public function vendorMessages()
    {
        $vendor = auth('vendor')->user();
        return view('front.vendor.chat', compact('vendor'));
    }

    // public function fetchMessages()
    // {        
    //     return Chat::where('vendor_id', Auth::guard('vendor')->user()->id)
    //         ->orWhere('user_id', 1)
    //         ->with('user', 'vendor')
    //         ->orderBy('created_at', 'asc')
    //         ->get();
    // }

    // public function sendMessage(Request $request)
    // {
    //     $chat = Chat::create([
    //         'user_id' => Auth::id(),
    //         'vendor_id' => 3,
    //         'message' => $request->message,
    //     ]);

    //     broadcast(new ChatMessageSent($chat))->toOthers();

    //     return $chat;
    // }
}
