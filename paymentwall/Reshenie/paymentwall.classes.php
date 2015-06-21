<?php

	/*---*/
	
	interface ISeparateNumberIntoArray{
		function getAssocArray($num);
	}

	/*---*/
	
	class SeparateThousandsNumberIntoArray implements ISeparateNumberIntoArray{
		
		protected $_indexArray = array();
		protected $_assocArray = array();
		
		protected function separeNumberIntoIndexArray($num){
			$filter = 10;
			while($num >= ($filter / 10)){
				$this -> _indexArray[$filter / 10] = fmod($num , $filter) / ($filter / 10);
				$num = $num - fmod($num , $filter);
				$filter = $filter * 10;
			}
		}
		
		protected function assocNumberArr($num){
			$this -> separeNumberIntoIndexArray($num);
			foreach($this -> _indexArray as $key => $value){
				if($key < 1000){
					switch($key){
						case 1: 
							$this -> _assocArray['units']['units'] = $value;
							break;
						case 10: 
							$this -> _assocArray['units']['decades'] = $value;
							break;
						case 100: 
							$this -> _assocArray['units']['hundreds'] = $value;
							break;
					}
				}
				elseif($key < 1000000){
					switch($key / 1000){
						case 1: 
							$this -> _assocArray['thousands']['units'] = $value;
							break;
						case 10: 
							$this -> _assocArray['thousands']['decades'] = $value;
							break;
						case 100: 
							$this -> _assocArray['thousands']['hundreds'] = $value;
							break;
					}
				}
			}
		}
		
		public function getAssocArray($num){
			$this -> assocNumberArr($num);
			return $this -> _assocArray;
		}
	}
	
	/*---*/
	
	class SeparateMillionsNumberIntoArray extends SeparateThousandsNumberIntoArray{
		public function assocNumberArr($num){
			parent::assocNumberArr($num);
			foreach($this -> _indexArray as $key => $value){
				if($key < 1000000000){
					switch($key / 1000000){
						case 1: 
							$this -> _assocArray['millions']['units'] = $value;
							break;
						case 10: 
							$this -> _assocArray['millions']['decades'] = $value;
							break;
						case 100: 
							$this -> _assocArray['millions']['hundreds'] = $value;
							break;
					}
				}
			}
		}
	}
	
	/*---*/
	
	interface IWordNumberArray{
		function getWordArray();
	}
	
	/*---*/
	
	abstract class WordNumberArray implements IWordNumberArray{
		
		protected $_wordArray = array();
		
		protected function addWordArray($category, $zero, $one, $two, $three){
			foreach($this ->_wordArray['units'] as $key => $value){
				foreach($value as $k => $v){
					if($key == 'units'){
						if($k == 0 || $k > 4){
							$this ->_wordArray[$category][$key][] = $v.' '.$zero;
						}
						elseif($k == 1){
							$this ->_wordArray[$category][$key][] = $one;
						}
						elseif($k == 2){
							$this ->_wordArray[$category][$key][] = $two;
						}
						else{
							$this ->_wordArray[$category][$key][] = $v.' '.$three;
						}
					}
					else{
						$this ->_wordArray[$category][$key][] = $v;
					}
				}
			}
		}
	
		public function getWordArray(){
			return $this -> _wordArray;
		}
	
	}
	
	/*-Russian word-*/
	
	class WordNumberArrayRussianHundreds extends WordNumberArray {
	
		protected $_wordArray = array(
			'units' => array(
				'units' => array('', 'Один', 'Два', 'Три', 'Четыре', 'Пять', 'Шесть', 'Семь', 'Восемь', 'Девять'),
				'decades' => array('', 'Десять', 'Двадцать', 'Тридцать', 'Сорок', 'Пятьдесят', 'Шестьдесят', 'Шестьдесят', 'Восемьдесят', 'Девяносто'),
				'hundreds' => array('', 'Сто', 'Двести', 'Триста', 'Четыреста', 'Пятьсот', 'Шестьсот', 'Семьсот', 'Восемьсот', 'Девятьсот')
			),
			'teen' => array('', 'Одиннадцать', 'Двенадцать', 'Тринадцать', 'Четырнадцать', 'Пятнадцать', 'Шестнадцать', 'Семнадцать', 'Восемнадцать', 'Девятнадцать')
		);	
		
	}
	
	/*---*/
	
	class WordNumberArrayRussianThousands extends WordNumberArrayRussianHundreds {
		function __construct(){
			parent::addWordArray('thousands', 'Тысяч', 'Одна Тысяча', 'Две Тысячи', 'Тысячи');
		}
	}
	
	/*---*/
	
	class WordNumberArrayRussianMillions extends WordNumberArrayRussianThousands {
		function __construct(){
			parent::__construct();
			parent::addWordArray('millions', 'Миллионов', 'Один Миллион', 'Два Миллиона', 'Миллиона');
		}
	}
	
	/*-English word-*/
	
	class WordNumberArrayEnglishHundreds extends WordNumberArray {
	
		protected $_wordArray = array(
			'units' => array(
				'units' => array('', 'One', 'Two', 'three', 'four', 'five', 'six', 'Seven', 'eight', 'nine'),
				'decades' => array('', 'Ten', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety'),
				'hundreds' => array('', 'One Hundred', 'Two hundred', 'Three hundred', 'Four hundred', 'Five Hundred', 'Six hundred', 'Seven hundred', 'Eight hundred', 'Nine hundred')
			),
			'teen' => array('', 'Eleven', 'twelve', 'Thirteen', 'Fourteen', 'fifteen', 'Sixteen', 'Seventeen', 'eighteen', 'Nineteen')
		);	
		
	}
	
	/*---*/
	
	class WordNumberArrayEnglishMillions extends WordNumberArrayEnglishHundreds {
		function __construct(){
			parent::addWordArray('thousands', 'Thousands', 'One Thousand', 'Two Thousand', 'Thousands');
			parent::addWordArray('millions', 'Millions', 'One Million', 'two millions', 'Millions');
		}
	}
	
	/*-Ukrainian word-*/
	
	class WordNumberArrayUkrainianHundreds extends WordNumberArray {
	
		protected $_wordArray = array(
			'units' => array(
				'units' => array('', 'Один', 'Два', 'Три', 'Чотири', "П'ять", 'Шість', 'Сім', 'Вісім', "Дев'ять"),
				'decades' => array('', 'Десять', 'Двадцять', 'Тридцять', 'Сорок', "П'ятдесят", 'Шістдесят', 'Сімдесят', 'Вісімдесят', "Дев'яносто"),
				'hundreds' => array('', 'Сто', 'Двісті', 'Триста', 'Чотириста', "П'ятсот", 'Шістсот', 'Сімсот', 'Вісімсот', "Дев'ятсот")
			),
			'teen' => array('', 'Одинадцять', 'Дванадцять', 'Тринадцять', 'Чотирнадцять', "П'ятнадцять", 'Шістнадцять', 'Сімнадцять', 'Вісімнадцять', "Дев'ятнадцять")
		);	
		
	}
	
	/*---*/
	
	class WordNumberArrayUkrainianMillions extends WordNumberArrayUkrainianHundreds {
		function __construct(){
			parent::addWordArray('thousands', 'Тисяч', 'Одна Тисяча', 'Дві Тисячі', 'Тисячі');
			parent::addWordArray('millions', 'Мільйонів', 'Один Мільйон', 'Два Мільйона', 'Мільйона');
		}
	}
	
	/*-Create string-*/
	
	class CreateWordString{
		
		protected $_namberClass;
		protected $_wordClass;
		protected $_string;
		
		function __construct(ISeparateNumberIntoArray $namberClass,  IWordNumberArray $wordClass){
			$this -> _namberClass = $namberClass;
			$this -> _wordClass = $wordClass;
		}
		
		protected function createString($num){
			foreach($this -> _namberClass -> getAssocArray($num) as $naKey => $naValue){
				$units = 0;
				$subString = '';
				foreach($naValue as $naKeyV => $naValueV){
					if($naKeyV == 'units'){
						$units = $naValueV;
						$subString = $this -> _wordClass -> getWordArray()[$naKey][$naKeyV][$naValueV].' '.$subString;
					}
					elseif($naKeyV == 'decades' && $naValueV == 1 && $units != 0 ){
						$subString = $this -> _wordClass -> getWordArray()['teen'][$units].' '.$this -> _wordClass -> getWordArray()[$naKey]['units'][0];
					}
					else{
						$subString =  $this -> _wordClass -> getWordArray()[$naKey][$naKeyV][$naValueV].' '.$subString;
					}
				}
				$this ->_string = $subString.' '.$this ->_string;
			}
		}
		
		public function getString($num){
			$this -> createString($num);
			return $this -> _string;
		}
	}
	
	/*-Sample of work-*/
	
	$number = 123111910;
	
	echo '<br><br> UKR: ';
	$a = new  CreateWordString(new SeparateMillionsNumberIntoArray, new WordNumberArrayUkrainianMillions);
	echo $a -> getString($number);
	
	echo '<br><br> RUS: ';
	$a = new  CreateWordString(new SeparateMillionsNumberIntoArray, new WordNumberArrayRussianMillions);
	echo $a -> getString($number);
	
	echo '<br><br> ENG: ';
	$a = new  CreateWordString(new SeparateMillionsNumberIntoArray, new WordNumberArrayEnglishMillions);
	echo $a -> getString($number);
?>