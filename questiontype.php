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
 * The questiontype class for the Opaque question type.
 *
 * @package   qtype_webwork_opaque
 * @copyright 2006 The Open University
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/question/type/webwork_opaque/enginemanager.php');


/**
 * The Opaque question type.
 *
 * @copyright 2006 The Open University
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class qtype_webwork_opaque extends question_type {
    /** @var qtype_webwork_opaque_engine_manager */
    protected $enginemanager;

    /** @var javascript_ready */
    protected $jsready;

    public function __construct() {
        parent::__construct();
        $this->enginemanager = qtype_webwork_opaque_engine_manager::get();
        $this->jsready = true;
    }

    /**
     * Set the engine manager to used. You should not need to call this except
     * when testing.
     * @param qtype_webwork_opaque_engine_manager $manager
     */
    public function set_engine_manager(qtype_webwork_opaque_engine_manager $manager) {
        $this->enginemanager = $manager;
    }

    public function can_analyse_responses() {
        return false;
    }

    public function extra_question_fields() {
        return array('qtype_webwork_opaque_options', 'engineid', 'remoteid', 'remoteversion', 'showhintafter', 'showsolutionafter', 'showsolutionaftertest', 'numattemptlock', 'exammode'); 
    }

    public function save_question($question, $form) {
        $form->questiontext = '';
        $form->questiontextformat = FORMAT_MOODLE;
        $form->unlimited = 0;
        $form->penalty = 0;
        return parent::save_question($question, $form);
    }

    protected function initialise_question_instance(question_definition $question, $questiondata) {
        global $PAGE;
        parent::initialise_question_instance($question, $questiondata);
        $question->engineid = $questiondata->options->engineid;
        $question->remoteid = $questiondata->options->remoteid;
        $question->remoteversion = $questiondata->options->remoteversion;
        $question->showhintafter = $questiondata->options->showhintafter;
        $question->showsolutionafter = $questiondata->options->showsolutionafter;
        $question->showsolutionaftertest = $questiondata->options->showsolutionaftertest;
        $question->numattemptlock = $questiondata->options->numattemptlock;
        $question->exammode = $questiondata->options->exammode;
        if ($this->jsready) {
            $this->jsready = false;
	 /*   $PAGE->requires->js_call_amd('qtype_webwork_opaque/jquery-nestable'); 
	    $PAGE->requires->js_call_amd('qtype_webwork_opaque/dragndrop'); */
            $PAGE->requires->js_call_amd('qtype_webwork_opaque/init_mathjax', 'init');
            $PAGE->requires->js_call_amd('qtype_webwork_opaque/knowl', 'init');
	    $PAGE->requires->js_call_amd('qtype_webwork_opaque/mv_locale_fr', 'init');
	    $PAGE->requires->js_call_amd('qtype_webwork_opaque/mathview', 'init');
	    $PAGE->requires->js('/question/type/webwork_opaque/amd/src/jquery-3.6.4.min.js', true);
	/*    $PAGE->requires->js('/question/type/webwork_opaque/amd/src/bootstrap.bundle.js', true); */
	    $PAGE->requires->js('/question/type/webwork_opaque/amd/src/jsxgraphcore.js', true);
	    $PAGE->requires->js('/question/type/webwork_opaque/amd/src/GraphTool/graphtool.js', true); 
	    $PAGE->requires->js('/question/type/webwork_opaque/amd/src/GraphTool/cubictool.js', true);  
	    $PAGE->requires->js('/question/type/webwork_opaque/amd/src/GraphTool/pointtool.js', true);
	    $PAGE->requires->js('/question/type/webwork_opaque/amd/src/GraphTool/quadratictool.js', true); 
        }
    }

    public function get_random_guess_score($questiondata) {
        return null;
    }

    public function export_to_xml($question, qformat_xml $format, $extra = null) {
        $expout = '';
        $expout .= '    <remoteid>' . $question->options->remoteid . "</remoteid>\n";
        $expout .= '    <remoteversion>' . $question->options->remoteversion . "</remoteversion>\n";
        $expout .= '    <showhintafter>' . $question->options->showhintafter . "</showhintafter>\n";
        $expout .= '    <showsolutionafter>' . $question->options->showsolutionafter . "</showsolutionafter>\n";
        $expout .= '    <showsolutionaftertest>' . $question->options->showsolutionaftertest . "</showsolutionaftertest>\n";
        $expout .= '    <numattemptlock>' . $question->options->numattemptlock . "</numattemptlock>\n";
        $expout .= '    <exammode>' . $question->options->exammode . "</exammode>\n"; 
        $expout .= "    <engine>\n";
        $engine = $this->enginemanager->load($question->options->engineid);
        $expout .= "      <name>\n" . $format->writetext($engine->name, 4) . "      </name>\n";
        $expout .= "      <passkey>\n" . $format->writetext($engine->passkey, 4) .
                "      </passkey>\n";
        $expout .= "      <timeout>" . $engine->timeout . "</timeout>\n";
        foreach ($engine->questionengines as $qe) {
            $expout .= "      <qe>\n" . $format->writetext($qe, 4) . "      </qe>\n";
        }
        foreach ($engine->questionbanks as $qb) {
            $expout .= "      <qb>\n" . $format->writetext($qb, 4) . "      </qb>\n";
        }
        $expout .= "    </engine>\n";
        return $expout;
    }

    public function import_from_xml($data, $question, qformat_xml $format, $extra = null) {
        if (!isset($data['@']['type']) || $data['@']['type'] != 'webwork_opaque') {
            return false;
        }

        $question = $format->import_headers($data);
        $question->qtype = 'webwork_opaque';
        $question->remoteid = $format->getpath($data, array('#', 'remoteid', 0, '#'),
                '', false, get_string('missingremoteidinimport', 'qtype_webwork_opaque')); 
        $question->remoteversion = $format->getpath($data, array('#', 'remoteversion', 0, '#'),
                '', false, get_string('missingremoteversioninimport', 'qtype_webwork_opaque'));
        $question->showhintafter = $format->getpath($data, array('#', 'showhintafter', 0, '#'),
                '', false, get_string('missingshowhintafterinimport', 'qtype_webwork_opaque'));
        $question->showsolutionafter = $format->getpath($data, array('#', 'showsolutionafter', 0, '#'),
                '', false, get_string('missingshowsolutionafterinimport', 'qtype_webwork_opaque'));
        $question->showsolutionaftertest = $format->getpath($data, array('#', 'showsolutionaftertest', 0, '#'),
                '', false, get_string('missingshowsolutionaftertestinimport', 'qtype_webwork_opaque'));
        $question->numattemptlock = $format->getpath($data, array('#', 'numattemptlock', 0, '#'),
                '', false, get_string('missingnumattemptlockinimport', 'qtype_webwork_opaque'));
        $question->exammode = $format->getpath($data, array('#', 'exammode', 0, '#'),
                '', false, get_string('missingexammodeinimport', 'qtype_webwork_opaque')); 

        // Engine bit.
        $strerror = get_string('missingenginedetailsinimport', 'qtype_webwork_opaque');
        if (!isset($data['#']['engine'][0])) {
             $format->error($strerror);
        }
        $enginedata = $data['#']['engine'][0];
        $engine = new stdClass();
        $engine->name = $format->import_text($enginedata['#']['name'][0]['#']['text']);
        $engine->passkey = $format->import_text($enginedata['#']['passkey'][0]['#']['text']);
        $engine->timeout = $format->getpath($enginedata, array('#', 'timeout', 0, '#'), null);
        if (empty($engine->timeout)) {
            unset($engine->timeout); // So that we use the default defined in the DB.
        }
        $engine->questionengines = array();
        $engine->questionbanks = array();
        if (isset($enginedata['#']['qe'])) {
            foreach ($enginedata['#']['qe'] as $qedata) {
                $engine->questionengines[] = $format->import_text($qedata['#']['text']);
            }
        }
        if (isset($enginedata['#']['qb'])) {
            foreach ($enginedata['#']['qb'] as $qbdata) {
                $engine->questionbanks[] = $format->import_text($qbdata['#']['text']);
            }
        }
        $question->engineid = $this->enginemanager->find_or_create($engine);
        return $question;
    }
}
