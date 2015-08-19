<?php
/**
 * Created by PhpStorm.
 * User: Alexandr
 * Date: 19.08.2015
 * Time: 12:04
 */

/*
 * В принципе, я нашел решение абсолютно идентичного задания вот по этой
 * ссылке https://gist.github.com/josecanciani/ff535426bd5d453ef9c2
 * За исключением раскрашивания клеток. Но руководствуясь принципом
 * "Велосепедостроения" я соорудил свой собственный "Самокат" с бэкджэком
 * и продажной любовью:)
 * */

class AsciiTabel{
    const S_PLUS = '+';
    const S_MINUS = '-';
    const S_VLINE = '|';
    const N_SPACES = 2;

    protected $_hSpace = '';
    public  $_maxLength = [];

    public $array = [];
    public $hLine = '';

    public function __construct($array){
        $this ->_hSpace = str_repeat('&nbsp;', self::N_SPACES);
        $this ->array = $array;
        $this -> maxLengthInColumn($array);
        $this ->createLine();
    }

    protected function maxLengthInColumn($array){
        foreach($array[0] as $k => $v){
            $this -> _maxLength[$k] = strlen($k);
        }

        foreach($array as $v){
            foreach($this -> _maxLength as $k2 => $v2){
                if(strlen($v[$k2]) > $v2){
                    $this -> _maxLength[$k2] = strlen($v[$k2]);
                }
            }
        }
    }

    protected function createLine(){
        foreach($this -> _maxLength as $k => $v){
            $this -> hLine .= self::S_PLUS;
            $this -> hLine .= str_repeat(self::S_MINUS, self::N_SPACES * 2 + $v);
        }
        $this -> hLine .= self::S_PLUS.'<br>';
    }

    protected function createHeader(){
        $header = $this ->hLine;
        foreach($this -> _maxLength as $k => $v){
            $odd = ($v - strlen($k)) % 2;
            $newHSpace = ($v - strlen($k) - $odd) / 2 + self::N_SPACES;
            $header .= self::S_VLINE . str_repeat('&nbsp;', $newHSpace) . $k . str_repeat('&nbsp;', $newHSpace + $odd);
        }
        return $header . self::S_VLINE.'<br>'.$this ->hLine;
    }

    protected function createBody(){
        $body = '';
        foreach($this->array as $v){
            foreach($this -> _maxLength as $k2 => $v2){
                $sSpan = '';
                $cSpan = '';
                if($k2 === 'Color'){
                    $sSpan = '<span style="background-color: '.$v[$k2].'; margin:-6px -3px -7.5px; padding: 6px 3px 7.5px; display:inline-block">';
                    $cSpan = '</span>';
                }
                $body .= self::S_VLINE .$sSpan. $this ->_hSpace . $v[$k2] . str_repeat('&nbsp;', $v2 - strlen($v[$k2]) + self::N_SPACES).$cSpan;
            }
            $body .= self::S_VLINE.'<br>'.$this ->hLine;
        }
        return $body;
    }

    public function drawAsciiTabel(){
        echo '<pre>' . $this ->createHeader() . $this ->createBody() . '</pre>';
    }
}


$arr = array (
    array (
        'Name' => 'Trixie',
        'Color' => 'Green',
        'Element' => 'Earth',
        'Likes' => 'Flowers'),
    array (
        'Name' => 'Tinkerbell',
        'Element' => 'Air',
        'Likes' => 'Singning',
        'Color' => 'Blue'),
    array (
        'Name' => 'Blum',
        'Element' => 'Water',
        'Likes' => 'Dancing',
        'Color' => 'Pink'),
);

$obj = new AsciiTabel($arr);
$obj ->drawAsciiTabel();