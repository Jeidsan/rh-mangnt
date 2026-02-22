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

            <table class="table" id="table">
                <thead class="table-dark">
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th>Ativo</th>
                    <th>Departamento</th>
                    <th>Role</th>
                    <th>Admissão</th>
                    <th>Salário</th>
                    <th></th>
                </thead>
                <tbody>
                    @foreach ($colaborators as $colaborator)
                        <tr>
                            <td>{{ $colaborator->name }}</td>
                            <td>{{ $colaborator->email }}</td>
                            <td>
                                @empty($colaborator->email_verified_at)
                                    <span class="badge bg-danger">Inativo</span>
                                @else
                                    <span class="badge bg-success">Ativo</span>
                                @endempty
                            </td>
                            <td>{{ $colaborator->department->name ?? '-' }}</td>
                            <td>{{ $colaborator->role }}</td>
                            <td>{{ $colaborator->detail->admission_date }}</td>
                            <td>{{ Number::currency($colaborator->detail->salary, 'BRL') }}</td>
                            <td>
                                <div class="d-flex gap-3 justify-content-end">
                                    @empty($colaborator->deleted_at)
                                        <a href="{{ route('rh-users.edit-colaborator', ['id' => $colaborator->id]) }}" class="btn btn-sm btn-outline-dark ms-3"><i class="fa-regular fa-pen-to-square me-2"></i>Edit</a>
                                        <a href="{{ route('rh-users.delete-colaborator', ['id' => $colaborator->id]) }}" class="btn btn-sm btn-outline-dark ms-3"><i class="fa-regular fa-trash-can me-2"></i>Delete</a>
                                    @else
                                        <a href="{{ route('rh-users.restore-colaborator', ['id' => $colaborator->id]) }}" class="btn btn-sm btn-outline-dark ms-3"><i class="fa-solid fa-trash-arrow-up me-2"></i>Restore</a>
                                    @endempty
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

    </div>
</x-layout-app>
