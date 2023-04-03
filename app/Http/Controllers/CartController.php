<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use Illuminate\Support\Facades\DB;
use App\Models\History;
use App\Models\Management;
use App\Models\Item;


class CartController extends Controller
{
    public function cartList(Request $request)
    {
        $user = $request['user_id'];
        // $cart = new Cart();
        // $data = $cart ->where('user_id',$user) -> get();
        // return response() -> json($data);

        $results = DB::table('carts')
            ->select('item_price', 'item_total_num', 'item_image', 'item_detail', 'item_id', 'item_name', 'user_id', DB::raw('SUM(item_num) as item_count'), DB::raw('SUM(item_price * item_num) as total'))
            ->where('user_id', $user)
            ->where('cart_flg', 0)
            ->groupBy('item_price', 'item_total_num', 'item_id', 'item_name', 'user_id', 'item_image', 'item_detail', 'cart_flg')
            ->get();
        return response()->json($results);
    }

    public function add(Request $request)
    {
        $cartData = Cart::where('cart_flg', 0)
            ->where('item_id', $request['item_id'])
            ->where('user_id', $request['user_id'])
            ->first();

        if ($cartData) {
            // データが存在する場合は更新
            $cartData->item_num += $request['item_num'];
            $query = $cartData->save();
        } else {
            // データが存在しない場合は新規作成
            $cartData = new Cart();
            $cartData->item_name = $request['item_name'];
            $cartData->item_id = $request['item_id'];
            $cartData->item_price = $request['item_price'];
            $cartData->item_image = $request['item_image'];
            $cartData->item_detail = $request['item_detail'];
            $cartData->item_num = $request['item_num'];
            $cartData->item_total_num = $request['item_total_num'];
            $cartData->user_id = $request['user_id'];
            $query = $cartData->save();
        }

        return response()->json($query);
    }

    public function changeCart(Request $request)
    {
        $item_id = $request->input('item_id');
        $user_id = $request->input('user_id');
        $item_num = $request->input('item_num');

        $cart = Cart::where('item_id', $item_id)
            ->where('cart_flg', 0)
            ->where('user_id', $user_id)
            ->first();

        if ($cart) {
            $cart->item_num = $item_num;
            $result = $cart->save();
            return response()->json($result);
        } else {
            return response()->json(['message' => 'Cart not found.']);
        }
    }

    public function deleteCart(Request $request)
    {
        $user_id = $request['user_id'];
        $item_id = $request['item_id'];

        $cart = Cart::where('item_id', $item_id)
            ->where('cart_flg', 0)
            ->where('user_id', $user_id)
            ->first();

        $cart->cart_flg = 1;
        $result = $cart->save();
        return response()->json($result);
    }

    public function buy(Request $request)
    {
        $item_id = $request->input('item_id');
        $item_name = $request->input('item_name');
        $user_id = $request->input('user_id');
        $total = $request->input('total_price');
        $count = $request->input('item_count');
        $item_num = $request->input('item_num') - $count;

        $cart = Cart::where('user_id', $user_id)
            ->where('item_id', $item_id)
            ->where('cart_flg', 0)
            ->first();

        if ($cart) {
            $cart->delete();
        }

        $item = Item::where('item_id', $item_id)->first();
        $item_user_id = $item['user_id'];
        $num = $item->item_total_num;

        // アイテムの在庫数を更新
        $item->item_total_num = $num + $item_num;
        $item->save();

        // 購入履歴に追加
        $buyHistory = new History;
        $buyHistory->item_id = $item_id;
        $buyHistory->item_name = $item_name;
        $buyHistory->item_price = $total;
        $buyHistory->buy_num = $count;
        $buyHistory->user_id = $user_id;
        $buyHistory->save();

        // 管理情報に追加
        $management = new Management;
        $management->item_id = $item_id;
        $management->item_name = $item_name;
        $management->item_price = $total;
        $management->buy_num = $count;
        $management->user_id = $item_user_id;
        $management->save();

        return response()->json(['status' => 'success']);
    }
}
