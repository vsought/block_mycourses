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
 * Version details for the My overview block.
 *
 * @package    block_mycourses
 * @copyright
 * @author     Vinícius Augusto Cardoso Reis <vinaut.cr@gmail.com>
 * @license
 */


defined('MOODLE_INTERNAL') || die();

$plugin->version = 20221015;
$plugin->requires = 2022041900; //// Require Moodle 4.0.0
//$plugin->supported = TODO;   // Available as of Moodle 3.9.0 or later.
//$plugin->incompatible = TODO;   // Available as of Moodle 3.9.0 or later.
$plugin->component = 'block_mycourses';
$plugin->maturity = MATURITY_ALPHA;
//$plugin->release = 'TODO';

/*$plugin->dependencies = [
    'mod_forum' => 2022042100,
    'mod_data' => 2022042100
];*/