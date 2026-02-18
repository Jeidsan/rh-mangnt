<x-layout-app app-title="Excluir departamento">
    <div class="w-25 p-4">

        <h3>Excluir departamento</h3>

        <hr>

        <p>Tem certeza que deseja excluir este departamento?</p>

        <div class="text-center">
            <h3 class="my-5">{{ $department->name }}</h3>
            <a href="{{ route('departments') }}" class="btn btn-secondary px-5">Não</a>
            <a href="{{ route('departments.delete-department-confirm', ['id' => $department->id]) }}" class="btn btn-danger px-5">Sim</a>
        </div>

    </div>
</x-layout-app>
