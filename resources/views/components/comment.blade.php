<div class="py-2">
    <div class="mx-auto bg-white overflow-hidden shadow-sm sm:rounded-lg" style="max-width:{{ 50 - $indentation * 2.5 }}rem; transform:translate({{ $indentation * 1.25 }}rem)">
        <div class="p-4">
            {{ _('(') }}{{ $total_likes }}{{ _(') ') }}{{ $username }}
            <div class="py-2">
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
                <form method="POST" action="{{ route('comment_reactions.update') }}?id={{ $id }}" style="display:inline;">
                    @csrf
                    @method('patch')
                    <x-primary-button name="like" value="1">Like</x-primary-button>
                    <x-primary-button name="like" value="0">Dislike</x-primary-button>
                </form>
                @if ($indentation < 10)
                    <x-primary-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'make-comment-{{ $id }}')">Reply</x-primary-button>
                @endif
            </div>
        </div>
    </div>
</div>