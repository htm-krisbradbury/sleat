<?php
/*
 * This file is part of Totara LMS
 *
 * Copyright (C) 2016 onwards Totara Learning Solutions LTD
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @author Brian Barnes <brian.barnes@totaralearning.com>
 * @author Joby Harding <joby.harding@totaralearning.com>
 * @package theme_sleat
 */

defined('MOODLE_INTERNAL') || die();

function theme_sleat_adjustBrightness($hex, $percent, $darken = true)
{
    // Steps should be between -255 and 255. Negative = darker, positive = lighter
    $brightness = $darken ? -255 : 255;
    $steps      = $percent * $brightness / 100;

    // Normalize into a six character long hex string
    $hex = str_replace('#', '', $hex);
    if (strlen($hex) == 3) {
        $hex = str_repeat(substr($hex, 0, 1), 2) . str_repeat(substr($hex, 1, 1), 2) . str_repeat(substr($hex, 2, 1), 2);
    }

    // Split into three parts: R, G and B
    $color_parts = str_split($hex, 2);
    $return      = '#';

    foreach ($color_parts as $color) {
        $color = hexdec($color); // Convert to decimal
        $color = max(0, min(255, $color + $steps)); // Adjust color
        $return .= str_pad(dechex($color), 2, '0', STR_PAD_LEFT); // Make two char hex code
    }

    return $return;
}

function theme_sleat_mix($color_1 = array(0, 0, 0), $color_2 = array(0, 0, 0), $weight = 0.5)
{
	$f = function($x) use ($weight) { return $weight * $x; };
	$g = function($x) use ($weight) { return (1 - $weight) * $x; };
	$h = function($x, $y) { return round($x + $y); };
	return array_map($h, array_map($f, $color_1), array_map($g, $color_2));
}

function theme_sleat_tint($color, $weight = 0.5)
{
	$t = $color;
	if(is_string($color)) $t = theme_sleat_hex2rgb($color);
	$u = theme_sleat_mix($t, array(255, 255, 255), $weight);
	if(is_string($color)) return theme_sleat_rgb2hex($u);
	return $u;
}

function theme_sleat_tone($color, $weight = 0.5)
{
	$t = $color;
	if(is_string($color)) $t = theme_sleat_hex2rgb($color);
	$u = theme_sleat_mix($t, array(128, 128, 128), $weight);
	if(is_string($color)) return theme_sleat_rgb2hex($u);
	return $u;
}

function theme_sleat_shade($color, $weight = 0.5)
{
	$t = $color;
	if(is_string($color)) $t = theme_sleat_hex2rgb($color);
	$u = theme_sleat_mix($t, array(0, 0, 0), $weight);
	if(is_string($color)) return theme_sleat_rgb2hex($u);
	return $u;
}

function theme_sleat_hex2rgb($hex = "#000000")
{
	$f = function($x) { return hexdec($x); };
	return array_map($f, str_split(str_replace("#", "", $hex), 2));
}

function theme_sleat_rgb2hex($rgb = array(0, 0, 0))
{
	$f = function($x) { return str_pad(dechex($x), 2, "0", STR_PAD_LEFT); };
	return "#" . implode("", array_map($f, $rgb));
}



/**
 * Makes our changes to the CSS
 *
 * This is only called when compiling CSS after cache clearing.
 *
 * @param string $css
 * @param theme_config $theme
 * @return string
 */
function theme_sleat_process_css($css, $theme)
{
    // Set custom CSS.
    if (!empty($theme->settings->customcss)) {
        $customcss = $theme->settings->customcss;
    } else {
        $customcss = null;
    }
    $css = theme_sleat_set_customcss($css, $customcss);

    // Define the default settings for the theme incase they've not been set.
    $brandprimary = '#0275d8';
    $defaults = array(
        '[[setting:brandprimary]]'               => $brandprimary,
        '[[setting:brandprimary-lighter]]'       => theme_sleat_tint($brandprimary, 0.4),
        '[[setting:brandprimary-darker]]'        => theme_sleat_shade($brandprimary, 0.4),
        '[[setting:sitewidth]]'                  => '1200px',
        '[[setting:textcolour]]'                 => '#373a3c',
        '[[setting:linkcolor]]'                  => '#0275d8',
        '[[setting:backgroundcolour]]'           => '#eceeef',
        '[[setting:sitebackground]]'             => 'none',
        '[[setting:sitebackground_size]]'        => 'cover',
        '[[setting:sitebackground_repeat]]'      => 'none',
        '[[setting:sitebackground_position]]'    => 'center center',
        '[[setting:sitebackground_fixed]]'       => 'fixed',
        '[[setting:loginbackground]]' => $theme->setting_file_url('loginbackground', 'loginbackground'),
    );

    // Get all the defined settings for the theme and replace defaults.
    foreach ($theme->settings as $key => $val) {
        if (array_key_exists('[[setting:'.$key.']]', $defaults) && !empty($val)) {
            $defaults['[[setting:'.$key.']]'] = $val;
        }
    }

    $loginbackground = $theme->setting_file_url('loginbackground', 'loginbackground');
    if (array_key_exists('[[setting:loginbackground]]', $defaults) && !empty($loginbackground)) {
        $defaults['[[setting:loginbackground]]'] = $loginbackground;
    }

    $sitebackground = $theme->setting_file_url('sitebackground', 'sitebackground');
    if (array_key_exists('[[setting:sitebackground]]', $defaults) && !empty($sitebackground)) {
        $defaults['[[setting:sitebackground]]'] = $sitebackground;
    }

    // Replace the CSS with values from the $defaults array.
    $css = strtr($css, $defaults);

    return $css;
}

