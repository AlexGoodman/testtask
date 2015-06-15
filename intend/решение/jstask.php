<?php
/**
 * Created by PhpStorm.
 * User: Alexandr
 * Date: 30.05.2015
 * Time: 16:15
 */

 /*
  * Я так и не смог найти данный тулбар с сылками по адресу http://google.com Меня
  * пренаправляет на следующий адресс https://www.google.com.ua/webhp?hl=ru
  * Поэтому я просто сделал абстрактный пример того как могла бы происходить
  * выборка урл
  */
?>
<html>
    <head>
        <script type="text/javascript" src="jquery.js"></script>

    </head>
    <body>
        <script>
            var hrefArr = [];
            $(
                /*Идентификатор контейнера, где хранятся сылки с урл*/
            ).find('a').each(function(index, value){
                if($(this).attr('href')) {
                    hrefArr.push($(this).attr('href'));
                }
            });
        </script>
    </body>
</html>
