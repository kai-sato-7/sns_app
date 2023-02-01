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
        <x-modal name="remove-post-{{ $post->title }}" focusable>
            <form method="post" action="{{ route('friends.destroy') }}?username={{ $post->id }}" class="p-6">
                @csrf
                @method('delete')
                <h2 class="text-lg font-medium text-gray-900">
                    {{ __('Are you sure you want to remove your friend') }} {{ $post->id }}{{ __('?') }}
                </h2>

                <div class="mt-6 flex justify-end">
                    <x-secondary-button x-on:click="$dispatch('close')">
                        {{ __('Cancel') }}
                    </x-secondary-button>

                    <x-primary-button class="ml-3">
                        {{ __('Remove Friend') }}
                    </x-primary-button>
                </div>
            </form>
        </x-modal>
    @endforeach


        
        <!-- <div class=" py-2 text-center">
            <x-primary-button style="font-size:1em;" x-on:click.prevent="$dispatch('open-modal', 'modal')">{{ __('Remove') }}</x-primary-button>
        </div> -->
    @foreach ($posts as $post)
        @include('components.post', [
            'post_id' => $post->id,
            'username' => $post->username,
            'title' => $post->title,
            'content' => $post->content,
            'file_name' => $post->file_name,
        ])
        <x-primary-button style="font-size:1em;" x-data="{{ $post->id }}" x-on:click.prevent="$dispatch('open-modal', 'remove-post-{{ $post->title }}')">{{ __('Remove') }}</x-primary-button>
    @endforeach
</x-app-layout>
