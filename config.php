
<?php 
// Configuration settings for My Site 
// get system wide settings one level up from me
require_once($_SERVER['DOCUMENT_ROOT'].'/../config.php');

//echo "site config";

// override or extend as needed
// Email Settings 
//$site['from_name'] = 'Rick Evey'; // from email name 
//$site['from_email'] = 'rick@valleyshipping.com'; // from email address 

// Try to get around rick's email filtering
$site['from_name'] = 'Bike and Walk'; // from email name 
$site['from_email'] = 'info@bikeandwalk.org'; // from email address 

?> 