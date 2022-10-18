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
 * Class containing data for my courses block.
 *
 * @package    block_mycourses
 * @copyright
 * @author
 * @license
 */

namespace block_mycourses\output;
defined('MOODLE_INTERNAL') || die();

use stdClass;
use moodle_url;
use renderable;
use templatable;
use renderer_base;
use block_mycourses\extras\utils;

class main implements renderable, templatable {
    public function export_for_template(renderer_base $output) {
        $context = new stdClass();
        $context->courses = utils::get_courses();
        //$context->mytrails = utils::get_courses_trails();
        $context->lastaccessedcourse = utils::get_last_accessed_course();
        $context->lastaccessedcourses = utils::get_last_accessed_courses();
        $context->coursesavailable = new moodle_url("/", array("redirect" => 0, "courses" => "all"));
        $context->trailsavailable = new moodle_url("/", array("redirect" => 0, "trails" => "all"));
        
        if(empty($context->courses)){
            $context->firstaccess = true;
            $context->coursesfirstaccess = utils::get_courses_firstaccess();
        }else{
            $context->firstaccess = false;
        }
        return $context;
    }
}