import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import listPlugin from '@fullcalendar/list';
import esLocale from '@fullcalendar/core/locales/es';
import interactionPlugin from '@fullcalendar/interaction';

export default class MyCalendar {
  constructor(calendarEl) {
    this.calendar = new Calendar(calendarEl, {
      plugins: [dayGridPlugin, timeGridPlugin, listPlugin, interactionPlugin],
      initialView: 'dayGridMonth',
      locale: esLocale,
      headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,listWeek',
      },
      eventTimeFormat: {
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit',
        hour12: true,
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
      // display: 'block',
    };

    this.calendar.addEvent(reserve);
  }
}
