<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <p class="mb-4">インジケーター管理です。</p>
                    <div class="mb-4">
                        <input type="button" value="新規作成こちら" class="bg-gray-900 hover:bg-gray-700 text-white rounded px-4 py-2" onclick="location.href='/indicator/create'">
                    </div>
                    @if ($indicator_lists->isNotEmpty())
                    <table class="table-auto">
                        <thead>
                        <tr class="bg-gray-200">
                            <th class="border px-4 py-2">
                                インジケーターID
                            </th>
                            <th class="border px-4 py-2">
                                インジケーター名
                            </th>
                            <th class="border px-4 py-2">
                                有効 無効
                            </th>
                        </tr>
                        </thead>
                    @foreach ($indicator_lists as $item)
                        <tr>
                            <td class="border px-4 py-2">{{ $item->indicators_id }}</td>
                            <td class="border px-4 py-2">
                                <a href="/indicator/{{ $item->indicators_id }}/edit/" style="text-decoration:underline;">{{ $item->indicator_name }}</a>
                            </td>
                            <td class="border px-4 py-2">
                            @if($item->active == 1) 
                                有効
                            @else 
                                無効
                            @endif
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