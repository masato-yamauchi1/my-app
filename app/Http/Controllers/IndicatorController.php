<?php

namespace App\Http\Controllers;
/*
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Redirect;
*/
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Indicator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class IndicatorController extends Controller
{
    /**
     * インジケーター管理の表示
     */
    public function index()
    {
        $indicator_lists = Indicator::all();
        return view('indicator.index', ['indicator_lists' => $indicator_lists]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        return view('indicator.create')->with('insert_error',null);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        echo "a";
        exit;
    }

     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'indicator_name' => 'required|max:50',
            'active' => 'required',
        ];

        $messages = [
            'indicator_name.required' => 'インジケーター名は必須項目です', 
            'indicator_name.max' => 'インジケーター名は50文字以下にしてください。' ,
            'active.required' => '必須項目です',
        ];

        Validator::make($request->all(), $rules, $messages)->validate();

        $user = Auth::user();
        $user_name = $user->name;
        
        try {
            DB::transaction(function () use (&$request,$user_name) {
                $indicator = new Indicator();
                
                $indicator->indicator_name = $request->input('indicator_name');
                $indicator->indicator_body = $request->input('indicator_body');
                $indicator->last_user = $user_name;
                $indicator->created_at = now();
                $indicator->updated_at = null;
                $indicator->active = $request->input('active');
                $indicator->save();
            });
        } catch (\Exception $e) {
            Log::error($e);
            return view('indicator.create')->with('insert_error','登録失敗しロールバックしました。');
        }
        return redirect('/indicator/');
    }

}
