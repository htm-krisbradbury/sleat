<?php

$page = new admin_settingpage("{$component}_footer", new lang_string('footer-settings', $component));

//Descriptor.
$name = "{$component}/footer_heading";                
$heading = new lang_string('footer_heading', $component);
$information = new lang_string('footer_info', $component);
$setting = new admin_setting_heading($name, $heading, $information);
$page->add($setting);

// Footer bg colour.
$name        = "{$component}/footer_section_background_colour";
$title       = new lang_string('footer_section_background_colour', $component);
$description = new lang_string('footer_section_background_colour_desc', $component);
$setting     = new admin_setting_configcolourpicker($name, $title, $description, '');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// Toggle course tiles.
$name        = "{$component}/footer_sm_icons";
$title       = new lang_string('footer_sm_icons', $component);
$description = new lang_string('footer_sm_icons_desc', $component);
$default     = 0;
$setting     = new admin_setting_configcheckbox($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

//Descriptor.
$name = "{$component}/footer_elements_heading";                
$heading = new lang_string('footer_elements_heading', $component);
$information = new lang_string('footer_elements_info', $component);
$setting = new admin_setting_heading($name, $heading, $information);
$page->add($setting);

// Footer text.
$name = "{$component}/footer_text";
$title = new lang_string('footer_text', $component);
$description = new lang_string('footer_text_desc', $component);
$setting = new admin_setting_confightmleditor($name, $title, $description, '');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// footnote.
$name = "{$component}/footer_footnote";
$title = new lang_string('footnote', $component);
$description = new lang_string('footnote_desc', $component);
$setting = new admin_setting_confightmleditor($name, $title, $description, '');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// Footer text colour.
$name        = "{$component}/footer_section_text_colour";
$title       = new lang_string('footer_section_text_colour', $component);
$description = new lang_string('footer_section_text_colour_desc', $component);
$setting     = new admin_setting_configcolourpicker($name, $title, $description, '');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// Footer link colour.
$name        = "{$component}/footer_section_link_colour";
$title       = new lang_string('footer_section_link_colour', $component);
$description = new lang_string('footer_section_link_colour_desc', $component);
$setting     = new admin_setting_configcolourpicker($name, $title, $description, '');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// Footer text colour.
$name        = "{$component}/footer_section_link_hover_colour";
$title       = new lang_string('footer_section_link_hover_colour', $component);
$description = new lang_string('footer_section_link_hover_colour_desc', $component);
$setting     = new admin_setting_configcolourpicker($name, $title, $description, '');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$settings->add($page);
