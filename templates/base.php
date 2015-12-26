<?php

# This file passes the content of the Readme.md file in the same directory
# through the Markdown filter. You can adapt this sample code in any way
# you like.

# Install PSR-0-compatible class autoloader
spl_autoload_register(function($class){
	require $_SERVER['DOCUMENT_ROOT']."/".preg_replace('{\\\\|_(?!.*\\\\)}', DIRECTORY_SEPARATOR, ltrim($class, '\\')).'.php';
});

# Get Markdown class
use \Michelf\Markdown;

## Get the page content -- adding elements here will add divs to html scaffold
$htmlContainers = array("head" => array('text' => '','filepath' => ''),
						"nav" => array('text' => '','filepath' => ''),
						"content" => array('text' => '<h1>No content for the '.$pageTitle.' page yet...</h1>','filepath' => ''),
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
}

?>

<!DOCTYPE html>
<html>
    <head>
        <title><?php echo($pageTitle);?></title>
		<link rel="icon" type="image/png" href="/images/favoricon.png" >
	    <link rel="SHORTCUT ICON" type="image/vnd.microsoft.icon" href="/images/favricon.ico" >
		<link rel="apple-touch-icon" sizes="114x114" href="/images/HeaderLogo128.png" />
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
		<script type="text/javascript" src="/js/common.js" ></script>
		<?php if (isset($extraJS)) {echo($extraJS);} ?>
		
		<link rel="stylesheet" href="/css/default.css" type="text/css" media="all" >

		<?php if (isset($extraCSS)) {echo($extraCSS);} ?>
		<?php if (isset($extraHeaders)) {echo($extraHeaders);} ?>
    </head>
    <body><div id="page-contain">
	
<?php
	foreach($htmlContainers as $baseName => $x_value){
		if(($htmlContainers[$baseName]['filepath'] != '') || ($htmlContainers[$baseName]['text'] != '')) {
			echo '<div id="'.$baseName.'">'."\r\n";
			if($htmlContainers[$baseName]['filepath'] != ''){
				require $htmlContainers[$baseName]['filepath'];
			}else{
				echo $htmlContainers[$baseName]['text'];
			}
			echo '</div>'."\r\n";
		} 
	}
?>
    </div></body>
</html>