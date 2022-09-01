@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Detalles de la reserva</div>

          <div class="card-body">

            <form>
              <div class="row">
                <div class="mb-3 col-6">
                  <label for="name"
                    class="col-md-4 col-form-label">Nombre</label>
                  <input id="name" type="text" disabled
                    class="form-control  form-control-user" name="name"
                    value="{{ $reserve->name }}">
                </div>
                <div class="mb-3 col-6">
                  <label for="assistants"
                    class="col-md-4 col-form-label">Asistentes</label>
                  <input id="assistants" type="number"
                    class="form-control  form-control-user" name="assistants"
                    disabled value="{{ $reserve->assistants }}">
                </div>

              </div>

              <div class="row mb-3">
                <div class='px-3'>
                  <div class="form-floating">
                    <textarea disabled class="form-control " id="description" name="description"
                      style="height: 100px" placeholder="Escribe una descripción rapida.">{{ $reserve->description }}
                      </textarea>
                    <label for="description">Descripción</label>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="mb-3 col-6">
                  <label for="date"
                    class="col-md-4 col-form-label">Fecha</label>
                  <input id="date" type="date" disabled
                    class="form-control form-control-user" name="date"
                    value="{{ $reserve->date }}">

                </div>
                <div class="mb-3 col-6">
                  <label for="color" class="col-form-label">Color</label>
                  <input id="color" type="color" disabled
                    class="form-control form-control-user" name="color"
                    value="{{ $reserve->color }}">

                </div>
              </div>

              <div class="row">
                <div class="mb-3 col-6">
                  <label for="start_time" class="col-md-4 col-form-label">Hora
                    inicial</label>
                  <input id="start_time" type="time"
                    class="form-control  form-control-user" name="start_time"
                    step="1" disabled value="{{ $reserve->start_time }}">

                </div>
                <div class="mb-3 col-6">
                  <label for="end_time" class="col-form-label">Hora
                    final</label>
                  <input id="end_time" type="time" step="1" disabled
                    class="form-control form-control-user" name="end_time"
                    value="{{ $reserve->end_time }}">

                </div>
              </div>

              <div class="row mb-3 px-3">
                <label class="col-form-label">Laboratorio reservado</label>
                <select disabled class="form-select form-control-user"
                  name="lab_id">
                  <option>
                    {{ $reserve->lab->name }} - {{ $reserve->lab->location }}
                  </option>
                </select>
                <div id='info-reserve' class='alert alert-light mt-4'>
                  <p>
                    {{ 'Reservado por ' . $reserve->user->name . ' ' . $reserve->user->surname }}.
                  </p>
                  <p>{{ "Reservado el $reserve->created_at" }}.</p>
                </div>
              </div>
              <div class="row mb-0">
                <div class="col-md-6">
                  <a href="{{ route('my-reserve.index') }}"
                    class="btn btn-primary btn-user">
                    {{ __('Volver atras') }}
                  </a>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
