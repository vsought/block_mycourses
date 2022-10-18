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
 * Mycourses block renderer
 *
 * @package    block_mycourses
 * @copyright  Grupo Saite
 * @author     Vinicius Costa Castro <costacastrovinicius7@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace block_mycourses\output;
defined('MOODLE_INTERNAL') || die();

use renderable;
use plugin_renderer_base;
//use block_mycourses\extras\utils;

class renderer extends plugin_renderer_base {
    public function render(renderable $renderable) {
        //$token = utils::get_user_token("moodle_mobile_app");
        //$this->page->requires->js_call_amd("block_mycourses/update", "filter", array($token));
        echo $this->render_from_template("block_mycourses/main", $renderable->export_for_template($this));
    }
}