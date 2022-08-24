import { Calendar } from "@fullcalendar/core";
import dayGridPlugin from "@fullcalendar/daygrid";
import timeGridPlugin from "@fullcalendar/timegrid";
import listPlugin from "@fullcalendar/list";
import esLocale from "@fullcalendar/core/locales/es";
import interactionPlugin from "@fullcalendar/interaction";

export default class myCalendar {
    constructor(calendarEl) {
        this.calendar = new Calendar(calendarEl, {
            plugins: [
                dayGridPlugin,
                timeGridPlugin,
                listPlugin,
                interactionPlugin,
            ],
            initialView: "dayGridMonth",
            locale: esLocale,
            headerToolbar: {
                left: "prev,next today",
                center: "title",
                right: "dayGridMonth,timeGridWeek,listWeek",
            },
        });
    }

    getCalendar() {
        return this.calendar;
    }
}

// const formModal = new bootstrap.Modal(
//     document.querySelector("#add-event-modal")
// );
// const fecha = document.querySelector("#date");

// calendar.on("dateClick", (info) => {
//     console.log(info);
//     fecha.value = info.dateStr;
//     formModal.show();
// });
// calendar.render();
