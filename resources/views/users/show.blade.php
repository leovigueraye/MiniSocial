
<x-app-layout>

    @php
    $chirps = $user->chirps();
    @endphp
    <div class="container mt-10 bg-white shadow-sm rounded-lg m-8">
        <div class=" border py-4 px-5 rounded-lg mb-4">
            <h3 class="text-2xl font-semibold pb-3 text-center">{{ $user->name }}</h3>
            <p class="text-lg pb-3">Joined: {{ Carbon\Carbon::parse($user->created_at)->diffForHumans() }}</p>
            <p class="text-lg pb-3">Posts: {{ $chirps->count() }} chirps</p>
            <p class="text-lg pb-3">followers: {{ $user->followers()->count() }} follower</p>            
            <p class="text-lg pb-3">following: {{ $user->followees()->count() }} following</p>  

            @if(auth()->check() && auth()->user()->id != $user->id)
            @if(auth()->user()->followees()->find($user->id))

            <form method="post" action="{{ route('users.unfollow', $user->id) }}">
                @csrf
                <button class="text-lg pb-3 bg-gray-500 hover:bg-gray-700 text-gray-200 font-bold py-2 px-4 rounded">Following</button>
            </form>

            @else

            <form method="post" action="{{ route('users.follow', $user->id) }}">
                @csrf
                <button class="text-lg pb-3 bg-cyan-500 hover:bg-cyan-700 text-gray-200 font-bold py-2 px-4 rounded">Follow</button>
            </form>
            @endif
            @endif
        </div>

        @if($chirps->count() > 0)
        <div>
            <h3 class="text-2xl font-semibold pb-3 ">Posts:</h3>
            @foreach($chirps->get() as $chirp)
            <div class=" shadow shadow-gray-300/50 py-4 px-5 rounded-lg mb-4">
                <a href="{{ route('chirps.show', $chirp->id) }}" class="pb-3 flex flex-col sm:flex-row justify-between sm:items-center">
                    <h3 class="inline text-2xl font-semibold pb-3 underline">{{ $chirp->message }}</h3>
                    <span>{{ Carbon\Carbon::parse($chirp->created_at)->diffForHumans() }}</span>
                </a>            
            </div>
            @endforeach
        </div>
        @else
        <div class=" border border-gray-500 py-4 px-5 rounded-lg text-3xl text-center">This user has no posts... come back later :)</div>
        @endif
    </div>

</x-app-layout>
