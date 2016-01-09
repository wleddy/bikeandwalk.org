
<?php 
// Configuration settings for My Site 
// get system wide settings 
// Configuration settings for All Sites 
$site['config_library'] = '/Users/bleddy/Sites/lib'; // location of config.php for all sites & phpMailer
$site['config_global_settings'] = $site['config_library'].'/config.php';

// get system wide settings 
require_once($site['config_global_settings'])

// override or extend as needed
$site['from_name'] = 'Bike and Walk'; // from email name 
$site['from_email'] = 'info@bikeandwalk.org'; // from email address 

// Grab the FreakMailer class 
require_once($site['config_library'].'/MailClass.inc'); 

//echo "site config";


?> 