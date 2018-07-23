 <?php
    
    $page = new admin_settingpage("{$component}_general", new lang_string('generalsettings', $component));

    // Site width
    $name        = "{$component}/sitewidth";
    $title       = new lang_string('sitewidth', $component);
    $description = new lang_string('sitewidthdesc', $component);
    $setting     = new admin_setting_configtext($name, $title, $description, '');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Logo file setting.
    $name        = "{$component}/logo";
    $title       = new lang_string('logo', $component);
    $description = new lang_string('logodesc', $component);
    $setting     = new admin_setting_configstoredfile($name, $title, $description, 'logo');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Logo alt text.
    $name        = "{$component}/alttext";
    $title       = new lang_string('alttext', $component);
    $description = new lang_string('alttextdesc', $component);
    $setting     = new admin_setting_configtext($name, $title, $description, '');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Strapline.
    $name        = "{$component}/strapline";
    $title       = new lang_string('strapline', $component);
    $description = new lang_string('straplinedesc', $component);
    $setting     = new admin_setting_configtext($name, $title, $description, '');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $settings->add($page);

?>