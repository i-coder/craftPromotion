<h3>Laravel Sail</h3>

Запускаем установка пакетов <br>
composer install

Запуск сборки проекта <br>
<strong>./vendor/bin/sail up <br></strong>

После сборки Docker нужно запустить миграцию <br>
<strong>./vendor/bin/sail artisan migrate  <br></strong>

После миграции нужно запустить сидеры<br>
<strong>./vendor/bin/sail artisan db:seed  <br></strong>

Если все успешно прошло то система готова к работе

Все тесты можно произвести в файле user.http

![img_1.png](img_1.png)

Пример пополнее депозита
![img_3.png](img_3.png)

