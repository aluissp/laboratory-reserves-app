@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Detalles de la cuenta</div>

          <div class="card-body">
            <form method="POST" action="{{ route('users.update', $user->id) }}">
              @csrf
              @method('PUT')
              <div class="row">
                <div class="mb-3 col-6">
                  <label for="name"
                    class="col-md-4 col-form-label">Nombre</label>
                  <input id="name" type="text"
                    class="form-control @error('name') is-invalid @enderror form-control-user"
                    name="name" value="{{ old('name') ?? $user->name }}"
                    autocomplete="name" autofocus>

                  @error('name')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
                <div class="mb-3 col-6">
                  <label for="name"
                    class="col-md-4 col-form-label">Apellido</label>
                  <input id="surname" type="text"
                    class="form-control @error('surname') is-invalid @enderror form-control-user"
                    name="surname" value="{{ old('surname') ?? $user->surname }}">

                  @error('surname')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>

              </div>

              <div class="row mb-3">
                <label for="email" class="col-md-4 col-form-label mx-1">Correo
                  electrónico</label>
                <div class='px-3'>
                  <input id="email" type="text"
                    class="form-control @error('email') is-invalid @enderror form-control-user"
                    name="email" value="{{ old('email') ?? $user->email }}">

                  @error('email')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
              </div>

              <div class="row">
                <div class="mb-3 col-6">
                  <label for="password"
                    class="col-md-4 col-form-label">Contraseña</label>
                  <input id="password" type="password"
                    class="form-control @error('password') is-invalid @enderror form-control-user"
                    name="password" value="{{ old('password') }}"
                    autocomplete="password" autofocus>

                  @error('password')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
                <div class="mb-3 col-6">
                  <label for="password-confirm" class="col-form-label">Confirmar
                    contraseña</label>
                  <input id="password-confirm" type="password"
                    class="form-control @error('password_confirmation') is-invalid @enderror form-control-user"
                    name="password_confirmation"
                    value="{{ old('password_confirmation') }}">

                  @error('password_confirmation')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
              </div>
              <div class="row">
                <div class="mb-3 col-6">
                  <label for="role" class="col-form-label">Rol</label>
                  <input id="role" list="roles"
                    class="form-control @error('role') is-invalid @enderror form-control-user"
                    name="role"
                    value="{{ old('role') ?? $user->roles?->first()->name }}">
                  <datalist id="roles">
                    @foreach ($roles as $role)
                      <option value="{{ $role->name }}">
                    @endforeach
                  </datalist>

                  @error('role')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
                <div class="mb-3 col-6">
                  <label for="role" class="col-form-label">Carrera</label>
                  <input id="major" list="majors"
                    class="form-control @error('major') is-invalid @enderror form-control-user"
                    name="major"
                    value="{{ old('major') ?? $user->major?->name }}">
                  <datalist id="majors">
                    @foreach ($majors as $major)
                      <option value="{{ $major->name }}">
                    @endforeach
                  </datalist>

                  @error('major')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>

              </div>
              <div class="row">
                <div class="mb-3 col-6">
                  <label class="fw-bold">Creado el: </label>
                  {{ $user->created_at }}
                </div>
                <div class="mb-3 col-6">
                  <label class="fw-bold">Actualizado el: </label>
                  {{ $user->updated_at }}
                </div>
              </div>

              <input type="hidden" name="id" value="{{ $user->id }}">
              <div class="row mb-0">
                <div class="col-md-6">
                  <button type="submit" class="btn btn-primary btn-user">
                    {{ __('Guardar cambios') }}
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
