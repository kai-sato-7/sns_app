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
            'id' => $post['id'],
            'username' =>$post['username'],
            'title' => $post['title'],
            'content' => $post['content'],
            'file_name' => $post['file_name'],
            'like' => $post['like'],
            'total_likes' => $post['total_likes'],
            'total_dislikes' => $post['total_dislikes'],
            'timestamp' => $post['created_at'],
        ])
        <div class="text-center">
            <x-primary-button style="font-size:1em;" x-data="{{ $post['new_id'] }}" x-on:click.prevent="$dispatch('open-modal', 'remove-post-{{ $post['new_id'] }}')">{{ __('Remove') }}</x-primary-button>
        </div>
    @endforeach

    @foreach ($posts as $post)
        <x-modal name="remove-post-{{ $post['new_id'] }}" focusable>
            <form method="POST" action="{{ route('posts.destroy', ['id' => $post['new_id']]) }}" class="p-6">
                @csrf
                @method('delete')
                <h2 class="text-lg font-medium text-gray-900">
                    {{ __('Are you sure you want to delete your post?') }}
                </h2>

                <div class="mt-6 flex justify-end">
                    <x-secondary-button x-on:click="$dispatch('close')">
                        {{ __('Cancel') }}
                    </x-secondary-button>

                    <x-primary-button class="ml-3">
                        {{ __('Delete Post') }}
                    </x-primary-button>
                </div>
            </form>
        </x-modal>
    @endforeach
</x-app-layout>
