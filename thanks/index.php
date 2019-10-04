<?php 

header('Content-type: text/html; charset=utf-8');

require_once('../../../config.php');

require_once('lib.php');
/*
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/


function clean($value = "") {
    $value = trim($value);
    $value = stripslashes($value);
    $value = strip_tags($value);
    $value = htmlspecialchars($value);
    return $value;
}



$country_list = array("AU"=>"Австралия", "AT"=>"Австрия", "AZ"=>"Азербайджан", "AX"=>"Аландские острова", "AL"=>"Албания", "DZ"=>"Алжир", "AS"=>"Американское Самоа", "AI"=>"Ангилья", "AO"=>"Ангола", "AD"=>"Андорра", "AQ"=>"Антарктида", "AG"=>"Антигуа и Барбуда", "AR"=>"Аргентина", "AM"=>"Армения", "AW"=>"Аруба", "AF"=>"Афганистан", "BS"=>"Багамы", "BD"=>"Бангладеш", "BB"=>"Барбадос", "BH"=>"Бахрейн", "BY"=>"Беларусь", "BZ"=>"Белиз", "BE"=>"Бельгия", "BJ"=>"Бенин", "BM"=>"Бермуды", "BG"=>"Болгария", "BO"=>"Боливия", "BQ"=>"Бонайре, Синт-Эстатиус и Саба", "BA"=>"Босния и Герцоговина", "BW"=>"Боствана", "BR"=>"Бразилия", "IO"=>"Британская территория в Индийском океане", "BN"=>"Бруней-Даруссалам", "BF"=>"Буркина-Фасо", "BI"=>"Бурунди", "BT"=>"Бутан", "VU"=>"Вануату", "VA"=>"Ватикан (Папский Престол)", "GB"=>"Великобритания", "HU"=>"Венгрия", "VE"=>"Венесуэла", "VG"=>"Виргинские острова, Британские", "VI"=>"Виргинские острова, США", "TL"=>"Восточный Тимор", "VN"=>"Вьетнам", "GA"=>"Габон", "HT"=>"Гаити", "GY"=>"Гайана", "GM"=>"Гамбия", "GH"=>"Гана", "GP"=>"Гваделупа", "GT"=>"Гватемала", "GN"=>"Гвинея", "GW"=>"Гвинея-Биссау", "DE"=>"Германия", "GG"=>"Гернси", "GI"=>"Гибралтар", "HN"=>"Гондурас", "HK"=>"Гонконг", "GD"=>"Гренада", "GL"=>"Гренландия", "GR"=>"Греция", "GE"=>"Грузия", "GU"=>"Гуам", "DK"=>"Дания", "JE"=>"Джерси", "DJ"=>"Джибути", "DM"=>"Доминика", "DO"=>"Доминиканская республика", "EG"=>"Египет", "ZM"=>"Замбия", "EH"=>"Западная Сахара", "ZW"=>"Зимбабве", "IL"=>"Израиль", "IN"=>"Индия", "ID"=>"Индонезия", "JO"=>"Иордания", "IQ"=>"Ирак", "IR"=>"Иран, исламская республика", "IE"=>"Ирландия", "IS"=>"Исландия", "ES"=>"Испания", "IT"=>"Италия", "YE"=>"Йемен", "CV"=>"Кабо-Верде", "KZ"=>"Казахстан", "KY"=>"Каймановы острова", "KH"=>"Камбоджа", "CM"=>"Камерун", "CA"=>"Канада", "QA"=>"Катар", "KE"=>"Кения", "CY"=>"Кипр", "KG"=>"Киргизстан", "KI"=>"Кирибати", "CN"=>"Китай", "CC"=>"Кокосовые (Килинг) острова", "CO"=>"Колумбия", "KM"=>"Коморы", "CG"=>"Конго", "CD"=>"Конго, Демократическая республика", "KP"=>"Корея, народно-демократическая республика", "KR"=>"Корея, республика", "CR"=>"Коста-Рика", "CI"=>"Кот д'Ивуар", "CU"=>"Куба", "KW"=>"Кувейт", "CW"=>"Кюрасао", "LA"=>"Лаосская Народно-Демократическая Республика", "LV"=>"Латвия", "LS"=>"Лесото", "LR"=>"Либерия", "LB"=>"Ливан", "LY"=>"Ливия", "LT"=>"Литва", "LI"=>"Лихтенштейн", "LU"=>"Люксембург", "MU"=>"Маврикий", "MR"=>"Мавритания", "MG"=>"Мадагаскар", "YT"=>"Майотта", "MO"=>"Макао", "MK"=>"Македония, бывшая Югославская Республика", "MW"=>"Малави", "MY"=>"Малайзия", "ML"=>"Мали", "UM"=>"Малые Удаленные Острова Соединенных Штатов", "MV"=>"Мальдивы", "MT"=>"Мальта", "MA"=>"Марокко", "MQ"=>"Мартиника", "MH"=>"Маршалловы Острова", "MX"=>"Мексика", "FM"=>"Микронезия, федеративные штаты", "MZ"=>"Мозамбик", "MD"=>"Молдова, республика", "MC"=>"Монако", "MN"=>"Монголия", "MS"=>"Монтсеррат", "MM"=>"Мьянма", "NA"=>"Намибия", "NR"=>"Науру", "NP"=>"Непал", "NE"=>"Нигер", "NG"=>"Нигерия", "NL"=>"Нидерланды", "NI"=>"Никарагуа", "NU"=>"Ниуэ", "NZ"=>"Новая Зеландия", "NC"=>"Новая Каледония", "NO"=>"Норвегия", "AE"=>"Объединенные Арабские Эмираты", "OM"=>"Оман", "BV"=>"Остров Буве", "IM"=>"Остров Мэн", "NF"=>"Остров Норфолк", "CX"=>"Остров Рождества", "SH"=>"Остров Святой Елены, Вознесения и Тристан-да-Кунья", "HM"=>"Остров Херд и острова Макдональд", "CK"=>"Острова Кука", "TC"=>"Острова Теркс и Кайкос", "PK"=>"Пакистан", "PW"=>"Палау", "PS"=>"Палестина", "PA"=>"Панама", "PG"=>"Папуа — Новая Гвинея", "PY"=>"Парагвай", "PE"=>"Перу", "PN"=>"Питкерн", "PL"=>"Польша", "PT"=>"Португалия", "PR"=>"Пуэрто-Рико", "RE"=>"Реюньон", "RU"=>"Россия", "RW"=>"Руанда", "RO"=>"Румыния", "SV"=>"Сальвадор", "WS"=>"Самоа", "SM"=>"Сан-Марино", "ST"=>"Сан-Томе и Принсипи", "SA"=>"Саудовская Аравия", "SZ"=>"Свазиленд", "MP"=>"Северные Марианские острова", "SC"=>"Сейшелы", "BL"=>"Сен-Бартельми", "KN"=>"Сен-Китс и Невис", "SN"=>"Сенегал", "VC"=>"Сент-Винсент и Гренадины", "LC"=>"Сент-Люсия", "MF"=>"Сент-Мартин", "PM"=>"Сент-Пьер и Микелон", "RS"=>"Сербия", "SG"=>"Сингапур", "SX"=>"Синт-Маартен (Голландская часть)", "SY"=>"Сирийская Арабская Республика", "SK"=>"Словакия", "SI"=>"Словения", "US"=>"Соединенные Штаты Америки", "SB"=>"Соломоновы Острова", "SO"=>"Сомали", "SD"=>"Судан", "SR"=>"Суринам", "SL"=>"Сьерра-Леоне", "TJ"=>"Таджикистан", "TH"=>"Таиланд", "TW"=>"Тайвань (Китай)", "TZ"=>"Танзания, объединенная республика", "TG"=>"Того", "TK"=>"Токелау", "TO"=>"Тонга", "TT"=>"Тринидад и Тобаго", "TV"=>"Тувалу", "TN"=>"Тунис", "TM"=>"Туркмения", "TR"=>"Турция", "UG"=>"Уганда", "UZ"=>"Узбекистан", "UA"=>"Украина", "WF"=>"Уоллис и Футуна", "UY"=>"Уругвай", "FO"=>"Фарерские острова", "FJ"=>"Фиджи", "PH"=>"Филиппины", "FI"=>"Финляндия", "FK"=>"Фолклендские острова (Мальвинские)", "FR"=>"Франция", "GF"=>"Французская Гвиана", "PF"=>"Французская Полинезия", "TF"=>"Французские Южные территории", "HR"=>"Хорватия", "CF"=>"Центрально-Африканская Республика", "TD"=>"Чад", "ME"=>"Черногория", "CZ"=>"Чехия", "CL"=>"Чили", "SE"=>"Швеция", "SJ"=>"Шпицберген и Ян Майен", "LK"=>"Шри-Ланка", "CH"=>"Щвейцария", "EC"=>"Эквадор", "GQ"=>"Экваториальная Гвинея", "ER"=>"Эритрея", "EE"=>"Эстония", "ET"=>"Эфиопия", "ZA"=>"Южная Африка", "GS"=>"Южная Джорджия и Сандвичевы Острова", "SS"=>"Южный Судан", "JM"=>"Ямайка", "JP"=>"Япония");
$username_prefix = "ross-";




//	$config_file = 'local_config.php';
	$path = './';
/*
	$config_file = 'config.php';
	$path = '/srv/www/server1dev01/edu.fa.ru/';
*/


