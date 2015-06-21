<?php
/**
 * Created by PhpStorm.
 * User: Alexandr
 * Date: 23.05.2015
 * Time: 23:40
 */


namespace app\models;

use Yii;
use yii\base\Model;

class Smsc extends Model{

    public $phone;

    const SMSC_LOGIN = "demo";            // логин клиента
    const SMSC_PASSWORD = "demo";    // пароль или MD5-хеш пароля в нижнем регистре
    const SMSC_POST = 0; // использовать метод POST
    const SMSC_HTTPS = 0;                // использовать HTTPS протокол
    const SMSC_CHARSET = "windows-1251";    // кодировка сообщения: utf-8, koi8-r или windows-1251 (по умолчанию)
    const SMSC_DEBUG = 0; // флаг отладки



    public function rules()
    {
        return [
            ['phone', 'required'],
            ['phone', 'match', 'pattern' => '/\+38\(0\d{2,2}\)\d{7,7}/']
        ];
    }



// Функция отправки SMS
//
// обязательные параметры:
//
// $phones - список телефонов через запятую или точку с запятой
// $message - отправляемое сообщение
//
// необязательные параметры:
//
// $translit - переводить или нет в транслит (1,2 или 0)
// $time - необходимое время доставки в виде строки (DDMMYYhhmm, h1-h2, 0ts, +m)
// $id - идентификатор сообщения. Представляет собой 32-битное число в диапазоне от 1 до 2147483647.
// $format - формат сообщения (0 - обычное sms, 1 - flash-sms, 2 - wap-push, 3 - hlr, 4 - bin, 5 - bin-hex, 6 - ping-sms, 7 - mms, 8 - mail, 9 - call)
// $sender - имя отправителя (Sender ID). Для отключения Sender ID по умолчанию необходимо в качестве имени
// передать пустую строку или точку.
// $query - строка дополнительных параметров, добавляемая в URL-запрос ("valid=01:00&maxsms=3&tz=2")
// $files - массив путей к файлам для отправки mms или e-mail сообщений
//
// возвращает массив (<id>, <количество sms>, <стоимость>, <баланс>) в случае успешной отправки
// либо массив (<id>, -<код ошибки>) в случае ошибки

    public function send_sms(
        $phones,
        $message,
        $translit = 0,
        $time = 0,
        $id = 0,
        $format = 0,
        $sender = false,
        $query = "",
        $files = array()
    ){
        static $formats = array(1 => "flash=1", "push=1", "hlr=1", "bin=1", "bin=2", "ping=1", "mms=1", "mail=1", "call=1");

        $m = $this -> _smsc_send_cmd("send", "cost=3&phones=" . urlencode($phones) . "&mes=" . urlencode($message) .
            "&translit=$translit&id=$id" . ($format > 0 ? "&" . $formats[$format] : "") .
            ($sender === false ? "" : "&sender=" . urlencode($sender)) .
            ($time ? "&time=" . urlencode($time) : "") . ($query ? "&$query" : ""), $files);

        // (id, cnt, cost, balance) или (id, -error)

        if (self::SMSC_DEBUG) {
            if ($m[1] > 0)
                echo "Сообщение отправлено успешно. ID: $m[0], всего SMS: $m[1], стоимость: $m[2], баланс: $m[3].\n";
            else
                echo "Ошибка №", -$m[1], $m[0] ? ", ID: " . $m[0] : "", "\n";
        }

        return $m;
    }


    // ВНУТРЕННИЕ ФУНКЦИИ

// Функция вызова запроса. Формирует URL и делает 3 попытки чтения

    protected function _smsc_send_cmd($cmd, $arg = "", $files = array())
    {
        $url = (self::SMSC_HTTPS ? "https" : "http")."://smsc.ru/sys/$cmd.php?login=".urlencode(self::SMSC_LOGIN)."&psw=".urlencode(self::SMSC_PASSWORD)."&fmt=1&charset=".self::SMSC_CHARSET."&".$arg;

        $i = 0;
        do {
            if ($i) {
                sleep(2 + $i);

                if ($i == 2)
                    $url = str_replace('://smsc.ru/', '://www2.smsc.ru/', $url);
            }

            $ret = $this -> _smsc_read_url($url, $files);
        }
        while ($ret == "" && ++$i < 4);

        if ($ret == "") {
            if (self::SMSC_DEBUG)
                echo "Ошибка чтения адреса: $url\n";

            $ret = ","; // фиктивный ответ
        }

        $delim = ",";

        if ($cmd == "status") {
            parse_str($arg);

            if (strpos($id, ","))
                $delim = "\n";
        }

        return explode($delim, $ret);
    }

// Функция чтения URL. Для работы должно быть доступно:
// curl или fsockopen (только http) или включена опция allow_url_fopen для file_get_contents

    protected function _smsc_read_url($url, $files)
    {
        $ret = "";
        $post = self::SMSC_POST || strlen($url) > 2000 || $files;

        if (function_exists("curl_init"))
        {
            static $c = 0; // keepalive

            if (!$c) {
                $c = curl_init();
                curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($c, CURLOPT_CONNECTTIMEOUT, 10);
                curl_setopt($c, CURLOPT_TIMEOUT, 60);
                curl_setopt($c, CURLOPT_SSL_VERIFYPEER, 0);
            }

            curl_setopt($c, CURLOPT_POST, $post);

            if ($post)
            {
                list($url, $post) = explode("?", $url, 2);

                if ($files) {
                    parse_str($post, $m);

                    foreach ($m as $k => $v)
                        $m[$k] = isset($v[0]) && $v[0] == "@" ? sprintf("\0%s", $v) : $v;

                    $post = $m;
                    foreach ($files as $i => $path)
                        if (file_exists($path))
                            $post["file".$i] = function_exists("curl_file_create") ? curl_file_create($path) : "@".$path;
                }

                curl_setopt($c, CURLOPT_POSTFIELDS, $post);
            }

            curl_setopt($c, CURLOPT_URL, $url);

            $ret = curl_exec($c);
        }
        elseif ($files) {
            if (self::SMSC_DEBUG)
                echo "Не установлен модуль curl для передачи файлов\n";
        }
        else {
            if (!self::SMSC_HTTPS && function_exists("fsockopen"))
            {
                $m = parse_url($url);

                if (!$fp = fsockopen($m["host"], 80, $errno, $errstr, 10))
                    $fp = fsockopen("212.24.33.196", 80, $errno, $errstr, 10);

                if ($fp) {
                    fwrite($fp, ($post ? "POST $m[path]" : "GET $m[path]?$m[query]")." HTTP/1.1\r\nHost: smsc.ru\r\nUser-Agent: PHP".($post ? "\r\nContent-Type: application/x-www-form-urlencoded\r\nContent-Length: ".strlen($m['query']) : "")."\r\nConnection: Close\r\n\r\n".($post ? $m['query'] : ""));

                    while (!feof($fp))
                        $ret .= fgets($fp, 1024);
                    list(, $ret) = explode("\r\n\r\n", $ret, 2);

                    fclose($fp);
                }
            }
            else
                $ret = file_get_contents($url);
        }

        return $ret;
    }

}