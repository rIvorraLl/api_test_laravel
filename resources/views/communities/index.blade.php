@php
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
@endphp
<x-app-layout>
    <div class="max-w-2xl mx-auto p-2 sm:p-6 lg:p-8">
        <div class="mt-6 bg-white shadow-sm rounded-lg divide-y" flex flex-col>
            @if (session('message'))
            <div class="alert alert-success">
                <p class="mt-2 text-red-500 p-4">{{ session('message') }}</p>
            </div>
            @endif
            @foreach ($communities->posts as $post)
            @if ($post->isPublic || $post->user->is(auth()->user()))
            <a href="/communities/{{ $post->community->id }}" class="p-6 mt-2 text-lg text-gray-900">{{ $post->community->name }}</a>
            <div class="p-6 flex space-x-2 bg-white-100 m-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600 -scale-x-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                </svg>
                <div class="flex-1">
                    <div class="flex justify-between items-center">
                        <div>
                            <span class="text-gray-800">{{ $post->user->name }}</span>
                            <small class="ml-2 text-sm text-gray-600">{{ $post->created_at->format('j M Y, g:i a')
                                }}</small>
                            @unless ($post->created_at->eq($post->updated_at))
                            <small class="text-sm text-gray-600"> &middot; {{ __('edited') }}</small>
                            @endunless
                        </div>
                        @if ($post->user->is(auth()->user()))
                        <x-dropdown>
                            <x-slot name="trigger">
                                <button>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                    </svg>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <x-dropdown-link :href="route('posts.edit', $post)">
                                    {{ __('Edit') }}
                                </x-dropdown-link>
                                <form method="POST" action="{{ route('posts.destroy', $post) }}">
                                    @csrf
                                    @method('delete')
                                    <x-dropdown-link :href="route('posts.destroy', $post)" onclick="event.preventDefault(); this.closest('form').submit();">
                                        {{ __('Delete') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                        @endif
                    </div>
                    <div class="bg-gray-50 p-2">
                        <h1 class="mt-4 text-xl font-bold">{{ $post->title }}</h1>
                    </div>
                    <p class="mt-4 text-lg text-gray-900"><i> {{ $post->excerpt }} </i></p>
                    <p class="mt-4 text-lg text-gray-900">{{ $post->content }}</p>
                    @if($post->mentionable)
                    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
                        <form method="POST" action="{{ route('comments.store') }}">
                            @csrf
                            <textarea name="comment" placeholder="{{ __('Comentar...') }}" class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">{{ old('comment') }}</textarea>
                            <input type="hidden" name="post_id" value="{{ $post->id }}">
                            @php
                            $user_id = auth()->user()->id;
                            @endphp
                            <input type="hidden" name="user_id" id="user_id" value=" {{ $user_id }} ">
                            <x-input-error :messages="$errors->get('comment')" class="mt-2" />
                            <x-primary-button class="mt-4">{{ __('Comment') }}</x-primary-button>
                        </form>
                    </div>
                    @foreach ($post->comments as $comment)
                    @php
                    $user = DB::table('users')
                    ->join('comments', 'users.id', '=', 'comments.user_id')
                    ->where('users.id', '=', $comment->user_id)
                    ->select('users.name')
                    ->get();
                    $commUser = $comment->user();
                    @endphp
                    <div class="p-1 flex space-x-2 bg-white-100 m-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600 -scale-x-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                        <small class="ml-2 text-sm text-gray-600"><i>{{ $user[0]->name }} ha dicho... </i></small>
                    </div>
                    <div class="p-3">
                        <p class="mt-1">{{ $comment->comment }}</p>
                    </div>
                    <div class="flex justify-end">
                    @if ($comment->user->is(auth()->user()))
                    <x-dropdown>
                        <x-slot name="trigger">
                            <button>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                </svg>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <form method="POST" action="{{ route('comments.destroy', $comment) }}">
                                @csrf
                                @method('delete')
                                <x-dropdown-link :href="route('comments.destroy', $comment)" onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Delete') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                    @endif
                </div>
                    <hr>
                    @endforeach
                    @endif
                </div>
            </div>
            @endif
            @endforeach
        </div>
    </div>
</x-app-layout>