if($_POST){
	
	$user_post_data = array();
	foreach($_POST as $k=>$p){
		$p = clean($p);
		switch($k):
			case "country":
				$user_post_data['country'] = $p;
				$user_post_data['country_name'] = $country_list[$p];
				break;
			case "middlename":
				if(!empty($p)) $user_post_data['firstname'] .= " ".$p;
				break;
			default:
				$user_post_data[$k] = $p;
		endswitch;
	}

	
//	require( dirname( __FILE__ ) . '/../'.$config_file );

	$user_data = array();
	
	
	if(file_exists($path.'grant_6m_emails.txt'))
		$email_file = file($path.'grant_6m_emails.txt',FILE_IGNORE_NEW_LINES);

    $answer = add_user();

    switch ($answer) {
        case USER_ADD_ERORR:
        case EMAIL_SEND_ERORR:
        case EMAIL_DUBLICATE:

            if($user_post_data['lang'] != 'ru'){
                $msg['h1'] = 'Registration error!';
                $msg['p'] = '<span style="color: #777; font-size: 0.9em;">К сожалению мы не смогли завершить регистрацию так как пользователь с таким электронным адресом уже существует.</span><br><br><strong>Пожалуйста заполните форму регистрации еще раз.</strong>';
            }else{
                $msg['h1'] = 'Ошибка регистрации!';
                $msg['p'] = '<span style="color: #777; font-size: 0.9em;">К сожалению мы не смогли завершить регистрацию так как пользователь с таким электронным адресом уже существует.</span><br><br><strong>Пожалуйста заполните форму регистрации еще раз.</strong>';
            }
            $msg['timer'] = 8;
            break;

        default:

            if(file_exists($path.'grant_6m_count.txt'))
                $username_count = file_get_contents($path.'grant_6m_count.txt');

            save_file_to_disk($path, "grant_6m_count.txt", $username_count+1, 'w+');

            $user_data['username'] = $username_prefix.$username_count;
            $user_data['password'] = random_password(6,'alpha_numeric_underscore');
            $user_data['firstname'] = $user_post_data['firstname'];
            $user_data['lastname'] = $user_post_data['lastname'];
            $user_data['email'] = $user_post_data['email'];
            $user_data['phone'] = $user_post_data['phone'];
            $user_data['city'] = $user_post_data['city'];
            $user_data['country'] = $user_post_data['country'];
            $user_data['lang'] = $user_post_data['lang'];
            $user_data['institution'] = $user_post_data['school'];
            $user_data['profile_field_country_name'] = $user_post_data['country_name'];
            $user_data['profile_field_user_clever'] = $user_post_data['status'];
            $user_data['profile_field_register_date'] = date('Y-m-d H:i');
            $user_data['profile_field_register_date_u'] = date('U');

            $data_to_save = implode(";",$user_data)."\n";

            save_file_to_disk($path, "grant_6m_reg_".$user_post_data['lang'].".txt", $data_to_save);
            save_file_to_disk($path, "grant_6m_emails.txt", $user_post_data['email']."\n");
// username;password;firstname;lastname;email;phone1;city;country;lang;institution;profile_field_country_name;profile_field_user_clever;profile_field_register_date;profile_field_register_date_u

            if($user_post_data['lang'] != 'ru'){
                $msg['h1'] = 'Thank you for registering!';
                $msg['p'] = '<span style="color: #777; font-size: 0.9em;">Благодарим за интерес к образовательной программе Финансового университета при Правительстве Российской Федерации при грантовой поддержке Федерального агентства по делам содружества независимых государств («Россотрудничество»)</span><br><br><strong>В ближайшее время заявка будет обработана нашим специалистом и Вы получите доступ к учебным курсам.</strong>';
            }else{
                $msg['h1'] = 'Ваша заявка принята!';
                $msg['p'] = '<span style="color: #777; font-size: 0.9em;">Благодарим за интерес к образовательной программе Финансового университета при Правительстве Российской Федерации при грантовой поддержке Федерального агентства по делам содружества независимых государств («Россотрудничество»)</span><br><br><strong>В ближайшее время заявка будет обработана нашим специалистом и Вы получите доступ к учебным курсам.</strong>';
            }
            $msg['timer'] = 15;

    }


	if($user_post_data['lang'] != 'ru'){
		$msg['location'] = "en/";
		$msg['title'] = "Thank you for registering!";
		$msg['img_rs'] = "Federal Agency for the Commonwealth of Independent States Affairs (ROSSOTRUDNICHESTVO)";
		$msg['img_fu'] = "Financial University under the Government of the Russian Federation";
		$msg['footer'] = "FINANCIAL UNIVERSITY © ® 1998-". date('Y')."<br>125993, Moscow, Leningradsky Prospekt, 49";
	}else{
		$msg['location'] = "";
		$msg['title'] = "Спасибо за регистрацию!";
		$msg['img_rs'] = "Федеральное агентство по делам содружества независимых государств («Россотрудничество»)";
		$msg['img_fu'] = "Финансовый университет при Правительстве Российской Федерации";
		$msg['footer'] = "ФИНАНСОВЫЙ УНИВЕРСИТЕТ © ® 1998-". date('Y')."<br>125993, Москва, Ленинградский проспект, 49";
	}
	
	
}else{
	header('Location: ../');
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
	<link rel="shortcut icon" href="../assets/images/logo-fu-rus-light-307x128.png" type="image/x-icon">
	<meta name="description" content="">
	<meta http-equiv="Refresh" content="<?php echo $msg['timer']; ?>; URL=../<?php echo $msg['location']; ?>">
	<title><?php echo $msg['title']; ?></title>
	<link rel="shortcut icon" type="image/x-icon" href="../assets/favicon.ico">
	<link rel="preload" as="style" href="../assets/web/assets/fa-icons/fa-icons.css">
	<link rel="stylesheet" href="../assets/web/assets/fa-icons/fa-icons.css">
	<link rel="preload" as="style" href="https://fonts.googleapis.com/css?family=Libre+Franklin:400,400i,600,600i">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Libre+Franklin:400,400i,600,600i">
	<link rel="preload" as="style" href="../assets/tether/tether.min.css">
	<link rel="stylesheet" href="../assets/tether/tether.min.css">
	<link rel="preload" as="style" href="../assets/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="../assets/dropdown/css/style.css">
	<link rel="stylesheet" href="../assets/theme/css/style.css">
	<link rel="preload" as="style" href="../assets/icons-mind/style.css">
	<link rel="stylesheet" href="../assets/icons-mind/style.css">
	<link rel="preload" as="style" href="../assets/fa/css/mbr-additional.css"><link rel="stylesheet" href="../assets/fa/css/mbr-additional.css" type="text/css">
</head>
<body>


<section class="mbr-section mbr-section-hero mbr-section-full header4 mbr-section-with-arrow mbr-parallax-background mbr-after-navbar" id="header4-a" data-rv-view="0"  style="background: linear-gradient(to right top, rgb(0, 91, 102), rgb(74, 74, 74)) rgb(0, 91, 102);">
    <div class="mbr-table-cell">
        <div class="container">
            <div class="row heading">
                <div class="col-md-10 text-xs-center col-md-offset-1">
                    <h1 class="mbr-section-title display-1 heading-title"><?php echo $msg['h1']; ?></h1>
                    <p class="mbr-section-subtitle sub-2 heading-text"><?php echo $msg['p']; ?></p>
                    <div class="mbr-section-btn"><a class="btn btn-lg btn-empty" href="../<?php echo $msg['location']; ?>"><span class="imind-home mbr-iconfont mbr-iconfont-btn"></span></a>  </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="col-xs-12 col-lg-10 col-lg-offset-1">
            </div>
        </div>
    </div>
</section>


<div id="features13-15" custom-code="true" data-rv-view="3"><section class="mbr-section mbr-section-hero features13 mbr-after-navbar" data-rv-view="48" style="background-color: rgb(255, 255, 255); padding-top: 40px; padding-bottom: 40px;">

        <div class="container">
            <div class="col-xs-12">
                <div class="row">
                    <div class="mbr-cards-col col-xs-12 col-lg-6">
                        <div class="card" style="text-align: center;">
                            <div class="card-img col-xs-12 col-lg-12 align-bottom" style="text-align: center;"><img alt="RS" src="../assets/images/-900x900.png" class="img-rs align-bottom"></div>
                            <div class="card-box col-xs-12 col-lg-12">
                                <h4 class="hidden-md-down card-title mbr-section-subtitle sub-2 mbr-editable-content"><span style="font-weight: normal;"><?php echo $msg['img_rs']; ?></span></h4>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>

                    <div class="mbr-cards-col col-xs-12 col-lg-6">
                        <div class="card" style="text-align: center;">
                            <div class="card-img col-xs-12 col-lg-12 align-bottom" style="text-align: center; vertical-align: bottom;"><span class="align-bottom"><img alt="FA" src="../assets/images/100-1400x518.png" class="img-fa align-bottom"></span></div>
                            <div class="card-box col-xs-12 col-lg-12">
                                <h4 class="hidden-md-down card-title mbr-section-subtitle sub-2 mbr-editable-content"><span style="font-weight: normal;"><?php echo $msg['img_fu']; ?></span></h4>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

</section></div>

<div id="footer4-5" custom-code="true" data-rv-view="28"><footer class="mbr-small-footer mbr-section mbr-section-nopadding footer4" data-rv-view="4" style="background-color: rgb(0, 91, 102); padding-top: 1.75rem; padding-bottom: 0rem;">
    
    <div class="container">
        <p class="text-xs-left mbr-editable-content"><?php echo $msg['footer']; ?></p>
    </div>
</footer></div>


  <script src="../assets/web/assets/jquery/jquery.min.js"></script>
  <script src="../assets/tether/tether.min.js"></script>
  <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
  <script async src="../assets/smooth-scroll/smooth-scroll.js"></script>
  <script async src="../assets/theme/js/script.js"></script>
  
  
</body>
</html>