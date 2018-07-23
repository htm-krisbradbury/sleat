<?php

$page = new admin_settingpage("{$component}_login", new lang_string('loginsettings', $component));

    // Login background setting.
    $name        = "{$component}/loginbackground";
    $title       = new lang_string('loginbackground', $component);
    $description = new lang_string('loginbackground_desc', $component);
    $setting     = new admin_setting_configstoredfile($name, $title, $description, 'loginbackground');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

$settings->add($page);

?>