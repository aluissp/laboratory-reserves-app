@extends('layouts.app')

@section('content')
  <div class="container">
    <h3>Agregar rol</h3>
    <div class="row">
      <form method="POST" action="{{ route('roles.store') }}">
        @csrf
        <div class="row mb-3">
          <label for="name"
            class="col-3 col-form-label text-md-start">{{ __('Ingrese el nombre del nuevo rol') }}</label>

          <div class="col-md-3">
            <input id="search-name" type="text"
              class="form-control @error('name') is-invalid @enderror form-control-user"
              name="name" value="{{ old('name') }}" autocomplete="name"
              autofocus>

            @error('name')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div>
          <div class="col-md-2">
            <button type="submit" class="btn btn-primary btn-user">
              {{ __('Agregar') }}
            </button>
          </div>
        </div>
      </form>

    </div>

    <div id='major-list-view'>
      @foreach ($roles as $role)
        {{-- Immerso edit --}}
        @if ($role->name != config('role.admin'))
          <form method="POST" action="{{ route('roles.update', $role['id']) }}"
            class="d-flex justify-content-between bg-light mb-3 rounded px-4 py-2">
            @csrf
            @method('PUT')
          @else
            <form
              class="d-flex justify-content-between bg-light mb-3 rounded px-4 py-2">
        @endif
        <div class="d-flex align-items-center">
          <p class="me-2 mb-0 fw-bold">
            <input name="name-update" class="form-control-plaintext fw-bold"
              value="{{ $role['name'] }}">
          </p>
          <p class="me-2 mb-0 d-none d-md-block">
            Creado el: {{ $role['created_at'] }}
          </p>
          <p class="me-2 mb-0 d-none d-md-block">
            Actualizado el: {{ $role['updated_at'] }} </p>
          </p>


        </div>

        @if ($role->name != config('role.admin'))
          <div class="d-flex  align-items-center">
            <button type="submit" class="btn btn-secondary mb-0 me-2 p-1 px-2">
              <x-icon icon="pencil" />
            </button>
            <button form="rol-destroy-{{ $role['id'] }}" type="submit"
              class="btn btn-danger mb-0 me-2 p-1 px-2">
              <x-icon icon="trash" />
            </button>
          </div>
        @endif
        </form>

        {{-- Eliminar rol --}}
        <form id="rol-destroy-{{ $role['id'] }}"
          action="{{ route('roles.destroy', $role['id']) }}" method="POST">
          @csrf
          @method('DELETE')
        </form>
      @endforeach
    </div>
    {{ $roles->links() }}
  </div>
@endsection

