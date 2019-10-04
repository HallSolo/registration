<?php

require_once('../../../config.php');

function get_lang_string($identifier, $a, $lang) {

    $string = array();
    // First load english pack.
    if (file_exists("lang/$lang.php")) {
        include("lang/$lang.php");
    }

    if(isset($string[$identifier]))
        $string = $string[$identifier];
    else
        return '[['.$identifier.']]';

    if ($a !== null) {
        // Process array's and objects (except lang_strings).
        if (is_array($a) or (is_object($a) && !($a instanceof lang_string))) {
            $a = (array)$a;
            $search = array();
            $replace = array();
            foreach ($a as $key => $value) {
                if (is_int($key)) {
                    // We do not support numeric keys - sorry!
                    continue;
                }
                if (is_array($value) or (is_object($value) && !($value instanceof lang_string))) {
                    // We support just string or lang_string as value.
                    continue;
                }
                $search[]  = '{$a->'.$key.'}';
                $replace[] = (string)$value;
            }
            if ($search) {
                $string = str_replace($search, $replace, $string);
            }
        } else {
            $string = str_replace('{$a}', (string)$a, $string);
        }
    }

    return $string;
}


function email_user($user, $from, $subject, $message){
    global $CFG;

    require_once("$CFG->libdir/phpmailer/moodle_phpmailer.php");

    $noreplyaddressdefault = 'noreply@' . get_host_from_url($CFG->wwwroot);
    $noreplyaddress = empty($CFG->noreplyaddress) ? $noreplyaddressdefault : $CFG->noreplyaddress;

    $mail = get_mailer();
    $mail->From     = $noreplyaddress;
    $mail->FromName = fullname($from);
    //$mail->WordWrap = 80;
    $mail->Sender = $noreplyaddress;

    $mail->AddAddress($user->email, fullname($user));
    $mail->Body = $message;
    $mail->Subject = $subject;

    return $mail->send();

}

function send_email($user, $password){
    global $CFG;

    $lang = empty($user->lang) ? $CFG->lang : $user->lang;

    $site  = get_site();

    $supportuser = core_user::get_support_user();

    $a = new stdClass();
    $a->firstname   = fullname($user, true);
    $a->sitename    = format_string($site->fullname);
    $a->username    = $user->username;
    $a->newpassword = $password;
    $a->link        = $CFG->wwwroot .'/login/?lang='.$lang;
    $a->signoff     = $CFG->supportemail;

    $message = get_lang_string('newusernewpasswordtext', $a, $lang);

    $subject = format_string($site->fullname) .': '. get_lang_string('newusernewpasswordsubj', $a, $lang);

    // Directly email rather than using the messaging system to ensure its not routed to a popup or jabber.
    return email_user($user, $supportuser, $subject, $message);
}

$user = core_user::get_user_by_email('grayave@otrip.ru');
$password = '123qwer';
//$user->lang = 'en';

send_email($user, $password);