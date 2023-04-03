<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat;
use App\Models\Board;

class ChatController extends Controller
{
    public function createChat(Request $request)
    {
        $chat = new Chat();
        $chat->item_name = $request['item_name'];
        $chat->item_detail = $request['item_detail'];
        $chat->item_image = $request['item_image'];
        $chat->item_price = $request['item_price'];
        $chat->item_id = $request['item_id'];
        $chat->user_id = $request['user_id'];
        $chat->user_name = $request['user_name'];
        $chat->chat_user_id = $request['chat_user_id'];
        $chat->chat_user_name = $request['chat_user_name'];
        $chat->buy_flg = $request['flg'];

        $query = $chat->save();
        return response()->json($query);
    }

    public function chatList(Request $request)
    {
        $chat_list = Chat::where('user_id', $request['user_id'])->orWhere('chat_user_id', $request['user_id'])->get();
        return response()->json($chat_list);
    }

    public function chatDetail(Request $request)
    {
        $detail = Board::where('chat_id', $request['chat_id'])->get();
        return response()->json($detail);
    }

    public function addChat(Request $request)
    {
        $add = new Board();
        $add->chat_id = $request['chat_id'];
        $add->user_name = $request['user_name'];
        $add->board = $request['chat'];
        $add->user_id = $request['user_id'];
        $addResult = $add->save();
        if ($addResult === true) {
            $data = Board::where('chat_id', $add->chat_id)->get();
            return response()->json($data);
        }
    }
}
