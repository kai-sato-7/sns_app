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

    @foreach ($posts as $post)
        @include('components.post', [
            'post_id' => $post->id,
            'username' =>$post->username,
            'title' => $post->title,
            'content' => $post->content,
            'file_name' => $post->file_name,
        ])
    @endforeach
</x-app-layout>
