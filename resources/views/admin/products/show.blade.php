<x-app-layout>

    <x-header>
        Produto
    </x-header>

    <x-content>
        <h1 class="fs-1 text-center mb-5 mt-3">{{ $product->name }}</h1>
        <div class="d-flex justify-content-center">
            <img src="/{{ $product->photo }}" class="w-75 img-fluid rounded mb-5" alt="Imagem do produto">
        </div>
        <p class="mb-3"><strong class="fs-5">Preparation Time:</strong> {{ $product->preparationTime }}</p>
        <p class="mb-3"><strong class="fs-5">Preparation Mode:</strong> {{ $product->preparationMode }}</p>
        <p class="mb-3"><strong class="fs-5">Description:</strong> {{ $product->description }}</p>
        <p class="mb-3"><strong class="fs-5">Value:</strong> {{ $product->value }}</p>
        <p class="mb-3"><strong class="fs-5">Person:</strong> {{ $product->user->name }}</p>
        <div class="text-right">
            <a href="{{ route('product.index') }}">
                <x-primary-button>Voltar</x-primary-button>
            </a>
            @if($product->user->id != Auth::user()->id)
                <a href="{{ route('product.list',$product->id) }}">
                    <x-danger-button>Trocar Produto</x-danger-button>
                </a>
            @endif
        </div>
    </x-content>

</x-app-layout>