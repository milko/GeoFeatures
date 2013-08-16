<?php

	/*=======================================================================================
	 *																						*
	 *								    examples.php	           							*
	 *																						*
	 *======================================================================================*/

	/**
	 *	Response web-service examples page.
	 *
	 *	This file contains the examples page for the response of the web-service.
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
	<title>GeoFeatures documentation - Examples - ping</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- Bootstrap -->
	<link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link href="css/my.css" rel="stylesheet" media="screen">
</head>
<body>
<!-- HEADER -->
<div class="container">
	<div class="page-header">
		<h1>GeoFeatures<br/><small>web-service documentation</small></h1>
	</div>
</div>

<!-- MAIN CONTAINER -->
<div class="container bs-docs-container">
	<div class="row">

		<!-- NAVIGATION SIDE BAR CONTAINER -->
		<div class="col-lg-4">
			<div id="sidebar"
			     data-spy="affix"
			     class="bs-sidebar"
			     data-offset-top="100">
				<ul class="nav bs-sidenav affix">
					<li>
						<a href="help.html">Introduction</a>
					</li>
					<li>
						<a href="response.php">Response data structure</a>
					</li>
					<li>
						<a href="request.php">Request data structure</a>
					</li>
					<li>
						<a href="examples.php">Examples <span class="label label-warning">under construction</span></a>
						<ul>
							<li><a href="ping.php">Ping</a></li>
							<li><a href="help.php" class="current">Help</a></li>
							<li><a href="tiles.php">Tiles</a></li>
							<li><a href="contains.php">Contains</a></li>
							<li><a href="intersects.php">Intersects</a></li>
							<li><a href="near.php">Near</a></li>
						</ul>
					</li>
				</ul>
			</div>
		</div>

		<!-- CONTENTS CONTAINER -->
		<div class="col-lg-8">

			<!-- PING -->
			<section id="ping">
				<h4>Help request <small>[<strong><code>help</code></strong>]</small></h4>
				<p>
					If you got to this page you must have already tested it ;-)
				</p>
				<p>
					Copy the link below in your browser and try.
				</p>

				<!-- Request. -->
				<pre style="white-space: nowrap" data-bind="text: url"></pre>
			</section>
		</div>
	</div>
</div>

<!-- JavaScript plugins (requires jQuery) -->
<script src="http://code.jquery.com/jquery.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>
<!-- Include knockout.js -->
<script src="js/knockout.js"></script>
<!-- Set base URL. -->
<script type="text/javascript">
	var baseURL = "<?php echo( kURL ); ?>";
	var baseCMD = "help";
</script>
<!-- Include my.js -->
<script src="js/ViewModel.js"></script>
<!-- Set defaults. -->
<script type="text/javascript">
	myModel.modifiers.request.visible(false);
	myModel.modifiers.connection.visible(false);
	myModel.modifiers.range.visible(false);
	myModel.modifiers.count.visible(false);
</script>
</body>
</html>
