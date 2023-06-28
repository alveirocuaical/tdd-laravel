<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel- home</title>
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    </head>
    <body class="bg-gray-200">
        <ul class="max-w-lg bg-white bortder-r border-gray-300 shadow-1">
            @foreach ($repositories as $repository)
                <li class="felx items-center text-black p-2 hover:bg-gray-300">
                    <img src="{{ $repository->user->profile_photo_url }}" class="w-12 h-12 rounded-full mr-2 " alt="">
                    <div class="flex justify-between w-full">
                      <div class="flex-1">
                        <h2 class="text-sm font-semibold text-black">{{ $repository->url }}</h2>
                        <p>{{ $repository->descripcion }}</p></div>
                      <span>{{ $repository->created_at }}</span>
                    </div>
                </li>

             @endforeach

        </ul>
    </body>
</html>
