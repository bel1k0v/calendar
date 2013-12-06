$(document).ready(function() {
  var calendar = $('#calendar');

  calendar.fullCalendar({
    header: {
      left: 'prev,next today',
      center: 'title',
      right: 'month,agendaWeek,agendaDay'
    },
    editable: true,
    selectable: true,
    selectHelper: true,
    select: function(start, end, allDay) {
      _createDialog('#event', '#calendar', start, end, allDay);
       calendar.fullCalendar('unselect');
    },
    events: '/meeting/all',
    eventClick: function(event) {
      _updateDialog('#event', '#calendar', event);
    }
  });

  function _createDialog(dialog_id, calendar_id, start, end, allDay) {
    var dialog = $(dialog_id),
        calendar = $(calendar_id);

    dialog.find('#start_date').html(start);
    dialog.find('#end_date').html(end);
    dialog.find('#title').val('');
    dialog.find('#type').val('');
    dialog.find('#place').val('');

    var start = Math.round(start.getTime() / 1000);
    var end = Math.round(end.getTime() / 1000);

    dialog.dialog({
      modal: true,
      title: 'New meeting',
      buttons: {
        'Create': function() {
          var title = dialog.find('#title').val(),
              type  = dialog.find('#type').val(),
              place = dialog.find('#place').val();

          if (title && type) {
            $.ajax({
              type: 'POST',
              url: '/meeting/create',
              data: {
                title: title,
                type: type,
                place: place,
                start: start,
                end: end,
                confirmed: 'false'
              },
              dataType: 'json',
              success: function(data) {
                dialog.dialog('destroy');
                if (data.result == true) {
                  calendar.fullCalendar('renderEvent', {
                      id: data.modelAttributes.id,
                      title: data.modelAttributes.title,
                      type: data.modelAttributes.type,
                      place: data.modelAttributes.place,
                      start: start,
                      end: end,
                      allDay: allDay
                    },
                    true
                  );
                } else if (data.notConfirmed) {
                  if (confirm('У вас уже назначено на эту дату. Вы уверены?')) {
                    $.ajax({
                      type: 'POST',
                      url: '/meeting/create',
                      data: {
                        title: title,
                        type: type,
                        place: place,
                        start: start,
                        end: end,
                        confirmed: 'true'
                      },
                      dataType: 'json',
                      success: function(data) {
                        if (data.result == true) {
                          calendar.fullCalendar('renderEvent', {
                              id: data.modelAttributes.id,
                              title: data.modelAttributes.title,
                              type: data.modelAttributes.type,
                              place: data.modelAttributes.place,
                              start: start,
                              end: end,
                              allDay: allDay
                            },
                            true
                          );
                        } else {
                          var message = '';
                          for (k in data.modelErrors)
                            message += data.modelErrors[k] + ' ';
                          alert(message);
                        }

                      }
                    });
                  } else
                    return;
                } else {
                  var message = '';
                  for (k in data.modelErrors)
                    message += data.modelErrors[k] + ' ';
                  alert(message);
                }
              }
            });
          }
        }
      }
    });
  }

  function _updateDialog(dialog_id, calendar_id, event) {
    var dialog = $(dialog_id),
        calendar = $(calendar_id);

    dialog.find('#start_date').html(event.start);
    dialog.find('#end_date').html(event.end);
    dialog.find('#title').val(event.title);
    dialog.find('#type').val(event.type || '');
    dialog.find('#place').val(event.place || '');

    dialog.dialog({
      modal: true,
      title: event.title,
      buttons: {
        'Delete': function() {
          $.post('/meeting/delete/id/' + event.id, function(result) {
            console.log(result);
            if (result) {
              dialog.dialog('destroy');
              calendar.fullCalendar('removeEvents', event.id);
            }
          });
        },
        'Update': function() {
          var id  = event.id,
              title = dialog.find('#title').val(),
              type  = dialog.find('#type').val(),
              place = dialog.find('#place').val(),
              start = Math.round(event.start.getTime() / 1000),
              end   = event.end == 'undefined' ? Math.round(event.end.getTime() / 1000) : start;

          console.log(id + ' ' + title + ' ' + type + ' ' + place + ' ' + start + ' ' + end);

          if (title && type) {
            $.ajax({
              type: 'POST',
              url: '/meeting/update/id/' + id,
              data: {
                title: title,
                type: type,
                place: place,
                start: start,
                end: end,
                confirmed: 'false'
              },
              dataType: 'json',
              success: function(data) {
                dialog.dialog('destroy');
                if (data.result == true) {
                  calendar.fullCalendar('removeEvents', event.id);
                  calendar.fullCalendar('renderEvent', {
                      id: data.modelAttributes.id,
                      title: data.modelAttributes.title,
                      type: data.modelAttributes.type,
                      place: data.modelAttributes.place,
                      start: event.start,
                      end: event.end,
                      allDay: event.allDay
                    },
                    true
                  );
                } else if (data.notConfirmed) {
                  if (confirm('Вы уверены?')) {
                    $.ajax({
                      type: 'POST',
                      url: '/meeting/update/id/' + id,
                      data: {
                        title: title,
                        type: type,
                        place: place,
                        start: start,
                        end: end,
                        confirmed: true
                      },
                      dataType: 'json',
                      success: function(data) {
                        if (data.result == true) {
                          calendar.fullCalendar('removeEvents', event.id);
                          calendar.fullCalendar('renderEvent', {
                              id: data.modelAttributes.id,
                              title: data.modelAttributes.title,
                              type: data.modelAttributes.type,
                              place: data.modelAttributes.place,
                              start: event.start,
                              end: event.end,
                              allDay: event.allDay
                            },
                            true
                          );
                        } else {
                          var message = '';
                          for (k in data.modelErrors)
                            message += data.modelErrors[k] + ' ';
                          alert(message);
                        }
                      }
                    });
                  } else
                    return ;
                } else {
                    var message = '';
                    for (k in data.modelErrors)
                      message += data.modelErrors[k] + ' ';
                    alert(message);
                }
              }
            });
          } else
            alert('Please enter title and type both.');
        }
      }
    });
  }
});