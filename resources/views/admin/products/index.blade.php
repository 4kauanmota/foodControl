<x-app-layout>

    <x-header>
        Produtos
    </x-header>

    <x-content>
        <div class="button">
            <form action="{{ route('product.create') }}" method="get">
                <x-primary-button type="submit" class="mb-4">Adicionar</x-primary-button>
            </form>
        </div>
        @if(session('message'))
            <div class="alert alert-primary">
                <p>{{ session('message') }}</p>
            </div>
        @endif
        @if(session('cancel'))
            <div class="alert alert-danger">
                <p>{{ session('cancel') }}</p>
            </div>
        @endif
        @if(session('accept'))
            <div class="alert alert-success">
                <p>{{ session('accept') }}</p>
            </div>
        @endif
        <div class="d-flex flex-row justify-content-around flex-wrap mb-5">
            @foreach($products as $product)
                @if($product->replace == false)
                    <a href="{{ route('product.show',$product->id) }}">
                        <div class="card mb-4 me-2" style="width: 18rem;">
                            <img src="/{{ $product->photo }}" class="card-img-top h-auto" alt="testando">
                            <div class="card-body">
                                <h2 class="text-center">{{ $product->name }}</h2>
                            </div>
                        </div>
                    </a>
                @endif
            @endforeach
        </div>
    </x-content>

</x-app-layout>