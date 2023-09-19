<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Logic;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class LogicController extends Controller
{
   /**
     * インジケーター管理の表示
     * 引数：なし
     * 戻値：View
     */
    public function index(): View
    {
        $logic_lists = DB::table('logics as a')
            ->leftJoin('indicators as b', 'a.main_indicator_id', '=', 'b.id')
            ->leftJoin('indicators as c', 'a.sub_indicator_id', '=', 'c.id')
            ->select('a.*', 'b.indicator_name as main_indicator_name','c.indicator_name as sub_indicator_name')
            ->where(function ( $query) {
                $query->where('b.active', '=', 1)
                      ->orwhereNull('b.active');
            })
            ->where(function ( $query) {
                $query->where('c.active', '=', 1)
                      ->orwhereNull('c.active');
            })
            ->orderBy('a.id', 'asc')
            ->get();
        return view('logic.index', ['logic_lists' => $logic_lists]);
    }

    /**
     * 新規作成画面を表示
     * 引数：なし
     * 戻値：View
     */
    public function create(): View
    {
        $indicator_lists = DB::table('indicators')
            ->select('id','indicator_name')
            ->where('active', '=', 1)
            ->orderBy('id', 'asc')
            ->get();
        
        $insert_error = null;
        return view('logic.create' , compact('indicator_lists' , 'insert_error'));
    }

     /**
     * 登録処理
     * 引数：フォームリクエスト、（method:POST）
     * 戻値：エラーがあればエラー内容、正常処理なら一覧画面へリダイレクト
     */
    public function store(Request $request)
    {
        $rules = [
            'title' => 'required|max:50',
            'active' => 'required',
            'main_indicator_id' => 'required',
            'graph_img_name' => 'required|mimes:jpeg,png,jpg,svg',
            'result_img_name' => 'required|mimes:jpeg,png,jpg,svg',
        ];

        $messages = [
            'title.required' => 'タイトルは必須項目です', 
            'title.max' => 'タイトルは50文字以下にしてください。' ,
            'active.required' => '有効無効は必須項目です',
            'graph_img_name.required' => 'グラフイメージは必須項目です',
            'graph_img_name.mimes' => 'グラフイメージのファイル拡張子が画像ではありません。',
            'result_img_name.required' => 'バックテストメージは必須項目です',
            'result_img_name.mimes' => 'バックテストメージのファイル拡張子が画像ではありません。',
        ];

        Validator::make($request->all(), $rules, $messages)->validate();

        $img = $request->file('graph_img_name');
        // storage > public > images配下に画像が保存される
        $graph_img_name_path = $img->store('images','public');
        
        $img = $request->file('result_img_name');
        // storage > public > images配下に画像が保存される
        $result_img_name_path = $img->store('images','public');
        
        $user = Auth::user();
        $user_name = $user->name;
        
        try {
            DB::transaction(function () use (&$request,$user_name,$graph_img_name_path,$result_img_name_path) {
                $logic = new Logic();
                
                $logic->title = $request->input('title');
                $logic->graph_img_name = $graph_img_name_path;
                $logic->result_img_name = $result_img_name_path;
                $logic->main_indicator_id = $request->input('main_indicator_id');
                $logic->sub_indicator_id = $request->input('sub_indicator_id');
                $logic->logics_body = $request->input('logics_body');
                $logic->last_user = $user_name;
                $logic->created_at = now();
                $logic->updated_at = null;
                $logic->active = $request->input('active');
                $logic->save();
            });
        } catch (\Exception $e) {
            Log::error($e);
            //dd($e);
            return view('logic.create')->with('insert_error','登録失敗しロールバックしました。');
        }
        return redirect('/logic/');
    }

    /**
     * 更新画面の表示
     * 引数：ID
     * 戻値：View
     */
    public function edit($id): View
    {
        $indicator_lists = DB::table('indicators')
            ->select('id','indicator_name')
            ->where('active', '=', 1)
            ->orderBy('id', 'asc')
            ->get();
        $now_main_indicator_sts = null;
        $now_sub_indicator_sts = null;
        $logic_lists = Logic::find($id);
        $update_error = null;
        $logic_id = $id;

        //カテゴリの存在をチェック
        for ($i =0; $i < count($indicator_lists); $i ++) {
            if ($indicator_lists[$i]->id == $logic_lists->main_indicator_id){
                $now_main_indicator_sts = true;
            };
            if ($indicator_lists[$i]->id == $logic_lists->sub_indicator_id){
                $now_sub_indicator_sts = true;
            };
        }

        return view('logic.edit' , compact(
            'indicator_lists',
            'logic_lists',
            'update_error' ,
            'logic_id',
            'now_main_indicator_sts',
            'now_sub_indicator_sts'
        ));
    }

    /**
     * 更新処理
     * 引数：フォームリクエスト、ID、（method:PUT）
     * 戻値：エラーがあればエラー内容、正常処理なら一覧画面へリダイレクト
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'title' => 'required|max:50',
            'active' => 'required',
            'main_indicator_id' => 'required',
            'graph_img_name' => 'mimes:jpeg,png,jpg,svg',
            'result_img_name' => 'mimes:jpeg,png,jpg,svg',
        ];

        $messages = [
            'title.required' => 'タイトルは必須項目です', 
            'title.max' => 'タイトルは50文字以下にしてください。' ,
            'active.required' => '有効無効は必須項目です',
            'graph_img_name.mimes' => 'グラフイメージのファイル拡張子が画像ではありません。',
            'result_img_name.mimes' => 'バックテストメージのファイル拡張子が画像ではありません。',
        ];

        Validator::make($request->all(), $rules, $messages)->validate();

        //新しい画像があれば削除
        if ($request->file('graph_img_name')){
            if (Storage::disk('public')->exists($request->now_graph_img_name)){
                \Storage::disk('public')->delete($request->now_graph_img_name);  
            }
            $img = $request->file('graph_img_name');
            $graph_img_name_path = $img->store('images','public');
        } else {
            $graph_img_name_path = $request->now_graph_img_name;
        }

        if ($request->file('result_img_name')){
            if (Storage::disk('public')->exists($request->now_result_img_name)){
                \Storage::disk('public')->delete($request->now_result_img_name);  
            }
            $img = $request->file('result_img_name');
            $result_img_name_path = $img->store('images','public');
        } else {
            $result_img_name_path = $request->now_result_img_name;
        }

        $user = Auth::user();
        $user_name = $user->name;
        try {
            DB::transaction(function () use (&$request,$user_name,$id,$graph_img_name_path,$result_img_name_path) {
                $logic = Logic::find($id);
                $logic->title = $request->input('title');
                $logic->graph_img_name = $graph_img_name_path;
                $logic->result_img_name = $result_img_name_path;
                $logic->main_indicator_id = $request->input('main_indicator_id');
                $logic->sub_indicator_id = $request->input('sub_indicator_id');
                $logic->logics_body = $request->input('logics_body');
                $logic->last_user = $user_name;
                $logic->updated_at = now();
                $logic->active = $request->input('active');
                $logic->save();
            });
        } catch (\Exception $e) {
            Log::error($e);

            $logic_lists = Logic::find($id);
            $update_error = '更新に失敗しロールバックしました。';
            $logic_id = $id;
            return view('logic.edit' , compact('logic_lists','update_error' ,'logic_id'));
        }
        return redirect('/logic/');
    }

    /**
     * 削除処理（物理削除）正常処理なら一覧画面へリダイレクト
     * 引数：ID、（method:DELETE）
     * 戻値：なし
     */
    public function destroy($id)
    {
        $logic = Logic::find($id);
        //画像削除
        if (Storage::disk('public')->exists($logic->graph_img_name)){
            \Storage::disk('public')->delete($logic->graph_img_name);  
        }
        
        if (Storage::disk('public')->exists($logic->result_img_name)){
            \Storage::disk('public')->delete($logic->result_img_name);  
        }

        $logic->delete();
        return redirect('/logic/');
    }
}
