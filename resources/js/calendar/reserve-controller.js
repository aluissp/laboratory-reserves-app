import EventForm from './components/event-form.js';
import MyCalendar from './calendar.js';
export default class ReserveController {
  constructor(calendarEl, reserves) {
    this.reservation = null;
    this.eventForm = new EventForm();

    this.myCalendar = new MyCalendar(calendarEl);
    this.myCalendar.onDateClick((info) => this.openEventForm(info));
    this.myCalendar.reloadEvents(reserves);
    this.myCalendar.onEventClick((data) => this.openEventForm(data));
    this.myCalendar.onEventChange((data) => this.changeReserve(data));

    this.eventForm.onCreateClick((data) => this.createReserve(data));
    this.eventForm.onEditClick((data) => this.editReserve(data));
    this.eventForm.onDeleteClick((data) => this.deleteReserve(data));
  }

  setReservation(reservation) {
    this.reservation = reservation;
  }

  openEventForm(info) {
    if (info.type === 'reload') {
      info = this.reservation.getReserve(info.id);
      info.type = 'reload';
      info.title = 'Editar reserva';
    }
    this.eventForm.uploadForm(info);
  }

  getCalendar() {
    return this.myCalendar.getCalendar();
  }

  createReserve(data) {
    this.reservation.createNewReservation(data, (error, response) => {
      if (error) {
        this.eventForm.setErrors(error);
        return;
      }

      this.myCalendar.addNewReservationOnCalendar({ ...response.data });
      this.eventForm.closeForm(response.type, response.message);
    });
  }

  editReserve(data) {
    this.reservation.editReservation(data, (error, response) => {
      if (error) {
        this.eventForm.setErrors(error);
        return;
      }
      this.myCalendar.updateReservationOnCalendar({ ...response.data });
      this.eventForm.closeForm(response.type, response.message);
    });
  }

  deleteReserve(data) {
    this.reservation.deleteReservation(data, (error, response) => {
      if (error) {
        this.eventForm.setErrors(error);
        return;
      }
      this.myCalendar.deleteReservationOnCalendar({ ...response.data });
      this.eventForm.closeForm(response.type, response.message);
    });
  }

  changeReserve(info) {
    const reserve = this.reservation.getReserve(info.event.id);
    reserve.date = this.formatDate(info.event.start);

    this.reservation.editReservation(reserve, (error, response) => {
      if (error) {
        if (error.status == 403) {
          this.eventForm.showAlert(
            'danger',
            'No estas autorizado para modificar o eliminar esta reserva.'
          );
        } else if (error.lab_id) {
          this.eventForm.showAlert(
            'danger',
            `El laboratorio ${reserve.lab.name} ya se encuentra reservado desde ${reserve.start_time} horas hasta las ${reserve.end_time} horas.`
          );
        } else {
          this.eventForm.showAlert(
            'danger',
            `No se pudo actualizar la reserva para el laboratorio ${reserve.lab.name}.`
          );
        }
        info.revert();
        return;
      }

      this.myCalendar.updateReservationOnCalendar({ ...response.data });
      this.eventForm.showAlert(response.type, response.message);
    });
  }

  padTo2Digits(num) {
    return num.toString().padStart(2, '0');
  }

  formatDate(date) {
    return [
      date.getFullYear(),
      this.padTo2Digits(date.getMonth() + 1),
      this.padTo2Digits(date.getDate()),
    ].join('-');
  }
}
