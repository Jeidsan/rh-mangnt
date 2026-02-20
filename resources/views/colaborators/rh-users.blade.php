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
                    <th>Role</th>
                    <th>Salário</th>
                    <th>Admission date</th>
                    <th>City</th>
                    <th></th>
                </thead>
                <tbody>
                    @foreach ($colaborators as $colaborator)
                        <tr>
                            <td>{{ $colaborator->name }}</td>
                            <td>{{ $colaborator->email }}</td>
                            <td>{{ $colaborator->role }}</td>
                            <td>{{ Number::currency($colaborator->detail->salary, 'BRL') }}</td>
                            <td>{{ $colaborator->detail->admission_date }}</td>
                            <td>{{ $colaborator->detail->city }}</td>
                            <td>
                                <div class="d-flex gap-3 justify-content-end">
                                    <a href="{{ route('rh-users.edit-colaborator', [ 'id' => $colaborator->id ]) }}" class="btn btn-sm btn-outline-dark ms-3"><i class="fa-regular fa-pen-to-square me-2"></i>Edit</a>
                                    <a href="{{ route('rh-users.delete-colaborator', [ 'id' => $colaborator->id ]) }}" class="btn btn-sm btn-outline-dark ms-3"><i class="fa-regular fa-trash-can me-2"></i>Delete</a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

    </div>
</x-layout-app>
