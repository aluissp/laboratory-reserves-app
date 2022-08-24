import myCalendar from "./calendar.js";

document.addEventListener("DOMContentLoaded", function () {
    const calendarEl = document.querySelector("#calendar");
    if (!calendarEl) {
        return;
    }
    const calendar = new myCalendar(calendarEl);
    console.log(calendar);
    console.log(calendar.getCalendar());
});

