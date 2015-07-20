<?php defined("SYSPATH") or die("No direct script access.");

$headers = module::get_var("custom_header", "code"); 

$encode = array("\[script", "\[", ':"', "\]");
$decode = array('<script', '<', '="', '>');

for ($i = 0; $i < sizeof($encode); $i++) {
	$headers = mb_ereg_replace($encode[$i], $decode[$i], $headers);
}

$headers = stripslashes($headers);

echo "$headers\r\n";

?>
