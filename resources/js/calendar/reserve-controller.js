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

    this.eventForm.onCreateClick((data) => this.createReserve(data));
    this.eventForm.onEditClick((data) => this.editReserve(data));
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
}
