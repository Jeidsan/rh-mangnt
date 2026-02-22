<x-layout-app app-title="Home">
    <div class="w-100 p-4">
        <h3>Página inicial</h3>
        <hr />

        <div class="d-flex">
            <x-info-title-value item-title="Total de colaboradores" :item-value="$data['total_colaborators']" />
            <x-info-title-value item-title="Total de colaboradores excluídos" :item-value="$data['total_colaborators_deleted']" />
            <x-info-title-value item-title="Total de salários" :item-value="$data['total_salary']" />
        </div>

        <hr />

        <div class="d-flex">
            <x-info-title-collection item-title="Colaboradores por departamento" :collection="$data['total_colaborators_per_department']" />
            <x-info-title-collection item-title="Salários por departamento" :collection="$data['total_salary_per_department']" />
        </div>

    </div>
</x-layout-app>
