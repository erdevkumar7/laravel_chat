<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat;
use App\Models\Vendor;
use App\Models\User;
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

    public function getAllVendorForChat()
    {
        $vendors = Vendor::all();
        return view('front.vendor.all_chat_vendor', compact('vendors'));
    }


    public function getCustomerChat($vendor_id)
    {
        $vendor = Vendor::find($vendor_id);
        if (!$vendor) {
            return redirect()->back()->with('error', 'Vendor not found.');
        }

        $messages = Chat::where('user_id', Auth::guard('web')->user()->id)
            ->where('vendor_id', $vendor_id)
            ->get();

        return view('front.customer.chat', compact('messages', 'vendor'));
    }

    public function sendCustomerMessage(Request $request)
    {
        $chat = Chat::create([
            'user_id' => Auth::guard('web')->user()->id,
            'vendor_id' => $request->vendor_id,
            'message' => $request->message,
        ]);

        broadcast(new ChatMessageSent($chat))->toOthers();

        return response()->json(['success' => true, 'message' => $chat]);
    }

    // Vendor Chat Functionality *********************************************************************
    public function getVendorChat($user_id)
    {
        $user = User::find($user_id);
        if (!$user) {
            return redirect()->back()->with('error', 'User not found!');
        }

        $vendor = auth('vendor')->user();       
        $messages = Chat::where('user_id', $user_id)
            ->where('vendor_id', $vendor->id)->get();
      
        return view('front.vendor.chat', compact('messages', 'vendor', 'user'));
    }

    public function sendVendorMessage(Request $request)
    {
        // $chat = Chat::create([
        //     'user_id' => 1,
        //     'vendor_id' => Auth::guard('vendor')->user()->id,
        //     'message' => $request->message,
        // ]);

        // broadcast(new ChatMessageSent($chat))->toOthers();

        // return $chat;

        $chat = Chat::create([
            'user_id' => $request->user_id,
            'vendor_id' => Auth::guard('vendor')->user()->id,
            'message' => $request->message,
        ]);

        broadcast(new ChatMessageSent($chat))->toOthers();

        return response()->json(['success' => true, 'message' => $chat]);
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
