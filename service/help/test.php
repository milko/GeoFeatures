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
		}

		var myModel = new TaskListViewModel()

		ko.applyBindings(myModel);
	</script>
</body>
</html>