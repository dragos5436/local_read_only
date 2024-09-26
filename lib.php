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

namespace local_read_only;
defined('MOODLE_INTERNAL') || die();

use core\hook\output\before_standard_top_of_body_html_generation;

class hooks {
    /**
     * This function is triggered before the standard top of body HTML is generated.
     *
     * @param before_standard_top_of_body_html_generation $hook The hook object that allows modification of HTML.
     */
    public static function before_standard_top_of_body_html_generation(before_standard_top_of_body_html_generation $hook) {
        global $DB;
        
        if (get_config('local_read_only', 'enable_readonly') === '1') {
            $msg = get_config('local_read_only', 'alert_message');
            if (!method_exists($DB, 'get_readonly_driver')) {
                $msg = get_string('configfileerror', 'local_read_only');
                \core\notification::add($msg, \core\notification::WARNING);
            } else if (is_siteadmin()) {
                $msg .= get_string('youareadmin', 'local_read_only');
                \core\notification::add($msg, \core\notification::WARNING);
            } else {
                \core\notification::add($msg, \core\notification::WARNING);
            }
        }
    }
}
