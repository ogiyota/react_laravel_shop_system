<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GetFirstController extends Controller
{
    public function __invoke(Request $request)
    {
        return response()->json([
            'status' => "OK"
        ]);
    }
}
