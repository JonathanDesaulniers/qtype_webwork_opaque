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
 * Opaque question renderer class.
 *
 * @package   qtype_webwork_opaque
 * @copyright 2009 The Open University
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once($CFG->dirroot . '/question/behaviour/webwork_opaque/opaquestate.php');


/**
 * Generates the output for Opaque questions.
 *
 * @copyright 2009 The Open University
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class qtype_webwork_opaque_renderer extends qtype_renderer {
	
	protected function general_feedback(question_attempt $qa) {
		$opaquestate = new qbehaviour_webwork_opaque_state($qa, null);
		
		if (!empty($opaquestate->get_solfeedback()) && !empty($opaquestate->get_correctanstable())){
			$sol = $opaquestate->get_solfeedback();
		    $doc = new DOMDocument();
			$doc->loadHTML('<?xml version="1.0" encoding="UTF-8"?>' . "\n" . $sol);
			$xpath = new DOMXPath($doc);
			$tags = $xpath->query('.//a');
			$result = "";
			foreach($tags as $node) {
				$domDocument = new DOMDocument();
				$b = $domDocument->importNode($node->cloneNode(true), true);
				$domDocument->appendChild($b);
				$result .= $domDocument->saveHtml($dom->documentElement);
			
			}
			$table = $opaquestate->get_correctanstable();
			$table .= $result;
			
			return $table;
		}

		if (!empty($opaquestate->get_solfeedback()) && empty($opaquestate->get_correctanstable())){
			$sol = $opaquestate->get_solfeedback();
		    $doc = new DOMDocument();
			$doc->loadHTML('<?xml version="1.0" encoding="UTF-8"?>' . "\n" . $sol);
			$xpath = new DOMXPath($doc);
			$tags = $xpath->query('.//a');
			$result = "";
			foreach($tags as $node) {
				$domDocument = new DOMDocument();
				$b = $domDocument->importNode($node->cloneNode(true), true);
				$domDocument->appendChild($b);
				$result .= $domDocument->saveHtml($dom->documentElement);
			}
			return $result;
		}
		
		if (empty($opaquestate->get_solfeedback()) && !empty($opaquestate->get_correctanstable())){
			$table = $opaquestate->get_correctanstable();
			return $table;
		}
    
	
	}
}
