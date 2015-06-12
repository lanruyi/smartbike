<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Email
| -------------------------------------------------------------------------
| This file lets you define parameters for sending emails.
| Please see the user guide for info:
|
|	http://codeigniter.com/user_guide/libraries/email.html
|
*/
$config['mailtype'] = 'html';
$config['charset'] = 'utf-8';


$config['protocol'] = 'sendmail';
$config['mailpath'] = '/usr/sbin/sendmail';
$config['wordwrap'] = TRUE;

//$this->email->initialize($config);


//$config['protocol'] = 'smtp'; 
//$config['smtp_host'] = 'ssl://smtp.gmail.com';
//$config['smtp_user'] = 'airborne.cloud@gmail.com';
//$config['smtp_pass'] = 'cxjn18s!';
//$config['smtp_port'] = '465';
//$config['smtp_timeout'] = '8';
//$config['newline'] = "\r\n";
//$config['crlf'] = "\r\n";

/* End of file email.php */
/* Location: ./application/config/email.php */
