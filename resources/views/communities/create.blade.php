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
        <form method="POST" action="{{ route('communities.store') }}" class="flex flex-col">
            @csrf
            <label for="name">{{ __('Name') }}</label>
            <input class="shadow appearance-none border-gray-300 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Introduce el nombre..." type="text" name="name" id="name" required value="{{ old('name') }}">
            <x-input-error :messages="$errors->get('name')" class="mt-2" />

            <label for="description">{{ __('Description') }}</label>
            <input class="shadow appearance-none border-gray-300 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Introduce una descripción..." type="text" name="description" id="description" required value="{{ old('description') }}">
            <x-input-error :messages=" $errors->get('description')" class="mt-2" />
            <hr>
            <br>

            <label for="rules">{{ __('Rules') }}</label>
            <textarea required name="rules" placeholder="{{ __('Introduce las reglas de tu comunidad...') }}" class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">{{ old('rules') }}</textarea>
            <x-input-error :messages="$errors->get('rules')" class="mt-2" />

            <x-primary-button class="mt-4 max-w-fit">{{ __('Create') }}</x-primary-button>
            <div>
                {{ session()->get('message') }}
            </div>
        </form>
    </div>
</x-app-layout>