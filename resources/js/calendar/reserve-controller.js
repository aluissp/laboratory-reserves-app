import EventForm from './components/event-form.js';
import MyCalendar from './calendar.js';
export default class ReserveController {
  constructor(calendarEl) {
    this.reservation = null;
    this.eventForm = new EventForm();

    this.myCalendar = new MyCalendar(calendarEl);
    this.myCalendar.onDateClick((info) => this.openEventForm(info));
    this.eventForm.onCreateClick((data) => this.createReserve(data));
  }

  setReservation(reservation) {
    this.reservation = reservation;
  }

  openEventForm(info) {
    this.eventForm.uploadForm(info);
  }

  getCalendar() {
    return this.myCalendar.getCalendar();
  }

  createReserve(data) {
    this.reservation.createNewReservation(data, (res) => console.log(res));
  }
}
