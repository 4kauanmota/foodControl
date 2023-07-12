<x-app-layout>
    <x-header>
        Criando Produto
    </x-header>

    <x-content>
        <form action="{{ route('product.store') }}" enctype="multipart/form-data" method="POST">
            @csrf
            <div class="mb-4">
                <x-input-label for="name" :value="__('Name:')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>
            <div class="mb-4">
                <x-input-label for="description" :value="__('Description:')" />
                <div class="">
                    <textarea class="form-control mt-1" name="description" id="description"></textarea>
                </div>
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>
            <div class="mb-4">
                <x-input-label for="preparationTime" :value="__('Preparation Time:')" />
                <x-text-input id="preparationTime" class="block mt-1 w-full" type="number" name="preparationTime" :value="old('preparationTime')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('preparationTime')" class="mt-2" />
            </div>
            <div class="mb-4">
                <x-input-label for="preparationMode" :value="__('Preparation Mode:')" />
                <div class="">
                    <textarea class="form-control mt-1" name="preparationMode" id="preparationMode"></textarea>
                </div>
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>
            <div class="mb-4">
                <x-input-label for="value" :value="__('Value:')" />
                <x-text-input id="value" class="block mt-1 w-full" type="number" name="value" :value="old('value')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('value')" class="mt-2" />
            </div>
            <div class="mb-4">
                <x-input-label for="photo" :value="__('Image:')" />
                <x-text-input id="photo" class="block mt-1 w-full" type="file" name="photo" :value="old('photo')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('photo')" class="mt-2" />
            </div>
            <div>
                <x-primary-button type="submit">Adicionar</x-primary-button>
            </div>
            <x-text-input id="user_id" class="block mt-1 w-full" type="hidden" name="user_id" value="{{ Auth::user()->id }}"/>
        </form>
    </x-content>

</x-app-layout>