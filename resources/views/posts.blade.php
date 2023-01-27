<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Posts') }}
        </h2>
    </x-slot>

    <form method="GET" action="{{ route('make_post') }}">
        <div class="py-6 text-center">
            <x-primary-button style="font-size:1em;">{{ __('Make Post') }}</x-primary-button>
        </div>
    </form>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>

    @foreach ($posts as $post)
        {{ $post->text }}<br>
        @if (!empty($post->image_path))
        {{ $post->image_path }}<br>
        @endif
        <br>
    @endforeach
</x-app-layout>
