@extends('layouts.app')

@section('content')
  <div class="container">
    <h3>Agregar carrera</h3>
    <div class="row">
      <form method="POST" action="{{ route('majors.store') }}">
        @csrf
        <div class="row mb-3">
          <label for="name"
            class="col-3 col-form-label text-md-start">{{ __('Ingrese el nombre de la carrera') }}</label>

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
      @forelse ($majors as $major)
        {{-- Immerso edit --}}
        <form method="POST" action="{{ route('majors.update', $major->id) }}"
          class="d-flex justify-content-between bg-light mb-3 rounded px-4 py-2">
          @csrf
          @method('PUT')
          <div class="d-flex align-items-center">
            <p class="me-2 mb-0 fw-bold">
              <input name="name-update" class="form-control-plaintext fw-bold"
                value="{{ $major->name }}">
            </p>
            <p class="me-2 mb-0 d-none d-md-block">
              Creado el: {{ $major->created_at }}
            </p>
            <p class="me-2 mb-0 d-none d-md-block">
              Actualizado el: {{ $major->updated_at }} </p>
            </p>


          </div>
          <div class="d-flex  align-items-center">
            <button type="submit" class="btn btn-secondary mb-0 me-2 p-1 px-2">
              <x-icon icon="pencil" />
            </button>
            <button form="major-destroy-{{ $major->id }}" type="submit"
              class="btn btn-danger mb-0 me-2 p-1 px-2">
              <x-icon icon="trash" />
            </button>
          </div>
        </form>

        {{-- Eliminar carrera --}}
        <form id="major-destroy-{{ $major->id }}"
          action="{{ route('majors.destroy', $major->id) }}" method="POST">
          @csrf
          @method('DELETE')
        </form>
      @empty
        <div
          class="d-flex justify-content-between bg-light mb-3 rounded px-4 py-2">
          <div class="text-center">
            <p>Aún no se ha registrado ninguna carrera.</p>
          </div>
        </div>
      @endforelse
    </div>
    {{ $majors->links() }}
  </div>
@endsection

<script src="{{ asset('js/admin/majors.js') }}" defer></script>
