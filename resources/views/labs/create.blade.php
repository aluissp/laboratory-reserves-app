@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Registrar un nuevo laboratorio</div>

          <div class="card-body">
            <form method="POST" action="{{ route('labs.store') }}">
              @csrf
              <div class="row">
                <div class="mb-3 col-6">
                  <label for="name"
                    class="col-md-4 col-form-label">Nombre</label>
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
                <div class="mb-3 col-6">
                  <label for="location"
                    class="col-md-4 col-form-label">Ubicación</label>
                  <input id="location" type="text"
                    class="form-control @error('location') is-invalid @enderror form-control-user"
                    name="location" value="{{ old('location') }}">

                  @error('location')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>

              </div>

              <div class="row mb-3">
                <div class='px-3'>
                  <div class="form-floating">
                    <textarea class="form-control @error('description') is-invalid @enderror"
                      id="description" name="description" value="{{ old('description') }}"
                      style="height: 100px" placeholder="Escribe una descripción rapida."></textarea>
                    <label for="description">Descripción</label>
                  </div>
                  @error('description')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
              </div>

              <div class="row">
                <div class="mb-3 col-6">
                  <label for="capacity"
                    class="col-md-4 col-form-label">Aforo</label>
                  <input id="capacity" type="number"
                    class="form-control @error('capacity') is-invalid @enderror form-control-user"
                    name="capacity" value="{{ old('capacity') }}">

                  @error('capacity')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
                <div class="mb-3 col-6">
                  <label for="staff" class="col-form-label">Personal a
                    cargo</label>
                  <input id="staff" list="staffs"
                    class="form-control @error('staff') is-invalid @enderror form-control-user"
                    name="staff" value="{{ old('staff') }}">
                  <datalist id="staffs">
                    @foreach ($staffs as $staff)
                      <option
                        value="{{ $staff->id }} - {{ $staff->name }} {{ $staff->surname }}">
                    @endforeach
                  </datalist>

                  @error('staff')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
              </div>
              <div class="row mb-0">
                <div class="col-md-6">
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
