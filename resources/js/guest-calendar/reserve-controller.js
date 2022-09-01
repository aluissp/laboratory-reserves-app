import EventForm from './components/event-form.js';
import MyCalendar from './calendar.js';
export default class ReserveController {
  constructor(calendarEl, reserves) {
    this.reservation = null;
    this.eventForm = new EventForm();

    this.myCalendar = new MyCalendar(calendarEl);
    this.myCalendar.reloadEvents(reserves);
    this.myCalendar.onEventClick((data) => this.openEventForm(data));
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
