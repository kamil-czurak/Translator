$(document).ready(function(){

	/**Ustawienie domyślnych wartości dla tlumacza**/
	$('#input_lang').val('pl');
	$('#output_lang').val('en');


	/**Sprawdzenie kiedy uzytkowik skonczy pisac**/
	var typingTimer; 
	var doneTypingInterval = 1000;
	var $input = $('#input_text');

	$input.on('keyup', function () {
		clearTimeout(typingTimer);
		typingTimer = setTimeout(translate, doneTypingInterval);
	});

	$input.on('keydown', function () {
		clearTimeout(typingTimer);
	});

	/**Obsługa kliknięcia btn**/
	$('#btn').click(function(){
		validation();
	})

	/**Zamiana flag przy wyborze języka**/
	$('#input_lang').change(function(){
		$('.input_flag').html('<img src="img/flags/'+$(this).val()+'.svg">');
	})

	$('#output_lang').change(function(){
		$('.output_flag').html('<img src="img/flags/'+$(this).val()+'.svg">');
	})

	$('select').change(function(){
		translate();
	})

	/**Zmiana na sugerowany jezyk**/
	$('.detected_language').click(function(){
		var sh_ct = $(this).data('id');
		$('#input_lang').val(sh_ct);
		$('.input_flag').html('<img src="img/flags/'+sh_ct+'.svg">');
		$('.original_language').css({'display':'none'});
		translate();
	})

	/**Pobranie danych z formularza**/
	function getData()
	{
		var data = new Array();
		data.push($('#input_text').val());
		data.push($('#input_lang').val());
		data.push($('#output_lang').val());
		return data;
	}

	/**Walidacja danych z formularza**/
	function validation()
	{
		var data = getData();
		var l = data.length;
		for(var i=0;i<l;i++)
		{
			if(data[i]=='')
				return false;
		}
		return true;
	}

	/**Wysłanie żądania do translatora**/
	function translate()
	{
		if(validation())
		{
			$('#output_text').html('<img src="img/loader.gif">');
			var data = getData();
			$.ajax({
				url:'?op=translate',
				type:'POST',
				data:{data:data},
				success:function(msg)
				{
					var result = msg.split(';');
					$('#output_text').html(result[0]);
					if(result[1]!=data[1] && result[1]!='en')
					{
						$('.original_language').fadeIn();
						$('.detected_language').html(result[2]);
						$('.detected_language').data('id',result[1]);
					}
					else
						$('.original_language').css({'display':'none'});
				}
			})
		}
		else
			$('#output_text').html('');
		}
})