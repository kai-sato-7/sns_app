<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Friend Requests') }}
        </h2>
    </x-slot>

    <div class="py-6 text-center">
        <x-primary-button style="font-size:1em;" x-data="" x-on:click.prevent="$dispatch('open-modal', 'send-friend-request')">{{ __('Send Friend Request') }}</x-primary-button>
    </div>

    @if (count($usernames) === 0)
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __('You have no incoming friend requests.') }}
                </div>
            </div>
        </div>
    </div>
    @else
    @foreach ($usernames as $username)
    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 text-gray-900 text-lg">
                    {{ $username }} {{ __('sent a friend request.') }}
                </div>
                <form method="POST" action="{{ route('friends.update') }}?username={{ $username }}">
                    @csrf
                    @method('patch')
                    <x-primary-button>
                        {{ __('Accept') }}
                    </x-primary-button>
                </form>
                <form method="POST" action="{{ route('friend_requests.destroy') }}?username={{ $username }}">
                    @csrf
                    @method('delete')
                    <x-primary-button>
                        {{ __('Decline') }}
                    </x-primary-button>
                </form>
            </div>
        </div>
    </div>
    @endforeach
    @endif

    <x-modal name="send-friend-request" :show="$errors->addRequest->isNotEmpty()" focusable>
        <form method="POST" action="{{ route('friend_requests.update') }}" class="p-6">
            @csrf
            @method('patch')
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Send Request') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __('Enter a user\'s username to send them a friend request.') }}
            </p>

            <div class="mt-6">
                <x-text-input
                    id="username"
                    name="username"
                    type="text"
                    class="mt-1 block w-3/4"
                    placeholder="Enter a Username"
                />

                <x-input-error :messages="$errors->addRequest->get('username')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-primary-button class="ml-3">
                    {{ __('Send Request') }}
                </x-primary-button>
            </div>
        </form>
    </x-modal>
</x-app-layout>