<?php

namespace App\Http\Controllers;

use App\Models\History;
use App\Models\Management;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ManagementController extends Controller
{
    public function history(Request $request){
        $history = History::where('user_id',$request['user_id']) -> get();
        return response() -> json($history);
    }

    public function getHistory(Request $request)
{
    $month = $request['month'];
    $year = $request['year'];
    $user_id = $request['user_id'];

    $query = DB::table('histories')->where('user_id', $user_id);

    if ($month !== '' && $year !== '') {
        $data = $query->whereYear('created_at', $year)
              ->whereMonth('created_at', $month)->get();
    } elseif ($year !== '' && $month === '') {
        $data = $query->whereYear('created_at', $year)->get();
    } elseif ($year === '' && $month !== '') {
        $data = $query->whereRaw("MONTH(created_at) = ?", [$month])->get();
    }

    return response()->json($data);
    }

    public function management(Request $request){
        $history = Management::where('user_id',$request['user_id']) -> get();
        return response() -> json($history);
    }

    public function getManagement(Request $request)
    {
        $month = $request['month'];
        $year = $request['year'];
        $user_id = $request['user_id'];
    
        $query = DB::table('managements')->where('user_id', $user_id);
    
        if ($month !== '' && $year !== '') {
            $data = $query->whereYear('created_at', $year)
                  ->whereMonth('created_at', $month)->get();
        } elseif ($year !== '' && $month === '') {
            $data = $query->whereYear('created_at', $year)->get();
        } elseif ($year === '' && $month !== '') {
            $data = $query->whereRaw("MONTH(created_at) = ?", [$month])->get();
        }
    
        return response()->json($data);
    }
}
