<?php defined("SYSPATH") or die("No direct script access.");

class custom_header_installer {
	static function deactivate() {
		module::clear_var("custom_header", "code");
	}
}
