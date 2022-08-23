import { Calendar } from "@fullcalendar/core";
import dayGridPlugin from "@fullcalendar/daygrid";
import timeGridPlugin from "@fullcalendar/timegrid";
import listPlugin from "@fullcalendar/list";
import esLocale from "@fullcalendar/core/locales/es";
import interactionPlugin from "@fullcalendar/interaction";

document.addEventListener("DOMContentLoaded", function () {
    const calendarEl = document.querySelector("#calendar");
    if (!calendarEl) {
        return;
    }

    const formModal = new bootstrap.Modal(
        document.querySelector("#add-event-modal")
    );

    let calendar = new Calendar(calendarEl, {
        plugins: [dayGridPlugin, timeGridPlugin, listPlugin, interactionPlugin],
        initialView: "dayGridMonth",
        locale: esLocale,
        headerToolbar: {
            left: "prev,next today",
            center: "title",
            right: "dayGridMonth,timeGridWeek,listWeek",
        },
    });

    calendar.on("dateClick", (info) => {
        console.log(info);
        formModal.show();
    });
    calendar.render();
});
