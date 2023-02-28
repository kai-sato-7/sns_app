<div class="py-2">
    <div class="mx-auto bg-white overflow-hidden shadow-sm sm:rounded-lg" style="max-width:{{ 50 - $level * 2.5 }}rem; transform:translate({{ $level * 1.25 }}rem)">
        <div class="p-4">
            {{ $username }}
            <div class="py-2">
                @if (!empty($content))
                    {{ $content }}
                    <br>
                @endif
                <br>
                {{ $total_likes }}
                @if ($total_likes != 1)
                    {{ __('likes,') }}
                @else
                    {{ __('like,') }}
                @endif
                {{ $total_dislikes }}
                @if ($total_dislikes != 1)
                    {{ __('dislikes') }}
                @else
                    {{ __('dislike') }}
                @endif
                <br>
                @if (!is_null($like))
                    @if ($like)
                        {{ __('Liked') }}
                    @else
                        {{ __('Disliked') }}
                    @endif
                @endif
                <form method="POST" action="{{ route('comment_reactions.update', ['id' => $id]) }}" style="display:inline;">
                    @csrf
                    @method('patch')
                    <x-primary-button name="like" value="1">Like</x-primary-button>
                    <x-primary-button name="like" value="0">Dislike</x-primary-button>
                </form>
                @if ($level < 9)
                    <x-primary-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'make-comment-{{ $id }}')">Reply</x-primary-button>
                @endif
            </div>
        </div>
    </div>
</div>