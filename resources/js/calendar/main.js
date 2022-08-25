import myCalendar from "./calendar.js";
import Reservation from "./reservation.js";
import ReserveController from "./reserve-controller.js";

document.addEventListener("DOMContentLoaded", async function () {
    const calendarEl = document.querySelector("#calendar");
    if (!calendarEl) {
        return;
    }
    
    const calendar = new myCalendar(calendarEl);
    const reserveController = new ReserveController();
    const reservation = await Reservation.init();

    reserveController.setReservation(reservation);
    calendar.setReserveController(reserveController);

    // const formModal = new bootstrap.Modal(
    //     document.querySelector("#events-modal")
    // );
    // formModal.show()
    calendar.getCalendar().render();
});
