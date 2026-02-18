<x-layout-app app-title="Home">
    <p class="display-6 text-center my-5">Bem-vindo ao RH MANGNT</p>
    @can('admin')
        <h3 class="text-center mt-3">Admin logado</h3>
    @endcan
</x-layout-app>
