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
 * Version information for the Opaque question type.
 *
 * @package   qtype_webwork_opaque
 * @copyright 2006 The Open University
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

//defined('MOODLE_INTERNAL') || die();

$plugin->version   = 2023072001;
$plugin->requires  = 2021051700;
$plugin->component = 'qtype_webwork_opaque';
$plugin->maturity  = MATURITY_BETA;
$plugin->release   = '1.1.1-beta';

$plugin->dependencies = array(
    'qbehaviour_webwork_opaque' => 2023010100,
);
$plugin->supported = [311, 400, 410];      //  Moodle 3.11+ are supported.

// Only work with WeBWorK 2.17+

$plugin->outestssufficient = true;
