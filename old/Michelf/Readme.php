<?php

# This file passes the content of the Readme.md file in the same directory
# through the Markdown filter. You can adapt this sample code in any way
# you like.

# Install PSR-0-compatible class autoloader
spl_autoload_register(function($class){
	require preg_replace('{\\\\|_(?!.*\\\\)}', DIRECTORY_SEPARATOR, ltrim($class, '\\')).'.php';
});

# Get Markdown class
use \Michelf\Markdown;

$baseName = 'Readme';

if (file_exists($baseName.'.html')) {
	$html = file_get_contents($baseName.'.html');
	
}elseif (file_exists($baseName.'.md')) {
	# Read file and pass content through the Markdown parser
	$text = file_get_contents($baseName.'.md');
	$html = Markdown::defaultTransform($text);
}elseif (file_exists('../test.html')){
	$html = file_get_contents('../test.html');
	
}else{
	$html='<h1>Hello World!</h1>';
}

?>
<!DOCTYPE html>
<html>
    <head>
        <title>PHP Markdown Lib - Readme</title>
    </head>
    <body>
		<?php
			# Put HTML content in the document
			echo $html;
		?>
    </body>
</html>
