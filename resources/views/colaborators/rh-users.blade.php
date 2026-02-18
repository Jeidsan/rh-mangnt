<x-layout-app app-title="Recursos Humanos">
    <div class="w-100 p-4">
        <h3>Colaboradores do Recursos Humanos</h3>
        <hr>
        @if ($colaborators->count() === 0)
            <div class="text-center my-5">
                <p>No colaborators found.</p>
                <a href="{{ route('rh-users.new-colaborator') }}" class="btn btn-primary">Create a new RH colaborator</a>
            </div>
        @else
            <div class="mb-3">
                <a href="{{ route('rh-users.new-colaborator') }}" class="btn btn-primary">Create a new RH colaborator</a>
            </div>

            <table class="table w-50" id="table">
                <thead class="table-dark">
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th>Permissões</th>
                    <th></th>
                </thead>
                <tbody>
                    @foreach ($colaborators as $colaborator)
                        <tr>
                            <td>{{ $colaborator->name }}</td>
                            <td>{{ $colaborator->email }}</td>
                            <td>{{ implode(', ', json_decode($colaborator->permissions)) }}</td>
                            <td>
                                <div class="d-flex gap-3 justify-content-end">
                                    <a href="#" class="btn btn-sm btn-outline-dark"><i class="fa-regular fa-pen-to-square me-2"></i>Edit</a>
                                    <a href="#" class="btn btn-sm btn-outline-dark"><i class="fa-regular fa-trash-can me-2"></i>Delete</a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

    </div>
</x-layout-app>
