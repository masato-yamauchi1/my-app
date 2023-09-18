<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <p class="mb-4">ロジック新規作成画面です。</p>
                    <p class="mb-4"><span class="text-red-600">*</span>のものは必須です。</p>
                    
                    <form action="/logic/" method="post" enctype="multipart/form-data">
                    @csrf
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
                                <input type="text" id="title" name="title" maxlength="50" class="rounded border-gray-300 w-full" />
                            </td>
                            <td class="border px-4 py-2">
                                <select name="active" class="rounded border-gray-300">
                                    <option value="1">有効</option>
                                    <option value="0">無効</option>
                                </select>
                            </td>
                            <td class="border px-4 py-2">
                                @if ($indicator_lists->isNotEmpty())
                                <select name="main_indicator_id" class="rounded border-gray-300">
                                    @foreach ($indicator_lists as $item)
                                    <option value="{{$item->id}}">{{$item->indicator_name}}</option>
                                    @endforeach
                                </select>
                                @else
                                    インジケーター管理でインジケーターを登録してください
                                @endif
                            </td>
                            <td class="border px-4 py-2">
                                @if ($indicator_lists->isNotEmpty())
                                <select name="sub_indicator_id" class="rounded border-gray-300">
                                    @foreach ($indicator_lists as $item)
                                    <option value="{{$item->id}}">{{$item->indicator_name}}</option>
                                    @endforeach
                                </select>
                                @else
                                    インジケーター管理でインジケーターを登録してください
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
                            <td class="border px-4 py-2">
                                <input type="file" name="graph_img_name">
                            </td>
                            <td class="border px-4 py-2" colspan="3">
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
                                <textarea id="logic_body" name="logics_body" class="rounded border-gray-300 w-full" rows="10"></textarea>
                            </td>
                        </tr>
                    </table>
                    <div class="mt-4">
                        <input type="submit" value="登録する" class="bg-gray-900 hover:bg-gray-700 text-white rounded px-4 py-2" />
                    </div>
                    @if(count($errors) > 0)
                        @foreach ($errors->all() as $error)
                        <p class="text-red-600 mt-4">{{$error}}</p>
                        @endforeach
                    @endif

                    @if($insert_error)
                        <p class="text-red-600 mt-4">{{$insert_error}}</p>
                    @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>