<?php
	$string = '<h2>Спорт</h2>
Разные материалы на спортивную тематику!!!
	<h3>Месси: Сделаем все, чтобы пройти Атлетико</h3>
		Нападающий "Барселоны" Лионель Месси пообещал сделать все возможное, чтобы обыграть мадридский "Атлетико" в рамках розыгрыша Кубка Испании и выйти в полуфинал турнира.

		Напомним, что в среду, 28 января, соперники встретятся на "Висенте Кальдерон" в ответном четвертьфинальном матче, после того как в первой части противостояния, благодаря голу Месси, каталонцы взяли верх со счетом 1:0.

		"Жду матча в Мадриде, - написал Месси на своей странице в соцсетях. - Мы сделаем все возможное, чтобы выйти в полуфинал".
	<h3>Луис Энрике: мы специалисты по игре на полях, по которым мяч скачет как кролик</h3>
		Главный тренер "Барселоны" Луис Энрике прокомментировал победу своей команды на "Висенте Кальедрон" в ответном четвертьфинальном матче Кубка Испании над столичным "Атлетико" (3:2).

		"Сегодня нам пришлось преодолевать трудности, но при этом мы показали довольно хороший футбол, на газоне, который был просто ужасным, приводят слова Луиса Энрике испанские СМИ. - Мне порой кажется, что мы уже стали специалистами по игре на полях, по которым мяч скачет как
	<h3>В финале Кубка английской лиги Челси сыграет с Тоттенхэмом</h3>
		Лондонский "Тоттенхэм" в гостях сыграл вничью с "Шеффилдом" во втором полуфинальном матче Кубка английской лиги со счетом 2:2.

		В первой встрече "шпоры" победили (1:0) и по сумме двух матчей вышли в решающую стадию турнира.

		В финальном матче, который пройдет 1 марта, "Тоттенхэм" сыграет с "Челси".
	
<h2>Компьютерная техника</h2>
	<h3>Цифровой фотоаппарат Canon EOS 600D kit</h3>
		Простая и подробная инструкция, в меню все просто , с помощью инструкции можно залезть куда угодно и так же легко все настроить под себя. Корпус крепкий и приятный на ощупь, в руках сидит хорошо. Если фотографировать на автоматическом режиме будут выходить отличные фото, но только днем. если вы будите вечером на автомате клацать ничего путнего не выйдет, не хватает мозгов у аппарата. Если вы профи у можете настроить все сами под определенные условия где фоткаете , фотографии будут выходить суперовые . У меня по началу ничего не получалось, думал даже плюнуть купить беззеркалку и забыть, но терпение и труд дали результаты . Удобный поворотный экран , поцарапать невозможно его. Если много фотографировать то руки не устают, вес у него относительно других зеркалок хороший и руки не устают';
		
		
		function from_string_to_array($string){
		
			$firstArr = explode('<h2>', $string);
		
			$secondArr = [];
			$finalArr =[];
			foreach($firstArr as $k => $v){
				if($k != 0){
					$arr = explode('</h2>', $v);
					$secondArr[$arr[0]] = explode('<h3>', $arr[1]);
					
					foreach($secondArr[$arr[0]] as $k2 => $v2){
						if($k2 != 0){
							$arr2 = explode('</h3>', $v2);
							$finalArr[$arr[0]][$arr2[0]] = trim($arr2[1]);
						}
						elseif($k2 == 0 && trim($v2)){
							$finalArr[$arr[0]]['text'] = trim($v2);
						}
					}	
				}
			}
			
			return $finalArr;		
		}
		
		/*echo '<pre>';
		print_r(from_string_to_array($string));
		echo '</pre>';*/
?>