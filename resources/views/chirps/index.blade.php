<x-app-layout>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <form method="POST" action="{{ route('chirps.store') }}">
            @csrf
            <textarea
                name="message"
                placeholder="{{ __('What\'s on your mind?') }}"
                class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
            >{{ old('message') }}</textarea>
            <x-input-error :messages="$errors->get('message')" class="mt-2" />
            <x-primary-button class="mt-4">{{ __('Post') }}</x-primary-button>
        </form>
    </div>

    <div class="mt-6 bg-white shadow-sm rounded-lg divide-y-4 m-20">
            @foreach ($chirps as $chirp)
                <div class="p-6 flex space-x-2">
                    
                    <ion-icon name="person" class="h-6 w-6 text-gray-600 -scale-x-100" ></ion-icon>
                    <div class="flex-1">
                        <div class="flex justify-between items-center">
                            <div>                                
                                <a href="{{ route('users.show', $chirp->user->id) }}">
                                <span class="text-gray-800">{{ $chirp->user->name }}</span>
                </a>
                                <small class="ml-2 text-sm text-gray-600">{{ $chirp->created_at->diffForHumans()  }}</small>                                
                                @unless ($chirp->created_at->eq($chirp->updated_at))
                                    <small class="text-sm text-gray-600"> &middot; {{ __('edited') }}</small>
                                @endunless
                            </div>
                            @if ($chirp->user->is(auth()->user()))
                                <x-dropdown>
                                    <x-slot name="trigger">
                                        <button>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                            </svg>
                                        </button>
                                    </x-slot>
                                    <x-slot name="content">
                                        <x-dropdown-link :href="route('chirps.edit', $chirp)">
                                            {{ __('Edit') }}
                                        </x-dropdown-link>
                                        <form method="POST" action="{{ route('chirps.destroy', $chirp) }}">
                                            @csrf
                                            @method('delete')
                                            <x-dropdown-link :href="route('chirps.destroy', $chirp)" onclick="event.preventDefault(); this.closest('form').submit();">
                                                {{ __('Delete') }}
                                            </x-dropdown-link>
                                        </form>
                                    </x-slot>
                                </x-dropdown>
                            @endif
                        </div>
                        <p class="mt-4 text-lg text-gray-900"> <a href="{{ route('chirps.show', $chirp->id) }}"> {{ $chirp->message }} </a></p>
                        <button title="Login to like" class="text-xl flex items-center justify-around"><ion-icon name="heart"></ion-icon><span class="ml-2">{{ $chirp->likes->count() }}</span></button>                        
                    </div>                    
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>