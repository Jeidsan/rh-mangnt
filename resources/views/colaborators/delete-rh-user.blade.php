<x-layout-app app-title="Excluir colaborador">
    <div class="w-25 p-4">

        <h3>Excluir colaborador</h3>

        <hr>

        <p>Tem certeza que deseja excluir este colaborador?</p>

        <div class="text-center">
            <h3 class="my-5">{{ $colaborator->name }}</h3>
            <a href="{{ route('rh-users') }}" class="btn btn-secondary px-5">Não</a>
            <a href="{{ route('rh-users.delete-colaborator-confirm', ['id' => $colaborator->id]) }}" class="btn btn-danger px-5">Sim</a>
        </div>

    </div>
</x-layout-app>
