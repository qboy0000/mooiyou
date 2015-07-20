<?php defined("SYSPATH") or die("No direct script access.");

class custom_header_theme_Core {
	static function head($theme) {
	return new View("custom_header.html");
	}

}
