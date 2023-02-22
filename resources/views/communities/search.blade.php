<x-app-layout>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <form method="GET" action="{{ route('communities.index')}}" class="flex flex-col">
            {{-- action="{{ route('posts.store') }}" --}}
            @csrf
            @method('get')
            <label for="name">{{ __('Búsqueda') }}</label>
            <input class="shadow appearance-none border-gray-300 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Introduce el nombre de la comunidad..." type="text" name="name" id="name" required value="{{ old('name') }}">
            <x-input-error :messages="$errors->get('search')" class="mt-2" />
            <div class="mt-4 space-x-2">
                <x-primary-button>{{ __('Buscar') }}</x-primary-button>
                <a href="{{ route('posts.index') }}">{{ __('Cancel') }}</a>
            </div>
        </form>
    </div>
</x-app-layout>
