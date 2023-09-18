<?php

namespace App\Http\Controllers;

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
     * 引数：なし
     * 戻値：View
     */
    public function index(): View
    {
        $indicator_lists = Indicator::all();
        return view('indicator.index', ['indicator_lists' => $indicator_lists]);
    }

    /**
     * 新規作成画面を表示
     * 引数：なし
     * 戻値：View
     */
    public function create(): View
    {
        return view('indicator.create')->with('insert_error',null);
    }

    /**
     * 更新画面の表示
     * 引数：ID
     * 戻値：View
     */
    public function edit($id): View
    {
        $indicator_lists = Indicator::find($id);
        $update_error = null;
        $indicator_id = $id;
        return view('indicator.edit' , compact('indicator_lists','update_error' ,'indicator_id'));
        
    }

     /**
     * 登録処理
     * 引数：フォームリクエスト、（method:POST）
     * 戻値：エラーがあればエラー内容、正常処理なら一覧画面へリダイレクト
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

    /**
     * 更新処理
     * 引数：フォームリクエスト、ID、（method:PUT）
     * 戻値：エラーがあればエラー内容、正常処理なら一覧画面へリダイレクト
     */
    public function update(Request $request, $id)
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
            DB::transaction(function () use (&$request,$user_name,$id) {
                $indicator = Indicator::find($id);
                $indicator->indicator_name = $request->input('indicator_name');
                $indicator->indicator_body = $request->input('indicator_body');
                $indicator->last_user = $user_name;
                $indicator->updated_at = now();
                $indicator->active = $request->input('active');
                $indicator->save();
            });
        } catch (\Exception $e) {
            Log::error($e);

            $indicator_lists = Indicator::find($id);
            $update_error = '更新に失敗しロールバックしました。';
            $indicator_id = $id;
            return view('indicator.edit' , compact('indicator_lists','update_error' ,'indicator_id'));
        }
        return redirect('/indicator/');
    }

    /**
     * 削除処理（物理削除）正常処理なら一覧画面へリダイレクト
     * 引数：ID、（method:DELETE）
     * 戻値：なし
     */
    public function destroy($id)
    {
        $indicator = Indicator::find($id);
        $indicator->delete();
        return redirect('/indicator/');
    }
}
