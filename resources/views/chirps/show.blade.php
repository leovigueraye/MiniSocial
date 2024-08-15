
<x-app-layout>
    @php
    $likes = $chirp->likes->toArray();
    $isCurrentUserLiked = false;
    if (auth()->check()) {
        foreach ($likes as $like) {
            if ($like['user_id'] == auth()->user()->id) {
                $isCurrentUserLiked = true;
                break;
            }
        }
    }
    @endphp
    <div class="container mt-10 bg-white shadow-sm rounded-lg m-8 p-4">
        <div class="border border-gray-500 py-4 px-5 rounded-lg mb-4">
            
            <p class="text-center  pb-3">By: {{ $chirp->user->name }}</p>
            <p class="text-center  pb-3">Posted {{ \Carbon\Carbon::parse($chirp->created_at)->diffForHumans() }}</p>
            <p class="text-lg text-center pb-3">{{ $chirp->message }}</p>
            @if(auth()->check())
            <form method="post" action="{{ $isCurrentUserLiked ? route('chirps.dislike', $chirp->id) : route('chirps.like', $chirp->id) }}">
                @csrf
                <button class="text-xl {{ $isCurrentUserLiked ? 'text-cyan-500' : 'text-gray-300' }} flex items-center justify-around"><ion-icon name="heart"></ion-icon><span class="ml-2">{{ $chirp->likes->count() }}</span></button>
            </form>
            @else
            <button title="Login to like" class="text-xl {{ $isCurrentUserLiked ? 'text-cyan-500' : 'text-gray-300' }} flex items-center justify-around"><ion-icon name="heart"></ion-icon><span class="ml-2">{{ $chirp->likes->count() }}</span></button>
            @endif
        </div>

        <!-- add Comment -->

        @if(auth()->check())

        <div class=" border border-gray-500 py-4 px-5 rounded-lg mb-4">
            <h3 class="text-2xl font-semibold pb-3">Add Comment</h3>
            <form method="post" action="{{ route('chirps.comment', $chirp->id) }}">
                @csrf
                <div class="flex flex-col items-stretch sm:flex-row justify-between sm:items-center">
                    <input type="text" class="flex-1 text-gray-300 border border-gray-500 p-2 sm:mr-2 rounded-lg bg-slate-900" name="content" placeholder="Add a comment" />
                    <button class="bg-cyan-500 text-white p-2 rounded-md mt-2 sm:mt-0">Post Comment</button>
                </div>
            </form>
        </div>

        @endif

        <!-- Comments -->
        <div>
            <h3 class="text-2xl font-semibold pb-3">Comments ({{ $chirp->comments->count() }})</h3>
            <hr class="border-gray-500 mb-3" />
            @foreach($chirp->comments->reverse() as $comment)
            <div class=" shadow shadow-gray-300/50 py-4 px-5 rounded-lg mb-4">
                <a href="{{ route('users.show', $comment->user->id) }}">
                    <h3 class="inline text-2xl font-semibold pb-3 underline">{{ $comment->user->name }}</h3>
                </a>
                <span>{{ Carbon\Carbon::parse($comment->created_at)->diffForHumans() }}</span>
                <p>{{ $comment->content }}</p>
            </div>
            @endforeach
        </div>
    </div>

</x-app-layout>
