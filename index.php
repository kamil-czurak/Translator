<?php 
	require('vendor/autoload.php');

	use Yandex\Translate\Translator;
	use Yandex\Translate\Exception;
	$translator = new Translator();

	$lang_arr = $translator->getSupportedLanguages();
	asort($lang_arr);

	$lang_opt ='';
	foreach ($lang_arr as $key => $value) {
		$lang_opt.='<option value="'.$key.'">'.$value.'</option>';
	};

	if(isset($_GET['op']))
		$op = $_GET['op'];
	else
		$op='';

	switch ($op) {
		case 'translate':
			
			$text = $_POST['data'][0];
			$source_lang = $_POST['data'][1];
			$result_lang = $_POST['data'][2];

	  		$translation = $translator->translate($text, $source_lang.'-'.$result_lang);
	  		$language = $translator->detect($text);

	  		echo $translation.';'.$language.';'.$lang_arr[$language];
		break;
		
		default:
	

?>
<!doctype html>
<html>
	<head>
		<link rel='stylesheet' href='style.css'>
	</head>
	<body>

		<div id='container'>
			<h1>Translator</h1>
			<form method='POST' action='' id='translate' onsubmit='return false;'>
				<div class='input_container form_container'>
					<div class='language_bar'>
						<span class='country_flag input_flag'><img src='img/flags/pl.svg'></span>
						<select id='input_lang'><?php echo $lang_opt;?></select>
					</div>	
					<textarea id='input_text' placeholder="Insert text"></textarea>
					<div class='original_language'>
						Original language: <span class='detected_language'> English</span>
					</div>
				</div>
				<div class='output_container form_container'>	
					<div class='language_bar'>
						<span class='country_flag output_flag'><img src='img/flags/en.svg'></span>
						<select id='output_lang'><?php echo $lang_opt;?></select>
					</div>
					
					<div id='output_text'></div>
				</div>	
			</form>
			<button id='btn'><img src="img/shuffle.png"></button>
			<!-- Icon made by iconixar from www.flaticon.com -->
		</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src='script.js'></script>
	</body>	
</html>
<?php }?>