/**
 * Adds any custom CSS to the CSS before it is cached.
 *
 * @param string $css The original CSS.
 * @param string $customcss The custom CSS to add.
 * @return string The CSS which now contains our custom CSS.
 */
function theme_sleat_set_customcss($css, $customcss) {
    $tag = '[[setting:customcss]]';
    $replacement = $customcss;
    if (is_null($replacement)) {
        $replacement = '';
    }

    $css = str_replace($tag, $replacement, $css);

    return $css;
}

/**
 * Inject additional SCSS.
 *
 * @param theme_config $theme The theme config object.
 * @return string
 */
function theme_sleat_get_extra_scss($theme) {
    return !empty($theme->settings->scss) ? $theme->settings->scss : '';
}
/**
 * Returns the main SCSS content.
 *
 * @param theme_config $theme The theme config object.
 * @return string
 */
function theme_sleat_get_main_scss_content($theme) {
    global $CFG;
    $scss = '';
    return $scss;
}
/**
 * Get SCSS to prepend.
 *
 * @param theme_config $theme The theme config object.
 * @return array
 */
function theme_sleat_get_pre_scss($theme) {
    global $CFG;
    $scss = '';
    $configurable = [
        // Config key => [variableName, ...].
        'brandprimary' => ['theme-brand-primary'],
        'textcolour' => ['theme-text-color'],
        'linkcolour' => ['theme-link-color'],
        'linkhovercolour' => ['theme-link-hover-color'],
        'content_bgcolour' => ['theme-content-background-color'],
        'backgroundcolour' => ['theme-page-background-color'],
        'frontpage_slideroverlaycolour' => ['slide-overlay-color'],
        'sitewidth' => ['theme-sitewidth'],
        'footer_section_text_colour' => ['theme-footer-text-color'],
        'footer_section_link_colour' => ['theme-footer-link-color'],
        'footer_section_link_hover_colour' => ['theme-footer-link-hover-color'],
        'frontpage_logo_carousel_logo_height' => ['theme-logo-carousel-logo-height'],
        'frontpage_slider_height' => ['theme-slider-height']
    ];
    // Prepend variables first.
    foreach ($configurable as $configkey => $targets) {
        $value = isset($theme->settings->{$configkey}) ? $theme->settings->{$configkey} : null;
        if (empty($value)) {
            continue;
        }
        array_map(function($target) use (&$scss, $value) {
            $scss .= '$' . $target . ': ' . $value . ";\n";
        }, (array) $targets);
    }
    // Prepend pre-scss.
    if (!empty($theme->settings->scsspre)) {
        $scss .= $theme->settings->scsspre;
    }
    // Set the background image for the page.
    $loginbackground = $theme->setting_file_url('login_background_image', 'login_background_image');
    if (isset($loginbackground)) {
        $scss .= '$loginbackground: url("'.$loginbackground.'");';
    }
    return $scss;
}

/**
 * Serves any files associated with the theme settings.
 *
 * @param stdClass $course
 * @param stdClass $cm
 * @param context $context
 * @param string $filearea
 * @param array $args
 * @param bool $forcedownload
 * @param array $options
 * @return bool
 */
function theme_sleat_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options = array())
{
    if ($context->contextlevel == CONTEXT_SYSTEM) {
        $theme = theme_config::load('theme_sleat');

        if ($filearea === 'sitebackground') {
            return $theme->setting_file_serve('sitebackground', $args, $forcedownload, $options);
        } else if ($filearea === 'logo') {
            return $theme->setting_file_serve('logo', $args, $forcedownload, $options);
        } else if ($filearea === 'page_title_background') {
            return $theme->setting_file_serve('page_title_background', $args, $forcedownload, $options);
        } else if ($filearea === 'login_background_image') {
            return $theme->setting_file_serve('login_background_image', $args, $forcedownload, $options);
        } else if (preg_match("/^(frontpage_slideshow_)[1-9][0-9]*_image$/", $filearea)) {
            return $theme->setting_file_serve($filearea, $args, $forcedownload, $options);
        } else if (preg_match("/^(frontpage_quicklink_)[1-9][0-9]*_image$/", $filearea)) {
            return $theme->setting_file_serve($filearea, $args, $forcedownload, $options);
        } else if (preg_match("/^(frontpage_accreditations_)[1-9][0-9]*_image$/", $filearea)) {
            return $theme->setting_file_serve($filearea, $args, $forcedownload, $options);
        } else {
            send_file_not_found();
        }

    }

    send_file_not_found();
}


