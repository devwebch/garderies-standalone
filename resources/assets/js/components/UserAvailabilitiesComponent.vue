<template>
    <div class="wrapper">
        <div id="calendar"></div>
    </div>
</template>

<script>
    import 'fullcalendar/dist/fullcalendar.min.css';

    let vm;
    let data = {};
    let calendar;

    export default {
        data() { return data; },
        props: ['user'],
        mounted() {
            vm = this;

            // Instantiate the calendar
            calendar = $('#calendar').fullCalendar({
                themeSystem: 'bootstrap4',
                defaultView: 'agendaWeek',
                locale: 'fr-ch',
                header: {
                    left: 'title',
                    center: 'agendaWeek listWeek',
                    right: 'today prev,next'
                },
                buttonText: {
                    today: "Aujourd'hui",
                    week: "Vue semaine",
                    list: "Vue liste"
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
                        textColor: 'white'
                    },
                    {
                        url: '/api/bookings/user/' + this.user,
                        color: 'red',
                        textColor: 'white',
                        editable: false
                    }
                ],
                dayClick: function(date, event, view) {
                    let start   = date;
                    let end     = date.clone().add(2, 'hour');

                    // New event object
                    let newEvent = {
                        title: 'New availability',
                        start: start.format(),
                        end: end.format()
                    };

                    // Save the new event
                    axios.post('/api/availabilities', {
                        params: {
                            'event': newEvent,
                            'userID': vm.user
                        }
                    })
                    .then(function(response){
                        console.log(response);
                        // Assign the created ID to the event object
                        newEvent.id = response.data.id;
                        // Render the event on the calendar
                        calendar.fullCalendar('renderEvent', newEvent);
                    });
                },
                eventResize: function( event, delta, revertFunc, jsEvent, ui, view ) {
                    // Update the event
                    axios.put('/api/availabilities/' + event.id, {
                        params: {
                            'start': event.start,
                            'end': event.end,
                        }
                    })
                    .then(function(response){
                        console.log(response);
                    });
                },
                eventDrop: function (event, delta, revertFunc, jsEvent, ui, view) {
                    // Update the event
                    axios.put('/api/availabilities/' + event.id, {
                        params: {
                            'start': event.start,
                            'end': event.end,
                        }
                    })
                    .then(function(response){
                        console.log(response);
                    });
                },
                eventClick: function(event, jsEvent, view) {
                    //window.location = '/availabilities/' + event.id;
                },
                eventRender: function (event, element, view) {
                    element.append('<a href="/availabilities/' + event.id + '" class="edit-link">Editer</a>');
                }
            });
        }
    }
</script>

<style lang="scss">
    .edit-link {
        position:absolute;
        z-index: 10;
        bottom: 0;
        color: #fff;
    }
</style>