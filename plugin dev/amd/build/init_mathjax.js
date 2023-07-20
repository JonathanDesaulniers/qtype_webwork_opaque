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
 * Javascript change opaque question focus.
 *
 * @package   mod_quiz
 * @copyright 2017 The Open University
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @since     3.2
 */
define("qtype_webwork_opaque/init_mathjax", ["jquery"], function(a) {
    var b = {
        init: function init() {
            a(document).ready(function() {
                
                var check = $('script[type*="math/tex"]');
                if (check){
					
					let callback = function(){
						if (typeof MathJax == "undefined") {
							setTimeout(callback,500);
							console.log ("loading mathjax");
						}
						else {
							if (MathJax.startup == undefined) {
								MathJax.Hub.Queue(["Typeset",MathJax.Hub]);
							} else {
								
							}							
						}						
					};
					
					let callback2 = function(){
						if (typeof M.filter_mathjaxloader == "undefined") {
							setTimeout(callback2,500);
							console.log ("loading mathjax");
						}
						else {
							M.filter_mathjaxloader.typeset();
						}						
					};
					
                    setTimeout(callback, 500);
					setTimeout(callback2, 500);
                }
            })
        },
    };
    return b
});
