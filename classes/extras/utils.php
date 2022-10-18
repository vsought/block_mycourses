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
 * Useful functions class.
 *
 * @package    block_mycourses
 * @copyright
 * @author
 * @license
 */

namespace block_mycourses\extras;
defined('MOODLE_INTERNAL') || die();

require_once("$CFG->dirroot/course/lib.php");

use stdClass;
use moodle_url;
use section_info;
use core_course_category;

define('ALL_COURSES', 1);
define('ONGOING_COURSES', 2);
define('COMPLETED_COURSES', 3);
define('CLOSED_COURSES', 4);

class utils {
    
    public static function get_courses() {
        $response = array();
        $courses = \course_get_enrolled_courses_for_logged_in_user();

        foreach ($courses as $course) {
            $format = course_get_format($course->id);
            $course = $format->get_course();

            

            $course->courseimage = utils::get_course_summary_image($course);
            $course->url = utils::get_course_view_url($course);

            $course->percentage = utils::get_course_completed_percentage($course);
            $course->percentage = $course->percentage == 0.0 ? false : $course->percentage;
            $course->progress = [];
            
            

            foreach (utils::get_course_custom_fields($course) as $field => $value) {
                $course->{$field} = $value;
            }

            $response[] = $course; 
        }

        return $response;
    }



    public static function get_last_accessed_course() {
        $courses = course_get_recent_courses();
        
        if (count($courses) === 0) {
            return null;
        }

        

        $course = array_shift($courses);
        $course = course_get_format($course->id)->get_course();
        $course->courseimage = utils::get_course_summary_image($course);
        $course->url = utils::get_course_view_url($course);
        $course->percentage = utils::get_course_completed_percentage($course);

        foreach (utils::get_course_custom_fields($course) as $field => $value) {
            $course->{$field} = $value;
        }

        return $course;
    }

    public static function get_last_accessed_courses() {
        $courses = course_get_recent_courses();
        
        if (count($courses) === 0) {
            return null;
        }

        

        $lastAccessedCourses = [];
        for ($i=0; $i < 3; $i++){ 
            $course = array_shift($courses);
            if($course !== null){
                $course = course_get_format($course->id)->get_course();
                $course->courseimage = utils::get_course_summary_image($course);
                $course->url = utils::get_course_view_url($course);
                
                $course->percentage = utils::get_course_completed_percentage($course);
                $course->percentage = $course->percentage == 0.0 ? false : $course->percentage;
                $cat = core_course_category::get($course->category, IGNORE_MISSING);

                if (!$cat) {
                    return '';
                }
                
                $course->category = $cat->get_formatted_name()/*$course->category*/;
                
                
                foreach (utils::get_course_custom_fields($course) as $field => $value) {
                    $course->{$field} = $value;
                }
                $lastAccessedCourses[] = $course;
            }
        }

        return $lastAccessedCourses;
    }

    /**
     * Returns the course image url
     * 
     * @return string
     */
    public static function get_course_summary_image($course) {
        global $CFG, $OUTPUT;

        
        $category = core_course_category::get($course->category);
        $courses = $category->get_courses();

        foreach ($courses as $category_course) {
            if ($category_course->id !== $course->id) {
                continue;
            }

            foreach ($category_course->get_course_overviewfiles() as $file) {
                if ($file->is_valid_image()) {
                    $url = moodle_url::make_file_url("$CFG->wwwroot/pluginfile.php",
                    '/' . $file->get_contextid() . '/' . $file->get_component() . '/' .
                    $file->get_filearea() . $file->get_filepath() . $file->get_filename(), !$file->is_valid_image());

                return $url->out();
                }
            }
        }

        return $OUTPUT->get_generated_image_for_id($course->id);
    }

    /**
     * Returns the course view url
     * 
     * @return moodle_url
     */
    public static function get_course_view_url($course) {
        return new moodle_url("/course/view.php", array(
            "id" => $course->id,
            "page" => "introduction",
        ));
    }

    /**
     * Returns the course custom fields data
     * 
     * @return array
     */
    public static function get_course_custom_fields($course) {
        global $DB;
        
        $data = array();
        $result = $DB->get_records("course_format_options", array(
            "courseid" => $course->id,
        ));

        foreach ($result as $info) {
            $data[$info->name] = $info->value;
        }

        return $data;
    }

    /**
     * Returns the course completed percentage
     * 
     * @return float
     */
    public static function get_course_completed_percentage($course) {
        global $DB, $USER;

        $course = $DB->get_record("course", array("id" => $course->id), "*", MUST_EXIST);
        $percentage = \core_completion\progress::get_course_progress_percentage($course, $USER->id);

        return floor($percentage);
    }
    
}