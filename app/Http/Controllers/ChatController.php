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

    // Customer Chat Functionality *********************************************************************
    private function generateCommonChatId($userId, $vendorId)
    {     
        return 'c_id'. $userId . '-' . 'v_id' . $vendorId;
    }

    public function getCustomerChat($vendor_id)
    {
        $vendor = Vendor::findOrFail($vendor_id);
   
        $common_chat_id = $this->generateCommonChatId(Auth::guard('web')->user()->id, $vendor_id);
        // dd($common_chat_id);
        $messages = Chat::where('user_id', Auth::guard('web')->user()->id)
            ->where('vendor_id', $vendor_id)
            ->get();

        return view('front.customer.chat', compact('messages', 'vendor', 'common_chat_id'));
    }

   

    public function sendCustomerMessage(Request $request)
    {
        $chat = Chat::create([
            'user_id' => Auth::guard('web')->user()->id,
            'vendor_id' => $request->vendor_id,
            'common_chat_id' => $this->generateCommonChatId(Auth::guard('web')->user()->id, $request->vendor_id),
            'sender_id' => Auth::guard('web')->user()->id,
            'receiver_id' => $request->vendor_id,
            'sender' => 'customer',
            'message' => $request->message,
        ]);

        broadcast(new ChatMessageSent($chat))->toOthers();

        return response()->json(['success' => true, 'message' => $chat]);
    }

    // Vendor Chat Functionality *********************************************************************
    public function getVendorChat($user_id)
    {
        $user = User::findOrFail($user_id);
     
        $vendor = auth('vendor')->user();
        $common_chat_id = $this->generateCommonChatId($user_id, $vendor->id);
        // dd($common_chat_id);
        $messages = Chat::where('user_id', $user_id)
            ->where('vendor_id', $vendor->id)->get();

        return view('front.vendor.chat', compact('messages', 'vendor', 'user', 'common_chat_id'));
    }

    public function sendVendorMessage(Request $request)
    {
        $chat = Chat::create([
            'user_id' => $request->user_id,
            'vendor_id' => Auth::guard('vendor')->user()->id,
            'common_chat_id' => $this->generateCommonChatId($request->user_id, Auth::guard('vendor')->user()->id),
            'sender_id' => Auth::guard('vendor')->user()->id,
            'receiver_id' => $request->user_id,
            'sender' => 'vendor',
            'message' => $request->message,
        ]);

        broadcast(new ChatMessageSent($chat))->toOthers();

        return response()->json(['success' => true, 'message' => $chat]);
    }
}
