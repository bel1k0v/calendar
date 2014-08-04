(function ($, window, document, undefined) {
  "use strict";

  $(document).ready(function() {
    var $calendar = $('#calendar');

    $calendar.fullCalendar({
      header: {
        left: 'prev',
        center: 'title',
        right: 'next'
      },
      selectable: true,
      events: function(start, end, timezone, callback) {
        $.ajax({
          url: 'meeting/all',
          dataType: 'json',
          data: {
            // our hypothetical feed requires UNIX timestamps
            start: start.unix(),
            end: end.unix()
          },
          success: function(doc) {
            var events = [];
            $(doc).each(function() {
              events.push({
                title: $(this).attr('title'),
                start: new Date($(this).attr('start') * 1000) // will be parsed
              });
            });

            callback(events);
          }
        });
      },
      dayClick: function(date, jsEvent, view) {

        var $view = $('.fc-view'), modalHTML = "";
        modalHTML += "<div class='fc-modal'>";
        modalHTML += "<div class='fc-tip'></div>";
        modalHTML += "<div class='fc-day-events'></div>";
        modalHTML += "<textarea class='fc-new-event form-control' placeholder='Ctrl + Enter - add event' cols='25' rows='5'></textarea>";
        modalHTML += "<\/div>";


        if ($view.find('.fc-modal').length) {
          $('.fc-modal').remove();
        }
        $view.append(modalHTML);

        var $modal = $('.fc-modal');

        setTimeout(function() {
          var $ol = $('.fc-cell-overlay'),
            top = $ol.prop('offsetTop') + 10 + "px",
            left = $ol.prop('offsetLeft') + $ol.prop('offsetWidth') + 6 + "px",
            className = 'fc-modal-left';

          if ($ol.prop('offsetLeft') + $ol.prop('offsetWidth') + $modal.outerWidth(true) >= $view.width()) {
            left = $ol.prop('offsetLeft') - $modal.outerWidth(true) - 6;
            className = 'fc-modal-right';
          }

          $modal.addClass(className).css({
            top: top,
            left: left
          });
          $modal.find('textarea').on('keydown', function (e) {
            if ((e.keyCode == 10 || e.keyCode == 13) && e.ctrlKey) {
              e.preventDefault();

              var title = $.trim($(this).val());
              var eventData, serverEventData;
              if (title) {
                eventData = {
                  title: title,
                  start: date,
                  end: date
                };
                serverEventData = {
                  title: title,
                  start: date.unix(),
                  end: date.unix()
                };
                console.log(eventData);
                $.post('/meeting/create', serverEventData,
                  function(data) {
                    console.log(data);
                  }
                );
                $('#calendar').fullCalendar('renderEvent', eventData, true); // stick? = true
              }

              $modal.remove();
            }
          });
        }, 100);
      }
    });
  });
})(jQuery, window, document, undefined);

