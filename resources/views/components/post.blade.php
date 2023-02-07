<div class="py-2">
    <div class="max-w-xl mx-auto bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-4">
            {{ _('(') }}{{ $total_likes }}{{ _(') ') }}{{ $username }}
            <h1 class="text-xl text-center text-gray-800">
                {{ $title }}
            </h1>
            <div class="py-2">
                @if (!empty($file_name))
                <img src="storage/images/{{ $file_name }}" style="margin:auto;" width="500rem">
                @endif
                @if (!empty($content))
                {{ $content }}
                <br>
                @endif
                <br>
                @if (!is_null($like))
                    @if ($like)
                        {{ __('Liked') }}
                    @else
                        {{ __('Disliked') }}
                    @endif
                @endif
                <form method="POST" action="{{ route('post_reactions.update') }}?id={{ $id }}" style="display:inline;">
                    @csrf
                    @method('patch')
                    <x-primary-button name="like" value="1">Like</x-primary-button>
                    <x-primary-button name="like" value="0">Dislike</x-primary-button>
                </form>
                <form method="GET" action="{{ route('post.edit', ['id' => $id]) }}" style="display:inline;">
                    <x-primary-button>Comment</x-primary-button>
                </form>
            </div>
        </div>
    </div>
</div>