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
 * Contains the class for the mycourses block.
 *
 * @package    block_mycourses
 * @copyright
 * @author     Vinícius Augusto Cardoso Reis <vinaut.cr@gmail.com>
 * @license
 */

defined("MOODLE_INTERNAL") || die();

/**
 * Mycourses block class.
 *
 * @package    block_mycourses
 * @copyright
 * @author     Vinícius Augusto Cardoso Reis <vinaut.cr@gmail.com>
 * @license
 */


class block_mycourses extends block_base {
    public function init() {
        $this->title = get_string('pluginname', 'block_mycourses');
    }
    // The PHP tag and the curly bracket for the class definition 
    // will only be closed after there is another function added in the next section.

    public function get_content() {
        if ($this->content !== null) {
          return $this->content;
        }
    
        $this->content         =  new stdClass;
        //$this->content->text   = 'Bloco "Meus Cursos" do UFMA Virtual';

        $renderer = $this->page->get_renderer("block_mycourses");
        $renderable = new \block_mycourses\output\main();
        $this->content->text = $renderer->render($renderable);
       
        //$this->content->text = $renderer->render($renderable);

        return $this->content;
        //$this->content->footer = 'Footer here...';
     
        //return $this->content;
    }

    /**
     * Locations where block can be displayed.
     *
     * @return array
     */
    public function applicable_formats() {
        return array(
            "my" => true,
        );
    }
    
}