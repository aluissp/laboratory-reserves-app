import Reservation from './reservation.js';
import ReserveController from './reserve-controller.js';

document.addEventListener('DOMContentLoaded', async function () {
  const calendarEl = document.querySelector('#calendar');
  if (!calendarEl) {
    return;
  }

  const reserveController = new ReserveController(calendarEl);
  const reservation = await Reservation.init();
  reserveController.setReservation(reservation);
  reserveController.getCalendar().render();
});
