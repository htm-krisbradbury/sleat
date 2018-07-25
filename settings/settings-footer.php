<?php

$page = new admin_settingpage("{$component}_footer", new lang_string('footer-settings', $component));

//Descriptor.
$name = "{$component}/footer_heading";                
$heading = new lang_string('footer_heading', $component);
$information = new lang_string('footer_info', $component);
$setting = new admin_setting_heading($name, $heading, $information);
$page->add($setting);



//Descriptor.
$name = "{$component}/footer_elements_heading";                
$heading = new lang_string('footer_elements_heading', $component);
$information = new lang_string('footer_elements_info', $component);
$setting = new admin_setting_heading($name, $heading, $information);
$page->add($setting);

// Footer text column 1
$name = "{$component}/footer_title_col_1";
$title = new lang_string('footer_title_col_1', $component);
$description = new lang_string('footer_title_col_1_desc', $component);
$setting = new admin_setting_configtextarea($name, $title, $description, '');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = "{$component}/footer_text_col_1";
$title = new lang_string('footer_text_col_1', $component);
$description = new lang_string('footer_text_col_1_desc', $component);
$setting = new admin_setting_confightmleditor($name, $title, $description, '');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// Footer text column 2
$name = "{$component}/footer_title_col_2";
$title = new lang_string('footer_title_col_2', $component);
$description = new lang_string('footer_title_col_2_desc', $component);
$setting = new admin_setting_configtextarea($name, $title, $description, '');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = "{$component}/footer_text_col_2";
$title = new lang_string('footer_text_col_2', $component);
$description = new lang_string('footer_text_col_2_desc', $component);
$setting = new admin_setting_confightmleditor($name, $title, $description, '');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// Footer text column 1
$name = "{$component}/footer_title_col_3";
$title = new lang_string('footer_title_col_3', $component);
$description = new lang_string('footer_title_col_3_desc', $component);
$setting = new admin_setting_configtextarea($name, $title, $description, '');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = "{$component}/footer_text_col_3";
$title = new lang_string('footer_text_col_3', $component);
$description = new lang_string('footer_text_col_3_desc', $component);
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

$settings->add($page);
