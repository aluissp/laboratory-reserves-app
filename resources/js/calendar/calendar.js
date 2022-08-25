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

        this.reserveController = null;
    }

    getCalendar() {
        return this.calendar;
    }

    setReserveController(reserveController) {
        this.reserveController = reserveController;
    }
}

