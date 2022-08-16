@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header text-center">{{ __('Registro de usuarios') }}
          </div>

          <div class="card-body">
            <form method="POST" action="{{ route('register') }}">
              @csrf

              <div class="row mb-3">
                <label for="name"
                  class="col-md-4 col-form-label text-md-end">{{ __('Nombre') }}</label>

                <div class="col-md-6">
                  <input id="name" type="text"
                    class="form-control @error('name') is-invalid @enderror form-control-user"
                    name="name" value="{{ old('name') }}" autocomplete="name"
                    autofocus>

                  @error('name')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
              </div>

              <div class="row mb-3">
                <label for="surname"
                  class="col-md-4 col-form-label text-md-end">{{ __('Apellido') }}</label>

                <div class="col-md-6">
                  <input id="surname" type="text"
                    class="form-control @error('surname') is-invalid @enderror form-control-user"
                    name="surname" value="{{ old('surname') }}"
                    autocomplete="surname">

                  @error('surname')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
              </div>

              <div class="row mb-3">
                <label for="email"
                  class="col-md-4 col-form-label text-md-end">{{ __('Correo electrónico') }}</label>

                <div class="col-md-6">
                  <input id="email" type="text"
                    class="form-control @error('email') is-invalid @enderror form-control-user"
                    name="email" value="{{ old('email') }}"
                    autocomplete="email">

                  @error('email')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
              </div>

              <div class="row mb-3">
                <label for="password"
                  class="col-md-4 col-form-label text-md-end">{{ __('Contraseña') }}</label>

                <div class="col-md-6">
                  <input id="password" type="password"
                    class="form-control @error('password') is-invalid @enderror form-control-user"
                    name="password" autocomplete="new-password"
                    value="{{ old('password') }}">

                  @error('password')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
              </div>

              <div class="row mb-3">
                <label for="password-confirm"
                  class="col-md-4 col-form-label text-md-end">{{ __('Confirmar Contraseña') }}</label>

                <div class="col-md-6">
                  <input id="password-confirm" type="password"
                    class="form-control form-control-user @error('password_confirmation') is-invalid @enderror"
                    name="password_confirmation"
                    value="{{ old('password_confirmation') }}">

                  @error('password_confirmation')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
              </div>

              <div class="row mb-0">
                <div class="col-md-6 offset-md-4">
                  <button type="submit" class="btn btn-primary btn-user">
                    {{ __('Registrar') }}
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
