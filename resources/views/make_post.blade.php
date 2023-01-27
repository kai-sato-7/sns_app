<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
            <div class="sm:max-w-lg mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                <div class="py-6 text-center">
                    <form method="POST" action="{{ route('posts.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('patch')
                        <input class="w-full" type="file" accept=".jpg,.jpeg,.png,.bmp,.gif,.svg,.webp" name="file"></input>
                        <x-input-error :messages="$errors->makePost->get('file')" class="mt-2"/>
                        <textarea class="block mt-2" cols="50" rows="5" maxlength="255" name="text"></textarea>
                        <x-input-error :messages="$errors->makePost->get('text')" class="mt-2"/>
                        <br>
                        <x-primary-button style="font-size:1em;" name="action" value="cancel">{{ __('Cancel') }}</x-primary-button>
                        <x-primary-button style="font-size:1em;" name="action" value="make_post">{{ __('Make Post') }}</x-primary-button>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>