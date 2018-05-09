<template>
    <div class="wrapper">
        <div id="calendar"></div>
    </div>
</template>

<script>
    export default {
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
                slotLabelFormat: 'HH:mm'
            });
        }
    }
</script>

<style lang="scss">
    @import '~fullcalendar/dist/fullcalendar.css';
</style>
