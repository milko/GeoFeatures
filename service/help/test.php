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

	<form data-bind="submit: addTask">
		URL: <input data-bind="value: request" />
		<button type="submit">Try</button>
	</form>

	<p data-bind="text: response"></p>

	<!-- JavaScript plugins (requires jQuery) -->
    <script src="http://code.jquery.com/jquery.js"></script>
    <!-- Include knockout.js -->
    <script src="js/knockout.js"></script>
    <!-- Set base URL. -->
    <script type="text/javascript">
        var baseURL = "<?php echo( kURL ); ?>";
    </script>
	
    <!-- My javascript -->
	<script type="text/javascript">
		// This is a simple *viewmodel* - JavaScript that defines the data and behavior of your UI
		function TaskListViewModel() {
			// Data
			var self = this;
			self.request = ko.observable(baseURL + "?ping");
			self.response = ko.observable();

			// Operations
			self.addTask = function() {
				$.get( self.request(), function(theData){
					self.response(theData);
				});
			};
		}

		ko.applyBindings(new TaskListViewModel());
	</script>
</body>
</html>