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
    $value = htmlspecialchars($value,ENT_NOQUOTES);
    return $value;
}

if($_POST){
	
	$user_post_data = array();

	$user_post_data['lang'] = clean($_POST['lang']);

    $answer = add_user();

    switch ($answer) {
        case USER_ADD_ERORR:
        case EMAIL_SEND_ERORR:
        case EMAIL_DUBLICATE:

            if($user_post_data['lang'] != 'ru'){
                $msg['h1'] = 'Registration error!';
		$msg['p'] = '<span style="color: #777; font-size: 0.9em;">Unfortunately, we were unable to complete the registration because the user with this email address already exists.</span><br><br><strong>Please fill in the registration form again.</strong>';
            }else{
                $msg['h1'] = 'Ошибка регистрации!';
                $msg['p'] = '<span style="color: #777; font-size: 0.9em;">К сожалению мы не смогли завершить регистрацию так как пользователь с таким электронным адресом уже существует.</span><br><br><strong>Пожалуйста заполните форму регистрации еще раз.</strong>';
            }
            $msg['timer'] = 8;
            break;

        default:

// username;password;firstname;lastname;email;phone1;city;country;lang;institution;profile_field_country_name;profile_field_user_clever;profile_field_register_date;profile_field_register_date_u

            if($user_post_data['lang'] != 'ru'){
                $msg['h1'] = 'Thank you for registering!';
			$msg['p'] = '<span style="color: #777; font-size: 0.9em;">Thank you for your interest in the educational program of the Financial University under the Government of the Russian Federation with the grant support of the Federal Agency for the Commonwealth of Independent States ("Rossotrudnichestvo").</span><br><br><strong>In the near future, the application will be processed by our specialist and you will have access to the courses.</strong>';
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
  
<!-- Yandex.Metrika counter --> <script type="text/javascript" > (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)}; m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)}) (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym"); ym(55616593, "init", { clickmap:true, trackLinks:true, accurateTrackBounce:true, trackHash:true }); </script> <noscript><div><img src="https://mc.yandex.ru/watch/55616593" style="position:absolute; left:-9999px;" alt="" /></div></noscript> <!-- /Yandex.Metrika counter -->  
</body>
</html>