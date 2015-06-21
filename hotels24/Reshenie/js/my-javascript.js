(function($){
		
		function chageBackgroundColor(arrInd, baseColor, newColor){
		/*Функция меняет цвет фона при наведении курсора мыши*/
			for(var i in arrInd){
				$(arrInd[i]).on('mouseover', function(){
					$(this).css('background-color', newColor);
				});
						
				$(arrInd[i]).on('mouseleave', function(){						
					$(this).css('background-color', baseColor);
				});
			}
		}
		
		function showBlockH2(){
			/*Показывает врагмент текста H2*/
			$('div#h2').on('click', function(){
				var itemInfo = {};
				var url = 'block-h2.php';
				itemInfo.title = $(this).text();
				var jsonString = JSON.stringify(itemInfo);
				
				//console.log(jsonString);
				
				$.post(url, jsonString, function(data){
					//console.log(data);
					$('div#text').html(data);
				}, 'json');
			});
		}
		
		function showBlockH3(){
			/*Показывает врагмент текста H3*/
			$('div#h3').on('click', function(){
				var itemInfo = {};
				var url = 'block-h3.php';
				itemInfo.h2 = $(this).siblings('div#h2').text();
				itemInfo.title = $(this).text();
				var jsonString = JSON.stringify(itemInfo);
				
				//console.log(jsonString);
				
				$.post(url, jsonString, function(data){
					//console.log(data);
					$('div#text').html(data);
				}, 'json');
			});
		}
		
		chageBackgroundColor(['div#h2', 'div#h3'], 'inherit', '#FFCC99');
		
		showBlockH2();
		
		showBlockH3();
})(jQuery);