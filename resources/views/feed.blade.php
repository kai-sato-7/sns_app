<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Feed') }}
        </h2>
    </x-slot>

    @foreach ($posts as $post)
        @include('components.post', [
            'id' => $post->id,
            'username' =>$post->username,
            'title' => $post->title,
            'content' => $post->content,
            'file_name' => $post->file_name,
            'like' => $post->like,
            'total_likes' => $post->total_likes,
            'total_dislikes' => $post->total_dislikes,
        ])
    @endforeach
</x-app-layout>
