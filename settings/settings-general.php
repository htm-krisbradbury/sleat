<?php

/**
 * Sets up General Settings
 */
$page = new admin_settingpage('theme_sleat', new lang_string("general-settings", $component));

//Descriptor.
$name = "{$component}/logo_heading";                
$heading = new lang_string('logo_heading', $component);
$information = new lang_string('logo_info', $component);
$setting = new admin_setting_heading($name, $heading, $information);
$page->add($setting);

// Logo file setting.
$name = "{$component}/logo";
$title = new lang_string('logo', $component);
$description = new lang_string('logodesc', $component);
$setting = new admin_setting_configstoredfile($name, $title, $description, 'logo');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// Logo file setting.
$name = "{$component}/logo_alt";
$title = new lang_string('logo_alt', $component);
$description = new lang_string('logo_altdesc', $component);
$setting = new admin_setting_configtext($name, $title, $description, '');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// Strapline.
$name        = "{$component}/strapline";
$title       = new lang_string('strapline', $component);
$description = new lang_string('strapline_desc', $component);
$setting     = new admin_setting_configtext($name, $title, $description, '');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

//Descriptor.
$name = "{$component}/social_media_heading";                
$heading = new lang_string('social_media_heading', $component);
$information = new lang_string('social_media_info', $component);
$setting = new admin_setting_heading($name, $heading, $information);
$page->add($setting);

// Adds settings
$settings->add($page);