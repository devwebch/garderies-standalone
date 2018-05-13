<template>
    <div class="wrapper">
        <div id="calendar"></div>
    </div>
</template>

<script>
    import 'fullcalendar/dist/fullcalendar.min.css';

    let vm;
    let data = {
        events: [
            {
                title: 'Lorem ipsum',
                start: '2018-05-10T10:00:00',
                end: '2018-05-10T16:00:00'
            },
            {
                title: 'Lorem ipsum 2',
                start: '2018-05-11T09:00:00',
                end: '2018-05-11T15:00:00'
            }
        ],
        newEvents: []
    };
    let calendar;

    export default {
        data() { return data; },
        props: ['user'],
        mounted() {
            vm = this;

            calendar = $('#calendar').fullCalendar({
                themeSystem: 'bootstrap4',
                defaultView: 'agendaWeek',
                locale: 'fr-ch',
                buttonText: {
                    today: "Aujourd'hui"
                },
                weekends: false,
                allDaySlot: false,
                columnHeaderFormat: 'ddd DD.MM',
                timeFormat: 'HH:mm',
                slotLabelFormat: 'HH:mm',
                minTime: '06:00:00',
                maxTime: '19:00:00',
                editable: true,
                eventSources: [
                    {
                        url: '/api/availabilities/user/' + this.user,
                        color: 'blue',
                        textColor: 'white'
                    },
                    {
                        url: '/api/bookings/user/' + this.user,
                        color: 'red',
                        textColor: 'white'
                    }
                ],
                events: data.events,
                dayClick: function(date, event, view) {
                    let start   = date;
                    let end     = date.clone().add(2, 'hour');

                    let newEvent = {
                        title: 'New availability',
                        start: start.format(),
                        end: end.format()
                    };


                    axios.post('/api/availabilities', {
                        params: {
                            'event': newEvent,
                            'userID': vm.user
                        }
                    })
                    .then(function(response){
                        console.log(response);
                        calendar.fullCalendar('renderEvent', newEvent);
                    });
                },
                eventResize: function( event, delta, revertFunc, jsEvent, ui, view ) {
                    console.log(event.id);
                    calendar.fullCalendar('updateEvent', event);
                }
            });
        }
    }
</script>