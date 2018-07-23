<?php

/**
 * Sets up General Settings
 */
$page = new admin_settingpage("{$component}_styling", new lang_string('styling-settings', $component));

// Site width.
$name = "{$component}/sitewidth";
$title = new lang_string('sitewidth', $component);
$description = new lang_string('sitewidth_desc', $component);
$setting = new admin_setting_configtext($name, $title, $description, '');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// Variable $brand-primary.
// We use an empty default value because the default colour should come from the preset.
$name = "{$component}/brandprimary";
$title = new lang_string('brandprimary', $component);
$description = new lang_string('brandprimary_desc', $component);
$setting = new admin_setting_configcolourpicker($name, $title, $description, '');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// Variable $brand-textcolour.
// We use an empty default value because the default colour should come from the preset.
$name = "{$component}/textcolour";
$title = new lang_string('textcolour', $component);
$description = new lang_string('textcolour_desc', $component);
$setting = new admin_setting_configcolourpicker($name, $title, $description, '');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// Variable $brand-textcolour.
// We use an empty default value because the default colour should come from the preset.
$name = "{$component}/linkcolour";
$title = new lang_string('linkcolour', $component);
$description = new lang_string('linkcolour_desc', $component);
$setting = new admin_setting_configcolourpicker($name, $title, $description, '');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// Variable $brand-textcolour.
// We use an empty default value because the default colour should come from the preset.
$name = "{$component}/linkhovercolour";
$title = new lang_string('linkhovercolour', $component);
$description = new lang_string('linkhovercolour_desc', $component);
$setting = new admin_setting_configcolourpicker($name, $title, $description, '');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);





// Variable $content-bgcolour.
// We use an empty default value because the default colour should come from the preset.
$name = "{$component}/content_bgcolour";
$title = new lang_string('content_bgcolour', $component);
$description = new lang_string('content_bgcolour_desc', $component);
$setting = new admin_setting_configcolourpicker($name, $title, $description, '');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// Variable $page-bgcolour.
// We use an empty default value because the default colour should come from the preset.
$name = "{$component}/backgroundcolour";
$title = new lang_string('backgroundcolour', $component);
$description = new lang_string('backgroundcolour_desc', $component);
$setting = new admin_setting_configcolourpicker($name, $title, $description, '');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);


// Adds settings
$settings->add($page);