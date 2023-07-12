<x-app-layout>

    <x-header>
        Escolha o seu produto que deseja trocar
    </x-header>

    <x-content>
        <div class="d-flex flex-row justify-content-around flex-wrap mb-5">
            @for($key = 0; $key < sizeof($productsAuth); $key++)
                @if($productsAuth[$key]->replace == false)
                    <a href="{{ route('product.replace',['product' => $product->id, 'replace' => $productsAuth[$key]->id]) }}">
                        <div class="card mb-4 me-2" style="width: 18rem;">
                            <img src="/{{ $productsAuth[$key]->photo }}" class="card-img-top h-auto" alt="testando">
                            <div class="card-body">
                                <h2 class="text-center">{{ $productsAuth[$key]->name }}</h2>
                            </div>
                        </div>
                    </a>
                @endif
            @endfor
        </div>
    </x-content>

</x-app-layout>