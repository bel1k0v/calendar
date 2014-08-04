Calendar
========

Install:
  1. git clone https://github.com/dmitrijbelikov/calendar.git
  2. cd calendar
  3. composer install (dependencies)
  4. make sure that ./assets ./protected/runtime catalogs are writable
  6. make your config files in ./protected/config/ (example in main.php),
     and don't forget about console.dev.php
  7. cd ./protected
  8. create MySQL database ./yiic migrate to apply migrations
  9. and of course don't forget about your apache or nginx config
  10. Have fun!

Future improvements:
  1. To do as module
  2. Generate indexes (maybe) if it'll be a multiuser tool

Links:
  1. http://yiiframework.com/ - Yii
  2. http://yiiframework.ru/ - Yii RU
  3. http://arshaw.com/fullcalendar/ - FullCalendar jQuery Plugin
  4. http://jquery.com/ - planet jQuery

