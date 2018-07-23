<?php

$page = new admin_settingpage("{$component}_fp_slideshow", new lang_string('fpslideshowsettings', $component));
// Toggle Slideshow.
$name               = "{$component}/toggleslideshow";
$title              = new lang_string('toggleslideshow', $component);
$description        = new lang_string('toggleslideshowdesc', $component);
$alwaysdisplay      = new lang_string('alwaysdisplay', $component);
$displaybeforelogin = new lang_string('displaybeforelogin', $component);
$displayafterlogin  = new lang_string('displayafterlogin', $component);
$dontdisplay        = new lang_string('dontdisplay', $component);
$default            = 0;
$choices            = array(0 => $dontdisplay, 1 => $alwaysdisplay, 2 => $displaybeforelogin, 3 => $displayafterlogin);
$setting            = new admin_setting_configselect($name, $title, $description, 0, $choices);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);
// Slideshow Transition.
$name        = "{$component}/slideshowtransition";
$title       = new lang_string('slidetranstype', $component);
$description = new lang_string('slidetranstypedesc', $component);
$fade        = 'fade';
$slide       = 'slide';
$default     = 'fade';
$choices     = array('fade' => $fade, 'horizontal' => $slide);
$setting     = new admin_setting_configselect($name, $title, $description, $default, $choices);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);
// Slideshow Transition Speed.
$name        = "{$component}/slideshowtransspeed";
$title       = new lang_string('slidetransspeed', $component);
$description = new lang_string('slidetransspeeddesc', $component);
$default     = 500;
$setting     = new admin_setting_configtext($name, $title, $description, $default, PARAM_INT);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);
// Slideshow Time per Slide.
$name        = "{$component}/slideshowtimeperslide";
$title       = new lang_string('slidetime', $component);
$description = new lang_string('slidetimedesc', $component);
$default     = 9000;
$setting     = new admin_setting_configtext($name, $title, $description, $default, PARAM_INT);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);
// Slider count.
$name        = "{$component}/slidercount";
$title       = new lang_string('slidecount', $component);
$description = new lang_string('slidecountdesc', $component);
$default     = 4;
$choices     = array(
    1 => '1',
    2 => '2',
    3 => '3',
    4 => '4',
);
$setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);


/* Slide loop ------------------------------*/
for ($i = 1; $i <= get_config($component, 'slidercount'); $i++) {
    // This is the descriptor for Slide One.
    $name        = "{$component}/slide_{$i}_info";
    $heading     = new lang_string('slideheading', $component) . $i;
    $information = new lang_string('slideinfo', $component) . $i;
    $setting     = new admin_setting_heading($name, $heading, $information);
    $page->add($setting);
    // Title.
    $name        = "{$component}/slide_{$i}_heading";
    $title       = new lang_string('slidetitle', $component);
    $description = new lang_string('slidetitledesc', $component);
    $setting     = new admin_setting_configtextarea($name, $title, $description, '');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    // Button text.
    $name        = "{$component}/slide_{$i}_caption";
    $title       = new lang_string('slidecaption', $component);
    $description = new lang_string('slidecaptiondesc', $component);
    $setting     = new admin_setting_configtextarea($name, $title, $description, '');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    // URL.
    $name        = "{$component}/slide_{$i}_url";
    $title       = new lang_string('slideurl', $component);
    $description = new lang_string('slideurldesc', $component);
    $setting     = new admin_setting_configtext($name, $title, $description, '', PARAM_URL);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    // Image.
    $name        = "{$component}/slide_{$i}_image";
    $title       = new lang_string('slideimage', $component);
    $description = new lang_string('slideimagedesc', $component);
    $setting     = new admin_setting_configstoredfile($name, $title, $description, "slide_{$i}_image");
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
}
$settings->add($page);

?>