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
 * @copyright 2016 onwards Totara Learning Solutions LTD
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @author    Joby Harding <joby.harding@totaralearning.com>
 * @package   theme_basis
 */

class theme_sleat_totara_reportbuilder_renderer extends totara_reportbuilder_renderer {

	/**
     * Display the results table
     *
     * @return void No return value but prints the current data table
     */
    function display_table() {
        global $SESSION, $DB, $OUTPUT, $PAGE, $CFG;

        $initiallyhidden = $this->is_initially_hidden();

        if (!defined('SHOW_ALL_PAGE_SIZE')) {
            define('SHOW_ALL_PAGE_SIZE', 9999);
        }
        if (defined('DEFAULT_PAGE_SIZE')) {
            $this->recordsperpage = DEFAULT_PAGE_SIZE;
        }
        $perpage   = optional_param('perpage', $this->recordsperpage, PARAM_INT);

        $columns = $this->columns;
        $shortname = $this->shortname;
        $countfiltered = $this->get_filtered_count();

        if (count($columns) == 0) {
            echo html_writer::tag('p', get_string('error:nocolumnsdefined', 'totara_reportbuilder'));
            return;
        }

        $graphrecord = $DB->get_record('report_builder_graph', array('reportid' => $this->_id));
        if (!empty($graphrecord->type) && !totara_feature_disabled('reportgraphs')) {
            $graph = new \totara_reportbuilder\local\graph($graphrecord, $this, false);
        } else {
            $graph = null;
        }

        list($sql, $params, $cache) = $this->build_query(false, true);

        $tablecolumns = array();
        $tableheaders = array();
        foreach ($columns as $column) {
            $type = $column->type;
            $value = $column->value;
            if ($column->display_column(false)) {
                $tablecolumns[] = "{$type}_{$value}"; // used for sorting
                $tableheaders[] = $this->format_column_heading($column, false);
            }
        }

        // Arrgh, the crazy table outputs each row immediately...
        ob_start();

        $classes = '';

        // If we're displaying the sidebar filters we need the content to be responsive.
        if ($this->get_sidebar_filters()) {
            $classes = ' col-md-9 col-sm-8 col-xs-12';
        }

        // If it's an embedded report, put the shortname in the class. Can be used in css/js to select the specific report.
        if ($this->embedded) {
            $classes .= ' embeddedshortname_' . $shortname;
        }

        // Prevent notifications boxes inside the table.
        echo $OUTPUT->container_start('nobox rb-display-table-container no-overflow cb-test' . $classes, $this->_id);

        // Output cache information if needed.
        if ($cache) {
            $lastreport = userdate($cache['lastreport']);
            $nextreport = userdate($cache['nextreport']);

            $html = html_writer::start_tag('div', array('class' => 'noticebox'));
            $html .= get_string('report:cachelast', 'totara_reportbuilder', $lastreport);
            $html .= html_writer::empty_tag('br');
            $html .= get_string('report:cachenext', 'totara_reportbuilder', $nextreport);
            $html .= html_writer::end_tag('div');
            echo $html;
        }

        // Start the table.
        $table = new totara_table($this->get_uniqueid('rb'));

        if ($this->toolbarsearch && $this->has_toolbar_filter()) {
            $toolbarsearchtext = isset($SESSION->reportbuilder[$this->get_uniqueid()]['toolbarsearchtext']) ?
                    $SESSION->reportbuilder[$this->get_uniqueid()]['toolbarsearchtext'] : '';
            $mform = new report_builder_toolbar_search_form($this->get_current_url(),
                    array('toolbarsearchtext' => $toolbarsearchtext), 'post', '', null, true, 'toolbarsearch');
            $table->add_toolbar_content($mform->render());

            if ($this->embedded && $content = $this->embedobj->get_extrabuttons()) {
                $table->add_toolbar_content($content, 'right');
            }
        }

        $showhidecolumn = array();
        if (isset($SESSION->rb_showhide_columns[$shortname])) {
            $showhidecolumn = $SESSION->rb_showhide_columns[$shortname];
        }
        $table->define_columns($tablecolumns);
        $table->define_headers($tableheaders);
        $table->define_baseurl($this->get_current_url());
        foreach ($columns as $column) {
            if ($column->display_column()) {
                $ident = "{$column->type}_{$column->value}";
                // Assign $type_$value class to each column.
                $classes = $ident;
                // Apply any column-specific class.
                if (is_array($column->class)) {
                    foreach ($column->class as $class) {
                        $classes .= ' ' . $class;
                    }
                }
                $table->column_class($ident, $classes);
                // Apply any column-specific styling.
                if (is_array($column->style)) {
                    foreach ($column->style as $property => $value) {
                        $table->column_style($ident, $property, $value);
                    }
                }
                if (isset($showhidecolumn[$ident])) {
                    // Session show/hide is set, so use it, and ignore column default.
                    if ((int)$showhidecolumn[$ident] == 0) {
                        $table->column_style($ident, 'display', 'none');
                    }
                } else {
                    // No session set, so use default show/hide value.
                    if ($column->hidden != 0) {
                        $table->column_style($ident, 'display', 'none');
                    }
                }

                // Disable sorting on column where indicated.
                if ($column->nosort) {
                    $table->no_sorting($ident);
                }
            }
        }
        $table->set_attribute('cellspacing', '0');
        $table->set_attribute('id', $shortname);
        $table->set_attribute('class', 'logtable generalbox reportbuilder-table');
        $table->set_attribute('data-source', clean_param(get_class($this->src), PARAM_ALPHANUMEXT));
        $table->set_control_variables(array(
            TABLE_VAR_SORT    => 'ssort',
            TABLE_VAR_HIDE    => 'shide',
            TABLE_VAR_SHOW    => 'sshow',
            TABLE_VAR_IFIRST  => 'sifirst',
            TABLE_VAR_ILAST   => 'silast',
            TABLE_VAR_PAGE    => 'spage'
        ));
        $table->sortable(true, $this->defaultsortcolumn, $this->defaultsortorder); // sort by name by default
        $table->setup();
        $table->initialbars(true);
        $table->pagesize($perpage, $countfiltered);
        $table->add_toolbar_pagination('right', 'both');

        if ($initiallyhidden) {
            $table->set_no_records_message(get_string('initialdisplay_pending', 'totara_reportbuilder'));
        } else {
            if ($this->is_report_filtered()) {
                $table->set_no_records_message(get_string('norecordswithfilter', 'totara_reportbuilder'));
            } else {
                $table->set_no_records_message(get_string('norecordsinreport', 'totara_reportbuilder'));
            }
            // Get the ORDER BY SQL fragment from table.
            $order = $this->get_report_sort($table);
            try {
                $pagestart = $table->get_page_start();
                if ($records = $DB->get_recordset_sql($sql.$order, $params, $pagestart, $perpage)) {
                    $count = $this->get_filtered_count();
                    $location = 0;
                    foreach ($records as $record) {
                        $record_data = $this->src->process_data_row($record, 'html', $this);
                        foreach ($record_data as $k => $v) {
                            if ((string)$v === '') {
                                // We do not want empty cells in HTML table.
                                $record_data[$k] = '&nbsp;';
                            }
                        }
                        if (++$location == $count % $perpage || $location == $perpage) {
                            $table->add_data($record_data, 'last');
                        } else {
                            $table->add_data($record_data);
                        }

                        if ($graph and $pagestart == 0) {
                            $graph->add_record($record);
                        }
                    }
                }
                if ($graph and ($pagestart != 0 or $perpage == $graph->count_records())) {
                    $graph->reset_records();
                    if ($records = $DB->get_recordset_sql($sql.$order, $params, 0, $graph->get_max_records())) {
                        foreach ($records as $record) {
                            $graph->add_record($record);
                        }
                    }
                }
            } catch (dml_read_exception $e) {
                ob_end_flush();

                if ($this->is_cached()) {
                    $debuginfo = $CFG->debugdeveloper ? $e->debuginfo : '';
                    print_error('error:problemobtainingcachedreportdata', 'totara_reportbuilder', '', $debuginfo);
                } else {
                    $debuginfo = $CFG->debugdeveloper ? $e->debuginfo : '';
                    print_error('error:problemobtainingreportdata', 'totara_reportbuilder', '', $debuginfo);
                }
            }
        }

        // The rows are already displayed.
        $table->finish_html();

        // end of .nobox div
        echo $OUTPUT->container_end();

        $tablehmtml = ob_get_clean();

        if ($graph and $graphdata = $graph->fetch_svg()) {
            if (core_useragent::check_browser_version('MSIE', '6.0') and !core_useragent::check_browser_version('MSIE', '9.0')) {
                // See http://partners.adobe.com/public/developer/en/acrobat/PDFOpenParameters.pdf
                $svgurl = new moodle_url('/totara/reportbuilder/ajax/graph.php', array('id' => $this->_id, 'sid' => $this->_sid));
                if ($this->globalrestrictionset) {
                    // Add the global restriction ids.
                    $restrictionids = $this->globalrestrictionset->get_current_restriction_ids();
                    if ($restrictionids) {
                        $svgurl->param('globalrestrictionids', implode(',', $restrictionids));
                    }
                }
                $svgurl = $svgurl . '#toolbar=0&navpanes=0&scrollbar=0&statusbar=0&viewrect=20,20,400,300';
                $nopdf = get_string('error:nopdf', 'totara_reportbuilder');
                echo "<div class=\"rb-report-pdfgraph\"><object type=\"application/pdf\" data=\"$svgurl\" width=\"100%\" height=\"400\">$nopdf</object>";

            } else {
                // The SVGGraph supports only one SVG per page when embedding directly,
                // it should be fine here because there are no blocks on this page.
                echo '<div class="rb-report-svggraph">';
                echo $graphdata;
                echo '</div>';
            }
        }

        echo $tablehmtml;

        $jsmodule = array(
            'name' => 'totara_reportbuilder_expand',
            'fullpath' => '/totara/reportbuilder/js/expand.js',
            'requires' => array('json'));
        $PAGE->requires->js_init_call('M.totara_reportbuilder_expand.init', array(), true, $jsmodule);

    }

}