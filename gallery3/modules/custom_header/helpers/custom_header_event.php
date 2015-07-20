<?php defined("SYSPATH") or die("No direct script access.");

class custom_header_event_Core {
	static function admin_menu($menu, $theme) {
		$menu->get("settings_menu")
			->append(Menu::factory("link")
			->id("custom_header_menu")
			->label(t("Custom Headers"))
			->url(url::site("admin/custom_header")));
	}
}
