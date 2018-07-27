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

$extraclasses = [];
$bodyattributes = $OUTPUT->body_attributes($extraclasses);
$blockshtml = $OUTPUT->blocks('side-pre');
$hasblocks = strpos($blockshtml, 'data-block=') !== false;

// TODO improve on this legacy approach.
$hastotaramenu = false;
$totaramenu = '';
if (empty($PAGE->layout_options['nocustommenu'])) {
    $menudata = totara_build_menu();
    $totara_core_renderer = $PAGE->get_renderer('totara_core');
    $totaramenu = $totara_core_renderer->totara_menu($menudata);
    $hastotaramenu = !empty($totaramenu);
}

if($PAGE->theme->settings->activity_tiles) {
    $hascoursetiles = true;
} else {
    $hascoursetiles = false;
}

$hasHeaderLogo = false;
$logoAlt = false;
$headerLogo = $OUTPUT->get_setting_img('logo');
if (!empty($headerLogo)) {
    $hasHeaderLogo = true;
    $logoAlt = $OUTPUT->get_setting('logo_alt');
}

$courseid = null;
if(isset($_GET['id']) && !empty($_GET['id'])) {
    $courseid = $_GET['id'];
}

$header_strapline = $OUTPUT->get_setting( 'strapline' );
$title_background = $OUTPUT->get_setting_img( 'page_title_background' );
$page_title = $PAGE->title;

$footer = $OUTPUT->htm_display_footer();

$templatecontext = [
    'sitename'                  => format_string($SITE->shortname, true, ['context' => context_course::instance(SITEID), "escape" => false]),
    'output'                    => $OUTPUT,
    'siteurl'                   => $CFG->wwwroot,
    'sidepreblocks'             => $blockshtml,
    'hasblocks'                 => $hasblocks,
    'bodyattributes'            => $bodyattributes,
    'totaramenu' => $totaramenu,
    'hascoursetiles'            => $hascoursetiles,
    'headerlogo'                => $headerLogo,
    'hasheaderlogo'             => $hasHeaderLogo,
    'strapline'                 => $header_strapline,
    'logo_alt'                  => $logoAlt,
    'footer'                    => $footer,
    'titleBackground'           => $title_background,
    'pageTitle'                 => $page_title,
];


echo $OUTPUT->render_from_template('theme_sleat/course', $templatecontext);

