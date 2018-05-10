<template>
    <div class="wrapper">
        <div id="calendar"></div>
    </div>
</template>

<script>
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
                slotLabelFormat: 'HH:mm',
                eventSources: [
                    {
                        url: '/api/availabilities/user/' + this.user,
                        color: 'blue',
                        textColor: 'white'
                    }
                ]
            });

        }
    }
</script>

<style lang="scss">
    @import '~fullcalendar/dist/fullcalendar.css';
</style>
