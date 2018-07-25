<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * A two column layout for the sleat theme.
 *
 * @package   theme_sleat
 * @copyright 2016 Damyon Wiese
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

// TODO improve on this legacy approach.
$hastotaramenu = false;
$totaramenu = '';
if (empty($PAGE->layout_options['nocustommenu'])) {
    $menudata = totara_build_menu();
    $totara_core_renderer = $PAGE->get_renderer('totara_core');
    $totaramenu = $totara_core_renderer->totara_menu($menudata);
    $hastotaramenu = !empty($totaramenu);
}

$extraclasses = [];
$bodyattributes = $OUTPUT->body_attributes($extraclasses);

$blockshtml = $OUTPUT->blocks('side-pre');
$hasblocks = strpos($blockshtml, 'data-block=') !== false;


$slider = $OUTPUT->htm_fp_slideshow("frontpage");
$quicklinks = $OUTPUT->htm_display_quicklinks("frontpage");

$header_strapline = $OUTPUT->get_setting( 'strapline' );

$fp_courses_title = $OUTPUT->get_setting( 'fp_course_list_title' );

$hasHeaderLogo = false;
$logoAlt = false;
$headerLogo = $OUTPUT->get_setting_img('logo');
if (!empty($headerLogo)) {
    $hasHeaderLogo = true;
    $logoAlt = $OUTPUT->get_setting('logo_alt');
}


$fpc = $OUTPUT->htm_display_fpc();

$logoCarousel = $OUTPUT->htm_display_logo_carousel();

$current_sesskey = sesskey();

$smurls = $OUTPUT->htm_get_sm_urls();
$footer = $OUTPUT->htm_display_footer();


$templatecontext = [
    'sitename'                  => format_string($SITE->shortname, true, ['context' => context_course::instance(SITEID), "escape" => false]),
    'output'                    => $OUTPUT,
    'siteurl'                   => $CFG->wwwroot,
    'sidepreblocks'             => $blockshtml,
    'hasblocks'                 => $hasblocks,
    'bodyattributes'            => $bodyattributes,
    'totaramenu'                => $totaramenu,
    'headerlogo'                => $headerLogo,
    'hasheaderlogo'             => $hasHeaderLogo,
    'strapline'                 => $header_strapline,
    'logo_alt'                  => $logoAlt,
    'fpc'                       => $fpc,
    'slider'                    => $slider,
    'quicklinks'                => $quicklinks,
    'logoCarousel'              => $logoCarousel,
    'smurls'                    => $smurls,
    'footer'                    => $footer,
    'coursesTitle'              => $fp_courses_title,
    'currentSesskey'            => $current_sesskey
];


echo $OUTPUT->render_from_template('theme_sleat/frontpage', $templatecontext);

