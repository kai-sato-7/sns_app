<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Friends') }}
        </h2>
    </x-slot>

    @foreach ($posts as $post)
        @include('components.post', [
            'post_id' => $post['id'],
            'username' => $post['username'],
            'title' => $post['title'],
            'content' => $post['content'],
            'file_name' => $post['file_name'],
        ])
    @endforeach

</x-app-layout>
