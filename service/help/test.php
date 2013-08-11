<?php

/*=======================================================================================
 *																						*
 *								        test.php	           							*
 *																						*
 *======================================================================================*/

/**
 *	Test page.
 *
 *	This file contains tests.
 *
 *	@package	WORLDCLIM30
 *	@subpackage	Services
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 08/08/2013
 */

/**
 * URL.
 *
 * This include file contains the web-service URL.
 */
require_once( "includes.inc.php" );

?>
<!DOCTYPE html>
<html>
<head>
    <title>Test page</title>
</head>
<body>

	<form class="form-inline" data-bind="submit: call">
		<input type="checkbox" data-bind="checked: modifiers().checkbox.request.checked"> Copy request</input>
		<input type="checkbox" data-bind="checked: modifiers().checkbox.connection.checked"> Copy connection</input>
		<input type="checkbox" data-bind="checked: modifiers().checkbox.range.checked"> Results ranges</input>
		<input type="checkbox" data-bind="checked: modifiers().checkbox.count.checked"> Results count</input>
		<button type="submit" class="btn btn-primary">
			Try
		</button>
	</form>
	<ul data-bind="foreach: testArray">
		<li>
			<span data-bind="text: $data"> </span>
		</li>
	</ul>

	<!-- JavaScript plugins (requires jQuery) -->
    <script src="http://code.jquery.com/jquery.js"></script>
    <!-- Include knockout.js -->
    <script src="js/knockout.js"></script>

    <!-- My javascript -->
	<script type="text/javascript">
		// This is a simple *viewmodel* - JavaScript that defines the data and behavior of your UI
		function TaskListViewModel() {
			// Reference.
			var self = this;

			self.testArray = ko.observableArray([ "uno", "due", "tre"]);

			self.call = function process() {
				self.testArray.push("pippo");
			}

			//
			// Modifiers.
			//
			self.modifiers = ko.observable( {
				"checkbox" : {
					"request" : {
						"visible" : false,
						"checked" : false
					},
					"connection" : {
						"visible" : false,
						"checked" : false
					},
					"range" : {
						"visible" : false,
						"checked" : false
					},
					"count" : {
						"visible" : false,
						"checked" : false
					}
				}
			});

		};

		var myModel = new TaskListViewModel()

		ko.applyBindings(myModel);
	</script>
</body>
</html>