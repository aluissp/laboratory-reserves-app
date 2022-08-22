@extends('layouts.app')

@section('content')
  <div class="container">
    <h3>Lista de laboratorios</h3>
    <div class="row mb-3">
      <label for="name"
        class="col-2 col-form-label text-md-start">{{ __('Buscar laboratorio') }}</label>

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
          <th scope="col">#</i></th>
          <th scope="col">Nombre</th>
          <th scope="col">Capacidad</th>
          <th scope="col">Ubicación</th>
          <th scope="col">Personal a cargo</th>
          <th scope="col">Acciones</th>
        </tr>
      </thead>
      <tbody id="labs-list-view">
        @foreach ($labs as $lab)
          <tr>
            <th scope="row">{{ $lab->id }}</th>
            <td>{{ $lab->name }} </td>
            <td>{{ $lab->capacity }}</td>
            <td>{{ $lab->location }}</td>
            <td>{{ $lab->staffInCharge?->name }}
              {{ $lab->staffInCharge?->surname }}</td>
            <td>
              <a href="{{ route('labs.edit', $lab->id) }}"
                class="btn btn-secondary mb-0 me-2 p-1 px-2">
                <x-icon icon="pencil" />
              </a>
              <button form="lab-destroy-{{ $lab['id'] }}" type="submit"
                class="btn btn-danger mb-0 me-2 p-1 px-2">
                <x-icon icon="trash" />
              </button>

              {{-- Eliminar rol --}}
              <form id="lab-destroy-{{ $lab['id'] }}"
                action="{{ route('labs.destroy', $lab->id) }}" method="POST">
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

<script src="{{ asset('js/admin/labs.js') }}" defer></script>
