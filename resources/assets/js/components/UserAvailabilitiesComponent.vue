<template>
    <div class="wrapper">
        <div id="calendar"></div>
    </div>
</template>

<script>
    import 'fullcalendar/dist/fullcalendar.min.css';

    let data = {};

    export default {
        data() { return data; },
        props: ['user'],
        mounted() {
            $('#calendar').fullCalendar({
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
                ]
            });

        }
    }
</script>