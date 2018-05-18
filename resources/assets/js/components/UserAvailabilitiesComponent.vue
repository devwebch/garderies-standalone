<template>
    <div class="wrapper">
        <div class="modal modal-event" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Disponibilité</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col">
                                <label for="date_start">Date start</label>
                                <flat-pickr
                                        v-model="editEvent.hour_start"
                                        :config="flatPickrConfig"
                                        class="form-control"
                                        placeholder="Select a date"
                                        name="date_start">
                                </flat-pickr>
                            </div>
                            <div class="form-group col">
                                <label for="date_end">Date end</label>
                                <flat-pickr
                                        v-model="editEvent.hour_end"
                                        :config="flatPickrConfig"
                                        class="form-control"
                                        placeholder="Select a date"
                                        name="date_end">
                                </flat-pickr>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-outline-danger btn-sm" v-on:click="userDeleteEvent">Supprimer cet élément</button>
                        <button type="button" class="btn btn-primary" v-on:click="userUpdateEvent">Sauvegarder</button>
                    </div>
                </div>
            </div>
        </div>

        <div id="calendar"></div>
    </div>
</template>

<script>
    import flatPickr from 'vue-flatpickr-component';
    import 'flatPickr/dist/flatpickr.css';
    import {French} from 'flatPickr/dist/l10n/fr';

    import 'fullcalendar/dist/fullcalendar.min.css';

    let vm;
    let data = {
        editEvent: {
            event: null,
            day_start: null,
            hour_start: null,
            hour_end: null
        },
        flatPickrConfig: {
            wrap: false,
            dateFormat: 'H:i',
            enableTime: true,
            noCalendar: true,
            time_24hr: true,
            minuteIncrement: 30,
            locale: French
        },
    };
    let calendar;

    export default {
        data() { return data; },
        props: ['user'],
        mounted() {
            vm = this;

            $('.modal-event').on('shown.bs.modal', function () {
                //$('#myInput').trigger('focus');
                console.log('modal opened');
            });

            // Instantiate the calendar
            calendar = $('#calendar').fullCalendar({
                themeSystem: 'bootstrap4',
                defaultView: 'agendaWeek',
                locale: 'fr-ch',
                header: {
                    left: 'title',
                    center: 'month agendaWeek listWeek',
                    right: 'today prev,next'
                },
                buttonText: {
                    today: "Aujourd'hui",
                    month: "Vue mois",
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
                        title: 'Nouvelle disponibilité',
                        description: '',
                        start: start.format(),
                        end: end.format(),
                        color: '#ffa000'
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
                    $('.modal-event').modal({show: true, focus: false}); // focus on the modal messes up with flatpickr
                    data.editEvent = {
                        event: event,
                        date_start: event.start.format('DD.MM.YYYY'),
                        hour_start: event.start.format('HH:mm'),
                        hour_end: event.end.format('HH:mm')
                    };
                },
                eventRender: function (event, element, view) {
                    element.append('<a href="/availabilities/' + event.id + '" class="edit-link">Editer</a>');
                }
            });
        },
        methods: {
            userUpdateEvent: function () {
                console.log('Update event');

                if (data.editEvent.event) {
                    // Format dates
                    let start   = data.editEvent.date_start + ' ' + data.editEvent.hour_start;
                    let end     = data.editEvent.date_start + ' ' + data.editEvent.hour_end;

                    // Update the event
                    axios.put('/api/availabilities/' + data.editEvent.event.id, {
                        params: {
                            'start': start,
                            'end': end,
                        }
                    })
                    .then(function(response){
                        $('.modal-event').modal('hide');
                        calendar.fullCalendar('refetchEvents');
                        data.editEvent.event = null;
                    });
                } else {
                    $('.modal-event').modal('hide');
                }
            },
            userDeleteEvent: function() {
                // Delete the event
                let eventID = data.editEvent.event.id;

                if (eventID) {
                    axios.delete('/api/availabilities/' + eventID, {
                        params: {}
                    })
                    .then(function(response){
                        $('.modal-event').modal('hide');
                        calendar.fullCalendar('refetchEvents');
                        data.editEvent.event = null;
                    });
                }
            }
        },
        components: {
            flatPickr
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