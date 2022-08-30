import EventForm from './components/event-form.js';
import MyCalendar from './calendar.js';
export default class ReserveController {
  constructor(calendarEl, reserves) {
    this.reservation = null;
    this.eventForm = new EventForm();

    this.myCalendar = new MyCalendar(calendarEl);
    this.myCalendar.onDateClick((info) => this.openEventForm(info));
    this.myCalendar.reloadEvents(reserves);
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
    this.reservation.createNewReservation(data, (error, response) => {
      if (error) {
        this.eventForm.setErrors(error);
        return;
      }

      this.myCalendar.addNewReservationOnCalendar({ ...response.data });
      this.eventForm.closeForm(response.type, response.message);
    });
  }
}
