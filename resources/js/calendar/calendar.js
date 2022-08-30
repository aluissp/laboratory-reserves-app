import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import listPlugin from '@fullcalendar/list';
import esLocale from '@fullcalendar/core/locales/es';
import interactionPlugin from '@fullcalendar/interaction';
import { Tooltip } from 'bootstrap';

export default class MyCalendar {
  constructor(calendarEl) {
    this.calendar = new Calendar(calendarEl, {
      themeSystem: 'bootstrap5',
      plugins: [dayGridPlugin, timeGridPlugin, listPlugin, interactionPlugin],
      initialView: 'dayGridMonth',
      locale: esLocale,
      headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,listWeek',
      },
      eventTimeFormat: {
        hour: 'numeric',
        minute: '2-digit',
        meridiem: 'short',
      },
      aspectRatio: 1.75,
      eventDidMount: (info) => {
        new Tooltip(info.el, {
          title: info.event.extendedProps.description,
          placement: 'top',
          trigger: 'hover',
          container: 'body',
        });
      },
      dayMaxEventRows: true,
      views: {
        timeGrid: {
          dayMaxEventRows: 4,
        },
        dayGridMonth: {
          dayMaxEventRows: 5,
        },
      },
    });

    this.reserveController = null;
  }

  getCalendar() {
    return this.calendar;
  }

  reloadEvents(reserves) {
    reserves.map((reserve) => this.addNewReservationOnCalendar(reserve));
  }

  onDateClick(callback) {
    this.calendar.on('dateClick', (info) => {
      info.title = 'Crear nueva reserva';
      info.type = 'new';
      callback(info);
    });
  }

  addNewReservationOnCalendar(data) {
    const reserve = {
      id: data.id,
      title: data.name,
      start: new Date(`${data.date} ${data.start_time}`),
      end: new Date(`${data.date} ${data.start_time}`),
      start_time: data.start_time,
      end_time: data.end_time,
      color: data.color,
      assistants: data.assistants,
      description: data.description,
      editable: true,
    };

    this.calendar.addEvent(reserve);
  }
}
