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
 */

defined('MOODLE_INTERNAL' || die());

$THEME->doctype = 'html5';
$THEME->name = 'sleat';
$THEME->parents = array('roots', 'base');
$THEME->yuicssmodules = array();
$THEME->enable_dock = false;
//$THEME->sheets = array('main', 'custom-noprocess');
$THEME->supportscssoptimisation = false;
$THEME->enable_dock = true;

$THEME->rendererfactory = 'theme_overridden_renderer_factory';
$THEME->csspostprocess = 'theme_sleat_process_css';

$THEME->javascripts = array('custom', 'slick');
$THEME->scss = 'main';
$THEME->extrascsscallback = 'theme_sleat_get_extra_scss';
$THEME->prescsscallback = 'theme_sleat_get_pre_scss';

// Use CSS preprocessing to facilitate style inheritance.
$THEME->parents_exclude_sheets = array();

$THEME->plugins_exclude_sheets = array(
    'block' => array(
        'current_learning',
        'search_forums',
        'totara_alerts',
    ),
    'mod' => array(
        'feedback'
    ),
    'report' => array(
        'participation',
        'progress'
    ),
    'tool' => array(
        'customlang',
    ),
    'totara' => array(
        'appraisal',
        'feedback360',
        'form',
        'job',
        'plan',
        'program',
        'reportbuilder',
    ),
);

$THEME->layouts = array(
    // Most backwards compatible layout with blocks on the left - this is the layout used by default in Totara,
    // it is also the fallback when page layout is set too late when initialising page.
    // Standard Moodle themes have base layout without blocks.
    'base' => array(
        'file' => 'default.php',
        'regions' => array('side-pre'),
        'defaultregion' => 'side-pre',
    ),
    // Standard layout with blocks, this is recommended for most pages with general information.
    'standard' => array(
        'file' => 'columns2.php',
        'regions' => array('side-pre'),
        'defaultregion' => 'side-pre'
    ),
    // Main course page.
    'course' => array(
        'file' => 'course.php',
        'regions' => array('side-pre'),
        'defaultregion' => 'side-pre',
        'options' => array('langmenu' => true)
    ),
    'coursecategory' => array(
        'file' => 'columns2.php',
        'regions' => array('side-pre'),
        'defaultregion' => 'side-pre',
    ),
    // Part of course, typical for modules - default page layout if $cm specified in require_login().
    'incourse' => array(
        'file' => 'columns2.php',
        'regions' => array('side-pre'),
        'defaultregion' => 'side-pre',
    ),
    // The site home page.
    'frontpage' => array(
        'file' => 'frontpage.php',
        'regions' => array('side-pre'),
        'defaultregion' => 'side-pre',
        'options' => array('nonavbar' => true),
    ),
    // Server administration scripts.
    'admin' => array(
        'file' => 'columns2.php',
        'regions' => array('side-pre'),
        'defaultregion' => 'side-pre',
        'options' => array('fluid' => true),
    ),
    // This would be better described as "user profile" but we've left it as mydashboard
    // for backward compatibilty for existing themes. This layout is NOT used by Totara
    // dashboards but is used by user related pages such as the user profile, private files
    // and badges.
    'mydashboard' => array(
        'file' => 'columns2.php',
        'regions' => array('side-pre'),
        'defaultregion' => 'side-pre',
    ),
    // The dashboard layout differs from the one above in that it includes a central block region.
    // It is used by Totara dashboards.
    'dashboard' => array(
        'file' => 'dashboard.php',
        'regions' => array('side-pre', 'side-post', 'main'),
        'defaultregion' => 'main',
        'options' => array('langmenu' => true),
    ),
    // My public page.
    'mypublic' => array(
        'file' => 'columns2.php',
        'regions' => array('side-pre'),
        'defaultregion' => 'side-pre',
    ),
    'login' => array(
        'file' => 'login.php',
        'regions' => array(),
        'options' => array('langmenu' => true, 'nocustommenu' => true, 'nonavbar' => true),
    ),

    // Pages that appear in pop-up windows - no navigation, no blocks, no header.
    'popup' => array(
        'file' => 'popup.php',
        'regions' => array(),
        'options' => array('nofooter' => true, 'nonavbar' => true),
    ),
    // No blocks and minimal footer - used for legacy frame layouts only!
    'frametop' => array(
        'file' => 'default.php',
        'regions' => array(),
        'options' => array('nofooter' => true, 'nocoursefooter' => true),
    ),
    // Embeded pages, like iframe/object embeded in moodleform - it needs as much space as possible.
    'embedded' => array(
        'file' => 'embedded.php',
        'regions' => array()
    ),
    // Used during upgrade and install, and for the 'This site is undergoing maintenance' message.
    // This must not have any blocks, links, or API calls that would lead to database or cache interaction.
    // Please be extremely careful if you are modifying this layout.
    'maintenance' => array(
        'file' => 'maintenance.php',
        'regions' => array(),
    ),
    // Should display the content and basic headers only.
    'print' => array(
        'file' => 'default.php',
        'regions' => array(),
        'options' => array('nofooter' => true, 'nonavbar' => false),
    ),
    // The pagelayout used when a redirection is occuring.
    'redirect' => array(
        'file' => 'embedded.php',
        'regions' => array(),
    ),
    // The pagelayout used for reports.
    'report' => array(
        'file' => 'columns2.php',
        'regions' => array('side-pre'),
        'defaultregion' => 'side-pre',
    ),
    // The pagelayout used for safebrowser and securewindow.
    'secure' => array(
        'file' => 'secure.php',
        'regions' => array('side-pre', 'side-post'),
        'defaultregion' => 'side-pre'
    ),
    'noblocks' => array(
        'file' => 'default.php',
        'regions' => array('side-pre'),
        'defaultregion' => 'side-pre',
        'options' => array('langmenu' => true),
    ),
);
