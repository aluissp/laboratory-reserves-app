@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="col-md-12">
      <div id="calendar">
      </div>
    </div>
  </div>
@endsection

<!-- Add event Modal -->
<div class="modal fade" id="add-event-modal" data-bs-backdrop="static"
  data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
  aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Crear nueva reserva
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"
          aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" id="add-new-event"
          action="{{ route('labs.store') }}">
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
              <label for="assistants"
                class="col-md-4 col-form-label">Asistentes</label>
              <input id="assistants" type="number"
                class="form-control @error('assistants') is-invalid @enderror form-control-user"
                name="assistants" value="{{ old('assistants') }}">

              @error('assistants')
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
                  id="description" name="description" style="height: 100px"
                  placeholder="Escribe una descripción rapida.">{{ old('description') }}</textarea>
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
              <label for="date"
                class="col-md-4 col-form-label">Fecha</label>
              <input id="date" type="number"
                class="form-control @error('date') is-invalid @enderror form-control-user"
                name="date" value="{{ old('date') }}">

              @error('date')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>
            <div class="mb-3 col-6">
              <label for="color" class="col-form-label">Color</label>
              <input id="color" type="color"
                class="form-control @error('color') is-invalid @enderror form-control-user"
                name="color" value="{{ old('color') }}">

              @error('color')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>
          </div>
          <div class="row">
            <div class="mb-3 col-6">
              <label for="startTime" class="col-md-7 col-form-label">Hora
                inicial</label>
              <input id="startTime" type="time"
                class="form-control @error('startTime') is-invalid @enderror form-control-user"
                name="startTime" value="{{ old('startTime') }}">

              @error('startTime')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>
            <div class="mb-3 col-6">
              <label for="endTime" class="col-form-label">Hora final</label>
              <input id="endTime" type="time"
                class="form-control @error('endTime') is-invalid @enderror form-control-user"
                name="endTime" value="{{ old('endTime') }}">

              @error('endTime')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary"
          data-bs-dismiss="modal">Cerrar</button>
        <button type="submit" form="add-new-event"
          class="btn btn-primary">Guardar reserva</button>
      </div>
    </div>
  </div>
</div>

<script src="{{ asset('js/calendar/main.js') }}" defer></script>
