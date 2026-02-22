<x-layout-app app-title="Colaboradores">

    <div class="w-100 p-4">

        <h3>Colaboradores</h3>

        <hr>

        @if ($colaborators->count() === 0)
            <div class="text-center my-5">
                <p>No colaborators found.</p>
                <a href="{{ route('rh-users.management.new-colaborator') }}" class="btn btn-primary"><i class="fa-solid fa-user-plus me-2"></i>Novo colaborador</a>
            </div>
        @else
            <div class="mb-3">
                <a href="{{ route('rh-users.management.new-colaborator') }}" class="btn btn-primary"><i class="fa-solid fa-user-plus me-2"></i>Novo colaborador</a>
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
                                        <a href="{{ route('rh-users.management.details-colaborator', ['id' => $colaborator->id]) }}" class="btn btn-sm btn-outline-dark ms-3"><i class="fas fa-eye me-2"></i>Detalhes</a>
                                        <a href="{{ route('rh-users.management.edit-colaborator', ['id' => $colaborator->id]) }}" class="btn btn-sm btn-outline-dark ms-3"><i class="fa-regular fa-edit me-2"></i>Editar</a>
                                        <a href="{{ route('rh-users.management.delete-colaborator', ['id' => $colaborator->id]) }}" class="btn btn-sm btn-outline-dark ms-3"><i class="fa-regular fa-trash-can me-2"></i>Excluir</a>
                                    @else
                                        <a href="{{ route('rh-users.management.restore-colaborator', ['id' => $colaborator->id]) }}" class="btn btn-sm btn-outline-dark ms-3"><i class="fa-solid fa-trash-arrow-up me-2"></i>Restaurar</a>
                                    @endempty
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

</x-layout-app>
