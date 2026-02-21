<x-layout-guest app-title="Confirmação de registro">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-4">

                <!-- logo -->
                <div class="text-center mb-5">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" width="200px">
                </div>

                <!-- login form -->
                <div class="card p-5">

                    <form action="{{ route('confirm-account-submit') }}" method="post">

                        @csrf

                        <input type="hidden" name="token" value="{{ $user->confirmation_token }}">

                        <div class="mb-3">
                            <label for="password">Senha</label>
                            <input type="password" class="form-control" id="password" name="password">
                            @error('password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation">Confirmação da senha</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                            @error('password_confirmation')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end align-items-center">
                            <button type="submit" class="btn btn-primary px-4">Salvar</button>
                        </div>

                    </form>

                    @if (session('status'))
                        <div class="alert alert-success mt-3 text-center">
                            {{ session('status') }}
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
</x-layout-guest>
