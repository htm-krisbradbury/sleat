<?php
// This file is part of The Bootstrap Moodle theme
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
 * @package     theme_sleat
 * @copyright   2014 Bas Brands, www.basbrands.nl
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @author      Bas Brands
 * @author      David Scotson
 * @author      Joby Harding <joby.harding@totaralearning.com>
 * @author      Petr Skoda <petr.skoda@totaralms.com>
 */

defined('MOODLE_INTERNAL') || die();

$PAGE->set_popup_notification_allowed(false);

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

$sidepreblocks = $OUTPUT->blocks('side-pre');
$hassidepre = $PAGE->blocks->is_known_region('side-pre');

$hasHeaderLogo = false;
$logoAlt = false;
$headerLogo = $OUTPUT->get_setting_img('logo');
if (!empty($headerLogo)) {
    $hasHeaderLogo = true;
    $logoAlt = $OUTPUT->get_setting('logo_alt');
}


$footer = $OUTPUT->htm_display_footer();

$header_strapline = $OUTPUT->get_setting( 'strapline' );
$title_background = $OUTPUT->get_setting_img( 'page_title_background' );
$page_title = $PAGE->title;

$templatecontext = [
    'sitename' => format_string($SITE->shortname, true, ['context' => context_course::instance(SITEID), "escape" => false]),
    'output' => $OUTPUT,
    'bodyattributes' => $bodyattributes,    
    'sidepreblocks' => $sidepreblocks,
    'hassidepre' => $hassidepre,
    'totaramenu' => $totaramenu,
    'headerlogo'                => $headerLogo,
    'hasheaderlogo'             => $hasHeaderLogo,
    'logo_alt'                  => $logoAlt,
    'footer'                    => $footer,
    'strapline'                 => $header_strapline,
    'titleBackground'           => $title_background,
    'pageTitle'                 => $page_title,
];


echo $OUTPUT->render_from_template('theme_sleat/columns2', $templatecontext);
?>