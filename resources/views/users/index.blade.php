@extends('layouts.app')

@section('content')
  <div class="container">
    <h3>Lista de usuarios</h3>
    <div class="row mb-3">
      <label for="name"
        class="col-2 col-form-label text-md-start">{{ __('Buscar usuario') }}</label>

      <div class="col-md-3">
        <input id="search-name" type="text"
          class="form-control  form-control-user" name="name" autocomplete="name"
          autofocus>
      </div>
      {{-- <div class="col-md-2">
        <button class="btn btn-primary btn-user">
          {{ __('Buscar') }}
        </button>
      </div> --}}

    </div>

    {{-- <div id='major-list-view'> --}}

    <table class="table table-hover ">
      <thead>
        <tr>
          <th scope="col"><i class="fa-solid fa-id-badge"></i></th>
          <th scope="col">Nombre</th>
          <th scope="col">Correo electrónico</th>
          <th scope="col">Rol</th>
          <th scope="col">Carrera</th>
          <th scope="col">Acciones</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($users as $user)
          <tr>
            <th scope="row">{{ $user->id }}</th>
            <td>{{ $user->name }} {{ $user->surname }}</td>
            <td><a href="mailto:{{ $user->email }}"
                class="text-info">{{ $user->email }}</a></td>
            {{-- <td>{{ $user->roles()->first()->name }}</td> --}}
            <td>{{ $user->major?->name }}</td>
            <td>{{ $user->major?->name }}</td>
            <td>
              <a class="btn btn-secondary mb-0 me-2 p-1 px-2">
                <x-icon icon="pencil" />
              </a>
              @if (!$user->hasRole(config('role.admin')))
                <button form="rol-destroy-{{ $user['id'] }}" type="submit"
                  class="btn btn-danger mb-0 me-2 p-1 px-2">
                  <x-icon icon="trash" />
                </button>
              @endif

              {{-- Eliminar rol --}}
              <form id="rol-destroy-{{ $user['id'] }}"
                action="{{ route('users.destroy', $user->id) }}" method="POST">
                @csrf
                @method('DELETE')
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
@endsection
