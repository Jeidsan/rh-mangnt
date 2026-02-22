<x-layout-app app-title="Meu perfil">
    <div class="w-100 p-4">
        <h3>Meu perfil</h3>
        <hr />
        <x-profile-user-data />
        <hr />
        <div class="container-fluid m-0 p-0 mt-5">
            <div class="row">
                <x-profile-user-change-component />
                <x-profile-user-change-data />
                <x-profile-user-change-address />
            </div>
        </div>
    </div>
</x-layout-app>
