<?php
$SiteName = "";
if ($SiteName == "") $SiteName = $_SERVER['SERVER_NAME'];

# Install PSR-0-compatible class autoloader
spl_autoload_register(function($class){
	require $_SERVER['DOCUMENT_ROOT']."/".preg_replace('{\\\\|_(?!.*\\\\)}', DIRECTORY_SEPARATOR, ltrim($class, '\\')).'.php';
});

# Get Markdown class
use \Michelf\Markdown;

/* 
    'content.xx' is the default name for the main page body but having all the pages named
    "content" is confusing during editing. 
    This change allows you to name the main content file after the enclosing directory name
*/
$serverURI = $_SERVER['REQUEST_URI'];
#ensure that there is a trailing '/' in $serverURI
if (substr($serverURI,strlen($serverURI)-1) != '/' ) {$serverURI = $serverURI . '/';}
$bits = explode("/", $serverURI);
$localDir = $bits[count($bits)-2];

if ($localDir=="") {$localDir = "arandomstring";} ## not sure how the file system will handle an empty file name

## Get the page content -- adding elements here will add divs to html scaffold
## Note that ONLY the $localDir element has the 'id' property
## If there is a file that matches the directory name, the 'content' file will not be used
$htmlContainers = array("head" => array('text' => '','filepath' => ''),
						"nav" => array('text' => '','filepath' => ''),
						$localDir => array('id' => 'content', 'text' => '','filepath' => ''),
						"content" => array('text' => '','filepath' => ''),
						"foot" => array('text' => '','filepath' => '')
						);

foreach($htmlContainers as $baseName => $x_value){
	#look first in local dir for .php, then .html, then .md
	#if not local, look in templates dir. 
	#Only ever use one file at most for each section
	 if (file_exists($baseName.'.php')) {
		$htmlContainers[$baseName]['filepath'] = $baseName.'.php';
	}elseif (file_exists($baseName.'.html')) {
			$htmlContainers[$baseName]['text'] = file_get_contents($baseName.'.html');
	}elseif (file_exists($baseName.'.md')) {
		# Read file and pass content through the Markdown parser
		$text = file_get_contents($baseName.'.md');
		$htmlContainers[$baseName]['text'] = Markdown::defaultTransform($text);
	}
		#check the default files
	elseif(file_exists($_SERVER['DOCUMENT_ROOT']."/templates/".$baseName.'.php')){
		$htmlContainers[$baseName]['filepath'] = $_SERVER['DOCUMENT_ROOT']."/templates/".$baseName.'.php';
	}elseif(file_exists($_SERVER['DOCUMENT_ROOT']."/templates/".$baseName.'.html')){
		$htmlContainers[$baseName]['text'] = file_get_contents($_SERVER['DOCUMENT_ROOT']."/templates/".$baseName.'.html');
	}elseif (file_exists($_SERVER['DOCUMENT_ROOT']."/templates/".$baseName.'.md')) {
		# Read file and pass content through the Markdown parser
		$text = file_get_contents($_SERVER['DOCUMENT_ROOT']."/templates/".$baseName.'.md');
		$htmlContainers[$baseName]['text'] = Markdown::defaultTransform($text);
	}
} #for htmlConainers

?>

<!DOCTYPE html>
<html>
    <head>
        <title><?php echo($pageTitle);?> - <?php echo($SiteName)?></title>
		<link rel="icon" type="image/png" href="/images/favoricon.png" >
	    <link rel="SHORTCUT ICON" type="image/vnd.microsoft.icon" href="/images/favricon.ico" >
		<?php echo($extraHeaders);?>

		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
		<script type="text/javascript" src="/js/common.js" ></script>
		<?php
		    $js = $serverURI.$localDir.'.js';
		    if(file_exists(substr($_SERVER['DOCUMENT_ROOT'],0,-1).$js)){
		    echo('<script type="text/javascript" src="'.$js.'" ></script>');
		    }
		?>
		<?php echo($extraJS);?>
		
		<link rel="stylesheet" href="/css/default.css" type="text/css" media="all" >
		<?php
		    $css = $serverURI.$localDir.'.css';
		    echo(substr($_SERVER['DOCUMENT_ROOT'],0,-1).$css);
		    if(file_exists(substr($_SERVER['DOCUMENT_ROOT'],0,-1).$css)){
		    echo('<link rel="stylesheet" href="'.$css.'" type="text/css" media="all" >');
		    }
		?>
		<?php echo($extraCSS);?>
		
    </head>
    <body>
    <div id="container" >
<?php
    $useLocalDir = false;
	foreach($htmlContainers as $baseName => $x_value){
		if(($htmlContainers[$baseName]['filepath'] != '') || ($htmlContainers[$baseName]['text'] != '')) {
		    $divID = $baseName;
		    ## only the $localFile element contains the 'id' element
		    if ($htmlContainers[$baseName]['id']) {
        	    $divID = $htmlContainers[$baseName]['id'];
        	    $useLocalDir = true;
        	}
        	if ($useLocalDir && ($baseName == 'content')) {
        	    ## if we used the local file, we don't use 'content'
        	    continue;
        	}

			echo '<div id="'.$divID.'">'."\r\n";
			if($htmlContainers[$baseName]['filepath'] != ''){
				require $htmlContainers[$baseName]['filepath'];
			}else{
				echo $htmlContainers[$baseName]['text'];
			}
			echo '</div>'."\r\n";
		} 
	}
?>
    </div>
    </body>
</html>