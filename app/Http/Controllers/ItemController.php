<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class ItemController extends Controller
{
    public function getList()
    {
        $data = Item::all();
        return response()->json($data);
    }

    public function addProduct(Request $request)
    {
        $add = new Item();
        $add->item_name = $request['item_name'];
        $add->item_image = $request['item_image'];
        $add->item_detail = $request['item_detail'];
        $add->item_price = $request['item_price'];
        $add->item_num = 0;
        $add->item_total_num = $request['item_total_num'];
        $add->ctg_id = $request['ctg_id'];
        $add->user_id = $request['user_id'];
        $add->user_name = $request['user_name'];
        $addResult = $add->save();
        return response()->json($addResult);
    }

    public function uploadImage(Request $request)
    {
        if ($request->hasFile('item_image')) {
            $image = $request->file('item_image');
            $uploadPath = public_path('images/');
            if ($image->move($uploadPath, $image->getClientOriginalName())) {
                return response()->json($image->getClientOriginalName());
            } else {
                return response()->json(false);
            }
        }
    }

    public function addList(Request $request)
    {
        $list = Item::where('user_id', $request['user_id'])->get();
        return response()->json($list);
    }

    public function changeProduct(Request $request)
    {
        $item = new Item();
        $item = $item->find($request['item_id']);
        $item->item_id = $request['item_id'];
        $item->item_name = $request['item_name'];
        $item->item_image = $request['item_image'];
        $item->item_detail = $request['item_detail'];
        $item->item_price = $request['item_price'];
        $item->item_total_num = $request['item_total_num'];
        $item->ctg_id = $request['ctg_id'];
        $result = $item->save();
        return response()->json($result);
    }

    public function search(Request $request)
    {
        $query = $request->query('search');
        $category = $request->query('ctg');

        $items = Item::query();

        if ($query) {
            $items->where(function ($q) use ($query) {
                $q->where('item_name', 'LIKE', '%' . $query . '%')
                    ->orWhere('item_detail', 'LIKE', '%' . $query . '%');
            });
        }

        if ($category) {
            $items->where('ctg_id', $category);
        }

        $result = $items->get();

        return response()->json($result);
    }

    public function sortSearch(Request $request)
    {
        $sortctg = $request['sortctg'];
        $sortname = $request['sortname'];
        $ctg = $request['value'];
        $search = $request['search'];

        $query = new Item();

        if ($search !== null) {
            $query = Item::where(function ($q) use ($search) {
                $q->where('item_name', 'LIKE', "%{$search}%")
                    ->orWhere('item_detail', 'LIKE', "%{$search}%");
            });
            $query->orderBy($sortctg, $sortname);
            $results = $query->get()->toArray();
            return response()->json($results);
        }

        if ($ctg !== null) {
            $query = Item::where('ctg_id', $ctg);
            $query->orderBy($sortctg, $sortname);
            $data2 = $query->get()->toArray();
            return response()->json($data2);
        }

        if ($sortname !== '' && $ctg !== null && $search !== null) {
            $query = Item::where(function ($q) use ($search) {
                $q->where('item_name', 'LIKE', "%{$search}%")
                    ->orWhere('item_detail', 'LIKE', "%{$search}%");
            });
            $query->where('ctg_id', $ctg);
            $data2 = $query->get()->toArray();
            return response()->json(2);
        }

        if ($sortname !== '' && $ctg === null && $search === null) {
            $query = Item::all();
            $data2 = $query->orderBy($sortctg, $sortname);
            return response()->json(1);;
        }
    }
}
