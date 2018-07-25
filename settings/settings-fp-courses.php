<?php

/**
 * Sets up General Settings
 */
$page = new admin_settingpage("{$component}_fp_courses", new lang_string('fp-courses-settings', $component));

//Descriptor.
$name = "{$component}/fp_courses_heading";                
$heading = new lang_string('fp_courses_heading', $component);
$information = new lang_string('fp_courses_info', $component);
$setting = new admin_setting_heading($name, $heading, $information);
$page->add($setting);

// Strapline.
$name        = "{$component}/fp_course_list_title";
$title       = new lang_string('fp_course_list_title', $component);
$description = new lang_string('fp_course_list_title_desc', $component);
$setting     = new admin_setting_configtextarea($name, $title, $description, '');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting); 
 
// Adds settings
$settings->add($page);