<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Friends') }}
        </h2>
    </x-slot>
    
    <div class="p-6" style="display:flex; justify-content:center;">
        <table class="table table-borderless">
            <tbody>
                @foreach ($usernames as $username)
                    <tr>
                        <td class="p-2">{{ $username }}</td>
                        <td class="p-2"><x-primary-button style="font-size:1em;" x-data="{{ $username }}" x-on:click.prevent="$dispatch('open-modal', 'remove-friend-{{ $username }}')">{{ __('Remove') }}</x-primary-button></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @foreach ($usernames as $username)
        <x-modal name="remove-friend-{{ $username }}" focusable>
            <form method="post" action="{{ route('friends.destroy', ['username' => $username]) }}" class="p-6">
                @csrf
                @method('delete')
                <h2 class="text-lg font-medium text-gray-900">
                    {{ __('Are you sure you want to remove your friend') }} {{ $username }}{{ __('?') }}
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
</x-app-layout>
