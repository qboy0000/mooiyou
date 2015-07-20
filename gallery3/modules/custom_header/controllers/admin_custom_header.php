<?php defined("SYSPATH") or die("No direct script access.");

class Admin_Custom_Header_Controller extends Admin_Controller {
	public function index() {
		print $this->_get_view();
	}

	public function handler() {
		access::verify_csrf();

		$form = $this->_get_form();

		if ($form->validate()) {
			module::set_var(
				"custom_header", "code", $form->custom_header->custom_header_code->value);
			message::success(t("Your settings have been saved."));
			url::redirect("admin/custom_header");
		}

		print $this->_get_view($form);
	}

	private function _get_view($form=null) {
		$v = new Admin_View("admin.html");
		$v->page_title = t("Gallery 3 :: Manage custom header");
		$v->content = new View("admin_custom_header.html");
		$v->content->form = empty($form) ? $this->_get_form() : $form;
		return $v;
	}

	private function _get_form() {
		$form = new Forge("admin/custom_header/handler", "", "post", array("id" => "g-admin-form"));
		$group = $form->group("custom_header")->label(t("Custom header"));
		$group->textarea("custom_header_code")
			->label(t('Enter custom header tags on the form [meta name:"name" content:"content"/] to render &lt;meta name="name" content="content"/&gt.
				Pure HTML cannot be used due to internal filtering.'))
			->value(module::get_var("custom_header", "code"));
		$form->submit("submit")->value(t("Save"));

		return $form;
	}
}
