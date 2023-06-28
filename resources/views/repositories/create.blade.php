<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Repositorios') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <form action="{{ route('repositories.store') }}" method="POST", class="max-w-mg">
                    @csrf

                    <label for="block font-medium text-sm text-gray-700">Url</label>
                    <input type="text" name="url" id="url" class="mt-1 form-input block w-full" value="">

                    <label for="block font-medium text-sm text-gray-700">Descripcion</label>
                    <textarea type="text" name="descripcion" id="descripcion" class="mt-1 form-input block w-full">

                    </textarea>
                    <hr class="my-4">
                    <input type="submit" value="Guardar" class="bg-blue-500 text-white font-bold px-4 py-2 rounded-md">

                </form>
            </div>
        </div>
    </div>
</x-app-layout>
