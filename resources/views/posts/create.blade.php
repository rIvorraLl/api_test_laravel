<x-app-layout>
    <div class="max-w-2xl mx-auto mt-4 p-4 sm:p-6 lg:p-8 bg-white shadow-md rounded">
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li class="text-red-600">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <form method="POST" action="{{ route('posts.store') }}" class="flex flex-col">
            @csrf
            <label for="title">{{ __('Post title') }}</label>
            <input class="shadow appearance-none border-gray-300 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Introduce el título..." type="text" name="title" id="excerpt" required value="{{ old('title') }}">
            <x-input-error :messages="$errors->get('title')" class="mt-2" />

            <label for="excerpt">{{ __('Post excerpt') }}</label>
            <input class="shadow appearance-none border-gray-300 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Introduce un resumen..." type="text" name="excerpt" id="excerpt" required value="{{ old('excerpt') }}">
            <x-input-error :messages=" $errors->get('excerpt')" class="mt-2" />
            <hr>
            <br>

            <label for="content">{{ __('Post content') }}</label>
            <textarea required name="content" placeholder="{{ __('Cuéntanos algo...') }}" class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">{{ old('content') }}</textarea>
            <x-input-error :messages="$errors->get('content')" class="mt-2" />

            <label for="expirable">{{ __('Expirable') }}</label>
            <input type="hidden" name="expirable" value="0">
            <input type="checkbox" class="shadow appearance-none border-gray-300 rounded" id="expirable" name="expirable" value="1" @if(old('expirable')==='1' ) checked @endif)>
            <x-input-error :messages="$errors->get('expirable')" class="mt-2" />

            <label for="mentionable">{{ __('Comments not allowed') }}</label>
            <input type="hidden" name="mentionable" value="1">
            <input type="checkbox" class="shadow appearance-none border-gray-300 rounded" id="mentionable" name="mentionable" value="0" @if(old('mentionable')==='0' ) checked @endif>
            <x-input-error :messages="$errors->get('mentionable')" class="mt-2" />

            <label for="isPublic">{{ __('Access') }}</label>
            <select type="select" name="isPublic" id="isPublic" class="shadow appearance-none border-gray-300 rounded">
                <option value="1" @if(old('isPublic')==='1' ) selected @endif>{{ __('Public')}}</option>
                <option value="0" @if(old('isPublic')==='0' ) selected @endif>{{ __('Private')}}</option>
            </select>
            <x-input-error :messages="$errors->get('access')" class="mt-2" />

            <x-primary-button class="mt-4 max-w-fit">{{ __('Post') }}</x-primary-button>
            <div>
                {{ session()->get('message') }}
            </div>
        </form>
    </div>
</x-app-layout>
