<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/


/*
 * Google API Key
 */
define("GOOGLE_API_KEY", "AIzaSyDCplWQyMtfeLPAjJDQqa8X356LKjQKWFs"); // Place your Google API Key



define('PRODUCTION_MODE',1);
define('DEVELOPMENT_MODE',2);
define('PROJECT_MODE',DEVELOPMENT_MODE);

define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

define('PRODUCT_NAME','SAFE-TAXI V 2.0');

define('API_KEY','AIzaSyBy-tN2uOTP10IsJtJn8v5WvKh5uMYigq8');

define('SYSTEM_ADMINISTRATOR',1);
define('FRONT_DESK',2);

define('SYSTEM_EMAIL','safetaxi@safetaxi.com');
define('SYSTEM_ADDRESS','Safe Taxi,Kaloor,Ernakulam,Kerala');
define('SYSTEM_PHONE_NUMBER','999999999');

define('INVOICE', 1);
define('PAYMENT', 2);
define('RECEIPT', 3);

define('PERMISSION_FOR_ALL',1);
define('PERMISSION_FOR_TRIP_BOOKING',2);
define('PERMISSION_FOR_VIEW_TRIPS',3);

define('USER_STATUS_ACTIVE',1);
define('USER_STATUS_SUSPENDED',2);
define('USER_STATUS_DISABLED',3);

define('STATUS_ACTIVE',1);
define('STATUS_INACTIVE',2);


define('CUSTOMER_REG_TYPE_PHONE_CALL',1);
define('CUSTOMER_REG_TYPE_APP',2);

define('TRIP_STATUS_PENDING',1);
define('TRIP_STATUS_ACCEPTED',2);
define('TRIP_STATUS_TRIP_COMPLETED',3);
define('TRIP_STATUS_CANCELLED',4);
define('TRIP_STATUS_DRIVER_CANCELLED',5);
define('TRIP_STATUS_CUSTOMER_CANCELLED',6);
define('TRIP_STATUS_INVOICE_GENERATED',7);


define('CUSTOMER_ACTIVE',1);
define('CUSTOMER_UNDER_PROCESSING',2);

define('INSTANT_TRIP', 1);
define('FUTURE_TRIP', 2);

define('DAY_TRIP', 1);
define('NIGHT_TRIP', 2);

define('DRIVER_STATUS_ACTIVE', 1);
define('DRIVER_STATUS_ENGAGED', 2);
define('DRIVER_STATUS_DISMISSED', 3);
define('DRIVER_STATUS_SUSPENDED', 4);

define('NOTIFICATION_TYPE_NEW_TRIP', 1);
define('NOTIFICATION_TYPE_TRIP_CANCELLED', 2);
define('NOTIFICATION_TYPE_TRIP_UPDATE', 3);
define('NOTIFICATION_TYPE_PAYMENT_MSGS', 4);
define('NOTIFICATION_TYPE_COMMON_MSGS', '5');
define('NOTIFICATION_TYPE_TRIP_RECCURENT', '6');
define('NOTIFICATION_TYPE_TRIP_AWARDED', '7');
define('NOTIFICATION_TYPE_TRIP_REGRET', '8');

define('NOTIFICATION_STATUS_NOTIFIED', 1);
define('NOTIFICATION_STATUS_RESPONDED', 2);
define('NOTIFICATION_STATUS_EXPIRED', 3);

define('NOTIFICATION_VIEWED_STATUS', 1);
define('NOTIFICATION_NOT_VIEWED_STATUS',2);


define('gINVALID',-1);
define('VAT','12.36');
define('COMMISION_PERCENTAGE','10');


define('TD_LOG_LOCATION','0');
define('TD_LOG_LOCATION_AND_TRIP_DETAILS','1');
define('TD_NO_NEW_TRIP', '2');
define('TD_NEW_INSTANT_TRIP', '3');
define('TD_NEW_FUTURE_TRIP', '5');
define('TD_CANCEL_TRIP', '7');
define('TD_UPDATE_TRIP', '11');
define('TD_COMMON_MSGS', '13');
define('TD_PAYMENT_MSGS', '17');
define('TD_RECCURENT_TRIPS', '19');
define('TD_TRIP_ACCEPTED', '23');




/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');


/* End of file constants.php */
/* Location: ./application/config/constants.php */
