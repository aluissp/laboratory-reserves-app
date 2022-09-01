@extends('layouts.app')

@section('content')
  <div class="container">
    <h3>Lista de reservas</h3>

    @forelse ($reservations as $reserve)
      <div class="d-flex justify-content-between bg-light mb-3 rounded px-4 py-2">
        <p class="me-2 mb-0 fw-bold">
          <input disabled class="form-control-plaintext fw-bold"
            value="{{ $reserve->name }}">
        </p>
        <p class="me-2 mb-0 d-md-block">
          <input disabled class="form-control-plaintext "
            value="Asistentes: {{ $reserve->assistants }}">

        </p>
        <p class="me-2 mb-0  d-md-block">
          Fecha: {{ $reserve->date }}, {{ $reserve->start_time }} -
          {{ $reserve->end_time }}
        </p>

        <p class="me-2 mb-0 d-none  d-md-block">
          <input disabled class="form-control-plaintext "
            value="Ubicación: {{ $reserve->lab->location }}">
        </p>
        <a href="{{ route('my-reserve.show', $reserve->id) }}"
          class="btn btn-secondary mb-0 me-2 p-1 px-2">
          <i class="fa-solid fa-eye"></i>
        </a>
        <button form="reserve-destroy-{{ $reserve->id }}" type="submit"
          class="btn btn-danger mb-0 me-2 p-1 px-2">
          <x-icon icon="trash" />
        </button>

        <form id="reserve-destroy-{{ $reserve->id }}"
          action="{{ route('my-reserve.destroy', $reserve->id) }}" method="POST">
          @csrf
          @method('DELETE')
        </form>
      </div>
    @empty
      <div class="d-flex justify-content-between bg-light mb-3 rounded px-4 py-2">
        <p class="text-center m-2">Aún no se ha registrado ninguna reserva.</p>
      </div>
    @endforelse
    {{ $reservations->links() }}
  </div>
@endsection
