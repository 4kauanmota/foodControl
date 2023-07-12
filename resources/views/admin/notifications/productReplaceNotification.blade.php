<x-app-layout>

    <x-header>
        Notificações
    </x-header>

    <x-content>
        @forelse(Auth::user()->unreadNotifications as $notification)
            <div class="mb-4 border-bottom pb-2 border-secondary">
                <p>{{ $notification->data['message'] }}</p>
                <p class="fs-6">{{ date('d/m/Y - H:m', strtotime($notification->created_at)) }}</p>
                @if($notification->type == 'App\Notifications\ProductReplaceNotification')
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('replace.accept',$notification->id) }}">
                            <x-primary-button class="mt-2">Aceitar Troca</x-danger-button>
                        </a>
                        <a href="{{ route('replace.cancel',$notification->id) }}">
                            <x-danger-button class="mt-2">Cancelar Troca</x-danger-button>
                        </a>
                    </div>
                @else
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('mark.read', $notification->id) }}">
                            <x-danger-button class="mt-2">Marcar como lido</x-danger-button>
                        </a>
                    </div>
                @endif
            </div>
        @empty
            <div class="alert alert-warning mb-0" role="alert">
                <p>Sem Notificações</p>
            </div>
        @endforelse
    </x-content>

</x-app-layout>