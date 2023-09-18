<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <title>Laravelのテスト</title>

        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    </head>
    <body class="antialiased">
        <div class="relative items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
            @if (Route::has('login'))
                <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                    <header>
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Register</a>
                        @endif
                    @endauth
                    </header>
                </div>
            @endif
            <div class="py-12 ml-2 mr-2">
                <p class="text-sm text-gray-700 dark:text-gray-500">
                    <span class="text-red-600">このサイトはLrabel学習のために作成したテストサイトです。開発環境は以下のとおり。</span><br>
                    Windows10 wls2 Ubuntu Docker(Docker Desktop) Laravel10(PHP 8.2) + breeze nginx MySql8.1 phpmyadmin<br>
                    エディタはVisual Studio Code、ソース管理はgitを利用しています。
                </p>
                <h1 class="mt-8 text-gray-600 dark:text-gray-400 font-medium" style="font-size:24px;">各自インジケーターのバックテストによる検証結果</h1>
                @if ($data_list->isNotEmpty())
                    @foreach ($data_list as $item)
                <main>
                <h2 class="mt-8 text-gray-600 dark:text-gray-400 font-medium text-lg">{{ $item->title }}<h2>
                <div>
                    <img src="{{ Storage::url($item->graph_img_name) }}" width="90%" height="90%" class="border">
                </div>
                <p class="mt-2 text-sm text-gray-700 dark:text-gray-500">{!!  nl2br($item->logics_body) !!}</p>
                <div class="mt-2">
                    <img src="{{ Storage::url($item->result_img_name) }}" width="40%" height="40%" class="border">
                </div>
                <h3 class="mt-2 text-gray-600 dark:text-gray-400 font-medium text-lg">バックテストに用いた使用インジケーターについて</h3>
                <dl>
                    <dt class="mt-2 ml-2">メインインジケーター</dl>
                    <dd class="ml-2">{{ $item->main_indicator_name }}</dd>
                    <dd class="ml-2 mt-2 text-sm text-gray-700 dark:text-gray-500">{{$item->main_ing_body}}</dd>
                </dl>
                <dl>
                    <dt class="mt-2 ml-2">サブインジケーター</dl>
                    <dd class="ml-2">{{ $item->sub_indicator_name }}</dd>
                    <dd class="ml-2 mt-2 text-sm text-gray-700 dark:text-gray-500">{{$item->sub_ing_body}}</dd>
                </dl>
                @endforeach
                </main>
            @endif
            
            </div>
            <footer class="mt2 ml2 text-sm text-gray-700 dark:text-gray-500 px-2">© 2023 yamauchi</footer>
        </div>
    </body>
</html>
