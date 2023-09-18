<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <p class="mb-4">インジケーター編集画面です。</p>
                    <p class="mb-4"><span class="text-red-600">*</span>のものは必須です。</p>
                    
                    @if ($indicator_lists->id)
                    
                    <form action="/indicator/{{$indicator_lists->id}}" method="post">
                    @csrf
                    @method('PUT')
                    <table class="table-auto w-full">
                        <thead>
                        <tr class="bg-gray-200">
                            <th class="border px-4 py-2" style="width:30%">
                                インジケーター名<span class="text-red-600">*</span>
                            </th>
                            <th class="border px-4 py-2" style="width:10%">
                                有効 無効<span class="text-red-600">*</span>
                            </th>
                            <th class="border px-4 py-2" style="width:60%">
                                インジケーターの内容
                            </th>
                        </tr>
                        </thead>
                        <tr>
                            <td class="border px-4 py-2">
                                <input type="text" id="indicator_name" name="indicator_name" maxlength="50" class="rounded border-gray-300 w-full" value="{{$indicator_lists->indicator_name}}" />
                            </td>
                            <td class="border px-4 py-2">
                                <select name="active" class="rounded border-gray-300">
                                    @if($indicator_lists->active == 1)
                                    <option value="1" selected>有効</option>
                                    <option value="0">無効</option>
                                    @else
                                    <option value="1">有効</option>
                                    <option value="0" selected>無効</option>
                                    @endif
                                </select>
                            </td>
                            <td class="border px-4 py-2">
                            <textarea id="indicator_body" name="indicator_body" class="rounded border-gray-300 w-full">{{$indicator_lists->indicator_body}}</textarea>
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
                        <form action="/indicator/{{$indicator_lists->id}}" method="post">
                        @csrf
                        @method('DELETE')
                            <input type="submit" value="削除する" class="bg-gray-900 hover:bg-gray-700 text-white rounded px-4 py-2" />
                        </form>
                    </div>
                    
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>