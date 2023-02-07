<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Post') }}
        </h2>
    </x-slot>
    <div class="py-2">
        <div class="mx-auto bg-white overflow-hidden shadow-sm sm:rounded-lg" style="max-width:50rem;">
            <div class="p-4">
                {{ $post['username'] }}
                <h1 class="text-xl text-center text-gray-800">
                    {{ $post['title'] }}
                </h1>
                <div class="py-2">
                    @if (!empty($post['file_name']))
                        <img src="{{ asset('storage/images/'.$post['file_name']) }}" style="margin:auto;" width="500rem">
                    @endif
                    @if (!empty($post['content']))
                        {{ $post['content'] }}
                        <br>
                    @endif
                    <br>
                    {{ $post['total_likes'] }}
                    @if ($post['total_likes'] != 1)
                        {{ __('likes,') }}
                    @else
                        {{ __('like,') }}
                    @endif
                    {{ $post['total_dislikes'] }}
                    @if ($post['total_dislikes'] != 1)
                        {{ __('dislikes') }}
                    @else
                        {{ __('dislike') }}
                    @endif
                    <br>
                    @if (!is_null($post['like']))
                        @if ($post['like'])
                            {{ __('Liked') }}
                        @else
                            {{ __('Disliked') }}
                        @endif
                    @endif
                    <form method="POST" action="{{ route('post_reactions.update', ['id' => $post['id']]) }}" style="display:inline;">
                        @csrf
                        @method('patch')
                        <x-primary-button name="like" value="1">Like</x-primary-button>
                        <x-primary-button name="like" value="0">Dislike</x-primary-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @foreach ($comments as $comment)
        @include('components.comment', [
            'id' => $comment['id'],
            'username' => $comment['username'],
            'content' => $comment['content'],
            'like' => $comment['like'],
            'total_likes' => $comment['total_likes'],
            'total_dislikes' => $comment['total_dislikes'],
            'indentation' => $comment['indentation'],
        ])
        @if ($comment['indentation'] < 10)
            <x-modal name="make-comment-{{ $comment['id'] }}" :show="$errors->makeComment->isNotEmpty()" focusable>
                <form method="POST" action="{{ route('comments.update', ['post_id' => $post['id'], 'parent_id' => $comment['id']]) }}" class="p-6">
                    @csrf
                    @method('patch')
                    <h2 class="text-lg font-medium text-gray-900">
                        {{ __('Reply') }}
                    </h2>

                    <div class="mt-6">
                        <textarea name="content" class="mt-1" cols="50" rows="5" maxlength="1000"></textarea>
                        <x-input-error :messages="$errors->makeComment->get('content')" class="mt-2" />
                    </div>

                    <div class="mt-6 flex justify-end">
                        <x-secondary-button x-on:click="$dispatch('close')">
                            {{ __('Cancel') }}
                        </x-secondary-button>

                        <x-primary-button class="ml-3">
                            {{ __('Reply') }}
                        </x-primary-button>
                    </div>
                </form>
            </x-modal>
        @endif
    @endforeach
    <div class="py-6 text-center">
        <x-primary-button style="font-size:1em;" x-data="" x-on:click.prevent="$dispatch('open-modal', 'make-comment')">Comment</x-primary-button>
    </div>
    <x-modal name="make-comment" :show="$errors->makeComment->isNotEmpty()" focusable>
        <form method="POST" action="{{ route('comments.update', ['post_id' => $post['id'], 'parent_id' => -1]) }}" class="p-6">
            @csrf
            @method('patch')
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Comment') }}
            </h2>

            <div class="mt-6">
                <textarea name="content" class="mt-1" cols="50" rows="5" maxlength="1000"></textarea>
                <x-input-error :messages="$errors->makeComment->get('content')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-primary-button class="ml-3">
                    {{ __('Comment') }}
                </x-primary-button>
            </div>
        </form>
    </x-modal>
</x-app-layout>
