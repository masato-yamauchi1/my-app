<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TopController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //クエリービルダー確認用
        //\DB::enableQueryLog();
        $data_list = DB::table('logics as a')
            ->leftJoin('indicators as b', 'a.main_indicator_id', '=', 'b.id')
            ->leftJoin('indicators as c', 'a.sub_indicator_id', '=', 'c.id')
            ->select('a.*', 'b.indicator_name as main_indicator_name','c.indicator_name as sub_indicator_name','b.indicator_body as main_ing_body','c.indicator_body as sub_ing_body')
            ->where('a.active', '=', 1)
            ->where(function ( $query) {
                $query->where('b.active', '=', 1)
                      ->orwhereNull('b.active');
            })
            ->where(function ( $query) {
                $query->where('c.active', '=', 1)
                      ->orwhereNull('c.active');
            })
            ->get();
        //dd(\DB::getQueryLog());
        return view('top' , ['data_list' => $data_list]);
    }
}
