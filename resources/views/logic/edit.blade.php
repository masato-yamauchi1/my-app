<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <p class="mb-4">ロジック新規作成画面です。</p>
                    <p class="mb-4"><span class="text-red-600">*</span>のものは必須です。</p>
                    
                    <form action="/logic/{{$logic_lists->id}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <table class="table-auto w-full">
                        <tr class="bg-gray-200">
                            <th class="border px-4 py-2">
                                タイトル<span class="text-red-600">*</span>
                            </th>
                            <th class="border px-4 py-2">
                                有効 無効<span class="text-red-600">*</span>
                            </th>
                            <th class="border px-4 py-2">
                                メインインジケーター<span class="text-red-600">*</span>
                            </th>
                            <th class="border px-4 py-2">
                                サブインジケーター
                            </th>
                        </tr>
                        <tr>
                            <td class="border px-4 py-2">
                                <input type="text" id="title" name="title" maxlength="50" value="{{$logic_lists->title}}" class="rounded border-gray-300 w-full" />
                            </td>
                            <td class="border px-4 py-2">
                                <select name="active" class="rounded border-gray-300">
                                    @if($logic_lists->active == 1)
                                    <option value="1" selected>有効</option>
                                    <option value="0">無効</option>
                                    @else
                                    <option value="1">有効</option>
                                    <option value="0" selected>無効</option>
                                    @endif
                                </select>
                            </td>
                            <td class="border px-4 py-2">
                                
                                @if ($now_main_indicator_sts)
                                <select name="main_indicator_id" class="rounded border-gray-300">
                                    @foreach ($indicator_lists as $item)
                                        @if($item->id == $logic_lists->main_indicator_id)
                                        <option value="{{$item->id}}" selected>{{$item->indicator_name}}</option>
                                        @else
                                        <option value="{{$item->id}}">{{$item->indicator_name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @else
                                    カテゴリが無効化、もしくは削除されているためカテゴリ管理を確認してください。
                                @endif
                            </td>
                            <td class="border px-4 py-2">
                                @if ($now_sub_indicator_sts)
                                <select name="sub_indicator_id" class="rounded border-gray-300">
                                    @foreach ($indicator_lists as $item)
                                        @if($item->id == $logic_lists->sub_indicator_id)
                                        <option value="{{$item->id}}" selected>{{$item->indicator_name}}</option>
                                        @else
                                        <option value="{{$item->id}}">{{$item->indicator_name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @else
                                    カテゴリが無効化、もしくは削除されているためカテゴリ管理を確認してください。
                                @endif
                            </td>
                        </tr>
                        <tr class="bg-gray-200">
                            <th class="border px-4 py-2">
                                グラフイメージファイル<span class="text-red-600">*</span>
                            </th>
                            <th  class="border px-4 py-2" colspan="3">
                                バックテストイメージファイル<span class="text-red-600">*</span>
                            </th>
                        </tr>
                        <tr>
                            <td class="border px-4 py-2" style="vertical-align: bottom;">
                                <input type="hidden" name="now_graph_img_name" value="{{$logic_lists->graph_img_name}}"> 
                                <img src="{{ Storage::url($logic_lists->graph_img_name)}}" width="80%" height="80%">
                                <input type="file" name="graph_img_name">
                            </td>
                            <td class="border px-4 py-2" colspan="3" style="vertical-align: bottom;">
                            <input type="hidden" name="now_result_img_name" value="{{$logic_lists->result_img_name}}"> 
                                <img src="{{ Storage::url($logic_lists->result_img_name)}}" width="80%" height="80%">
                                <input type="file" name="result_img_name">
                            </td>
                        </tr>
                        <tr  class="bg-gray-200">
                            <th class="border px-4 py-2" colspan="4">
                                ロジック内容
                            </th>
                        </tr>
                        <tr>
                            <td class="border px-4 py-2"  colspan="4">
                                <textarea id="logic_body" name="logics_body" class="rounded border-gray-300 w-full" rows="10">{{$logic_lists->logics_body}}</textarea>
                            </td>
                        </tr>
                    </table>
                    <div class="mt-4">
                        <input type="submit" value="更新する" class="bg-gray-900 hover:bg-gray-700 text-white rounded px-4 py-2" />
                    </div>
                    @if(count($errors) > 0)
                        @foreach ($errors->all() as $error)
                        <p class="text-red-600 mt-4">{{$error}}</p>
                        @endforeach
                    @endif

                    @if($update_error)
                        <p class="text-red-600 mt-4">{{$update_error}}</p>
                    @endif
                    </form>

                    <div class="mt-10">
                        <form action="/logic/{{$logic_lists->id}}" method="post">
                        @csrf
                        @method('DELETE')
                            <input type="submit" value="削除する" class="bg-gray-900 hover:bg-gray-700 text-white rounded px-4 py-2" onclick="return window.confirm('削除しますか？');" />
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>