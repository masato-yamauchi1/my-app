<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <p class="mb-4">ロジック管理です。</p>
                    <div class="mb-4">
                        <input type="button" value="新規作成こちら" class="bg-gray-900 hover:bg-gray-700 text-white rounded px-4 py-2" onclick="location.href='/logic/create'">
                    </div>
                    @if ($logic_lists->isNotEmpty())
                    <table class="table-auto">
                        <thead>
                        <tr class="bg-gray-200">
                            <th class="border px-4 py-2" style="width:10%">
                                ロジックID
                            </th>
                            <th class="border px-4 py-2" style="width:16%">
                                タイトル
                            </th>
                            <th class="border px-4 py-2">
                                有効 無効
                            </th>
                            <th class="border px-4 py-2">
                                メインインジケーター
                            </th>
                            <th class="border px-4 py-2">
                                サブインジケーター
                            </th>
                            <th class="border px-4 py-2">
                                グラフ
                            </th>
                        </tr>
                        </thead>
                    @foreach ($logic_lists as $item)
                        <tr>
                            <td class="border px-4 py-2">{{ $item->id }}</td>
                            <td class="border px-4 py-2">
                                <a href="/logic/{{ $item->id }}/edit/" style="text-decoration:underline;">{{ $item->title }}</a>
                            </td>
                            <td class="border px-4 py-2">
                            @if($item->active == 1) 
                                有効
                            @else 
                                無効
                            @endif
                            </td>
                            <td class="border px-4 py-2">
                                {{ $item->main_indicator_name }}
                            </td>
                            <td class="border px-4 py-2">
                                {{ $item->sub_indicator_name }}
                            </td>
                            <td class="border px-4 py-2">
                            <img src="{{ Storage::url($item->graph_img_name) }}" width="80%" height="80%">
                            </td>
                        </tr>
                    @endforeach
                    
                    </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>