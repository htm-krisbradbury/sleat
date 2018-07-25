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
 * @package   theme_sleat
 * @copyright 2016 Ryan Wyllie
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

$component = 'theme_sleat';

if ($ADMIN->fulltree) {
    $settings = new theme_sleat_admin_settingspage_tabs('themesettingsleat', get_string('configtitle', 'theme_sleat'));

    // General Settings
    require('settings/settings-general.php');

    // General Settings
    // require('settings/settings-styling.php');

    // Login
    require('settings/settings-login.php');

    // Slideshow
    require('settings/settings-slider.php');

    // Frontpage Content Area
    require('settings/settings-frontpage-content.php');

    // Quicklinks
    require('settings/settings-quicklinks.php');

    // Frontpage Course List
    require('settings/settings-fp-courses.php');

    // Page Title
    require('settings/settings-page-title.php');

    // Footer
    require('settings/settings-footer.php');

    // Tiles
    require('settings/settings-tiles.php');

    // Advanced
    require('settings/settings-advanced.php');

}