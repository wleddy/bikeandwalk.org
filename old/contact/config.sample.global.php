
<?php 
/*
    The file struture should look like this:
    /Users/<user name>/Sites
            /mywebsite.com/
                index.php
                contact/
                    config.php <-- the local settings and path to globals
                    index.php
                ...
            /lib
                config.php <-- smtp server settings for all sites for this user
                phpMailer/ <-- email library
                
*/

// Configuration settings for All Sites 
//$site['config_library'] = '/Users/bleddy/Sites/lib'; // location of config.php for all sites
//$site['config_global_settings'] = $site['config_root'].'/config.php'; // Global config file

//echo "root config";

// set the default time zone
date_default_timezone_set('America/Los_Angeles');

// Email Settings 
$site['from_name'] = 'your name'; // from email name 
$site['from_email'] = 'you@email.net'; // from email address 

$site['smtp_mode'] = 'enabled'; // enabled or disabled 
$site['smtp_host'] = 'smtpout.secureserver.net'; 
$site['smtp_port'] = '80'; 
$site['smtp_username'] = 'you@email.net';
$site['smtp_password'] = 'yourpassword';

?> 
