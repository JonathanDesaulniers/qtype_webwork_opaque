# Change log for the The Opaque question type

## Change in V1.1.1

*Plugin is now working only with WeBWorK 2.17+
*Added MathView editor to WeBWorK problem
*Added use of graphtool problem
*Fix error with UTF8 with solution in moodle feedback

## Changes in V1.0.0

* Name of plugin is changed to strictly be used with WeBWorK and not interfer with qtype_opaque
* Added compatibility with Moodle 3.11 + and Moodle 4.0+

## Changes in R13-V1.13.3

* Added question config form for max number of attempt before read only

## Changes in R13-V1.13.2

* Added french canadien language to lang files
* Edited opaque form to add num of attempt before showing hint, num of attempt before showing solution and/or locking problem, 
* select for showing solution as feedback afer test and select for putting question in exam mode (no correct ans in attempt table).
* Modification to style to adjust rendering of question

## Changes in 2.8

* Change to prevent Moodle styles interfering with OpenMark questions.
* Fix automated tests to work with Moodle 3.8.


## Changes in 2.7

* Fix automated tests to work with Moodle 3.6.


## Changes in 2.6

* Privacy API implementation.
* Update to use the newer editor_ousupsub, instead of editor_supsub.
* Fix a keyboard focus issue after and OpenMark question is submitted.
* Fix a styling clash with Moodle themes and OpenMark.
* Allow self-signed certificates when connecting to the rempte question engine over HTTPS.
* Setup Travis-CI automated testing integration.
* Fix some automated tests to pass with newer versions of Moodle.
* Fix some coding style.
* Due to privacy API support, this version now only works in Moodle 3.4+
  For older Moodles, you will need to use a previous version of this plugin.


## 2.5 and before

Changes were not documented here.
