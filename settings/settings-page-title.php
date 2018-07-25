<?php

/**
 * Sets up General Settings
 */
$page = new admin_settingpage("{$component}_page_titles", new lang_string('page-title-settings', $component));

//Descriptor.
$name = "{$component}/page_title_heading";                
$heading = new lang_string('page_title_heading', $component);
$information = new lang_string('page_title_info', $component);
$setting = new admin_setting_heading($name, $heading, $information);
$page->add($setting);

// Logo file setting.
$name = "{$component}/page_title_background";
$title = new lang_string('page_title_background', $component);
$description = new lang_string('page_title_background_desc', $component);
$setting = new admin_setting_configstoredfile($name, $title, $description, 'page_title_background');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);


// Adds settings
$settings->add($page);