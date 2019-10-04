<?php

/**
 * Management functions
 *
 * @package    registration
 * @copyright  2019 GrayAve
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */



defined('MOODLE_INTERNAL') || die();

define('RU_COHORT', 20);
define('EN_COHORT', 21);

define('EMAIL_DUBLICATE', 1);
define('EMAIL_SEND_ERORR', 2);
define('USER_ADD_ERORR', 3);

define('USER_PREFIX', 'ross-');
define('USER_PATH_DIR', './');
define('USER_FILE_NAME', 'grant_6m_registration_');

require_once($CFG->dirroot.'/user/lib.php');
require_once($CFG->dirroot.'/cohort/lib.php');
//require_once($CFG->dirroot.'/lib/phpmailer/class.phpmailer.php');

function save_file_to_disk($path, $filename, $data){
    $file = $path."/".$filename;
    $f = fopen($file,'a+');
    fwrite($f, $data."\n");
    fclose($f);

    if(file_exists($file)) return true;
    else return false;

}


function random_password($length = 8, $type = 'alpha_numeric') {

    if ($length < 1 || $length > 1024) return null;

    $lower = 'abcdefghjkmnpqrstuvwxy';
    $upper = strtoupper($lower);
    $numbers = '123456789';
    $dash = '-';
    $underscore = '_';
    $symbols = '!@+=!@+=';

    switch ($type) {
        case 'lower':
            $chars = $lower;
            break;
        case 'upper':
            $chars = $upper;
            break;
        case 'numeric':
            $chars = $numbers;
            break;
        case 'alpha':
            $chars = $lower . $upper;
            break;
        case 'symbol':
            $chars = $symbols . $dash . $underscore;
            break;
        case 'alpha_numeric':
            $chars = $lower . $upper . $numbers;
            break;
        case 'alpha_numeric_dash':
            $chars = $lower . $upper . $numbers . $dash;
            break;
        case 'alpha_numeric_underscore':
            $chars = $lower . $upper . $numbers . $underscore;
            break;
        case 'alpha_numeric_dash_underscore':
            $chars = $lower . $upper . $numbers . $underscore . $dash;
            break;
        case 'all':
            $chars = $lower . $upper . $numbers . $underscore . $dash . $symbols;
            break;
        default:
            return null;
    }
            $min = 0;
            $max = strlen($chars) - 1;

            $password = '';

            for ($i = 0; $i < $length; $i++) {
                $random = mt_rand($min, $max);
                $char = substr($chars, $random, 1);
                $password .= $char;
            }

            return $password;
}


function create_user(){
    global $DB;

    $user = new stdClass();

    $user->lastname    = optional_param('lastname', '', PARAM_TEXT);
    $user->firstname   = optional_param('firstname', '', PARAM_TEXT);
    $middlename        = optional_param('middlename', '', PARAM_TEXT);
    $user->firstname  .= ( empty($middlename) ? '' : " " . $middlename );
    $user->email       = optional_param('email', '', PARAM_TEXT);
    $user->phone       = optional_param('phone', '', PARAM_TEXT);
    $user->city        = optional_param('city', '', PARAM_TEXT);
    $user->country     = optional_param('country', '', PARAM_TEXT);
    $user->lang        = optional_param('lang', '', PARAM_TEXT);
    $user->institution = optional_param('school', '', PARAM_TEXT);

    $user->password = random_password(8,'alpha_numeric_underscore');
    $user->raw_password = $user->password;
    $user->password = hash_internal_user_password($user->password, true);

    $record = $DB->count_records('user');
    $user->confirmed = 1;
    $user->mnethostid = 1;
    $user->username = USER_PREFIX . ($record + 1);

    return array($user, $user->raw_password);
}


function set_profile_info($user){
    global $CFG;

    require_once($CFG->dirroot . '/user/profile/lib.php');

    $country     = optional_param('country', '', PARAM_TEXT);
    if(!empty($country))
        $profilefield['country_name'] = get_string($country, 'core_countries');

    $profilefield['user_clever'] = optional_param('status', '', PARAM_TEXT);
    $profilefield['register_date'] = date('Y-m-d H:i');
    $profilefield['register_date_u'] = date('U');

    profile_save_custom_fields($user->id, $profilefield);

    return $profilefield;
}


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

    $lang = empty($user->lang) ? $CFG->lang : $user->lang;

    $mail = get_mailer();
    $mail->From     = $noreplyaddress;
    $mail->FromName = get_lang_string('supportfullname', null, $lang);
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
    $a->sitename    = $site->fullname;
    $a->username    = $user->username;
    $a->newpassword = $password;
    $a->link        = $CFG->wwwroot .'/login/?lang='.$lang;
    $a->signoff     = $CFG->supportemail;

    $message = get_lang_string('newusernewpasswordtext', $a, $lang);

    $subject = format_string(get_lang_string('sitefullname', null, $lang)) .': '. get_lang_string('newusernewpasswordsubj', $a, $lang);

    // Directly email rather than using the messaging system to ensure its not routed to a popup or jabber.
    return email_user($user, $supportuser, $subject, $message);
}

function save_user($data1, $data2){

    $data = array_merge($data1, $data2);

    unset($data['password']);
    $lang = $data['lang'];

    $data = implode(';', $data);

    save_file_to_disk( USER_PATH_DIR, USER_FILE_NAME.$lang.".txt", $data);
}


function add_to_cohort($user){
    global $CFG;

    if(empty($user->lang))
        $user->lang = $CFG->lang;

    switch ($user->lang) {
        case 'ru':
            $cohort = RU_COHORT;
            break;
        case 'en':
            $cohort = EN_COHORT;
            break;
        default:
            $cohort = RU_COHORT;
    }

    cohort_add_member($cohort, $user->id);
}


function add_user(){

    $email = optional_param('email', '', PARAM_TEXT);
    $user = core_user::get_user_by_email($email);

    if(!empty($user)) {
        return EMAIL_DUBLICATE;
    }

    list($user_raw, $password) = create_user();
    $user = clone $user_raw;
    $user->id = user_create_user($user_raw, false, false);

    if(!isset($user->id)) {
        return USER_ADD_ERORR;
    }

    $data = set_profile_info($user);

    save_user((array)$user_raw, (array)$data);

    add_to_cohort($user);

    send_email($user, $password);

}


