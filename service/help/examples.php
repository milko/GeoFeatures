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
    <title>GeoFeatures documentation - Examples</title>
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
					        <a class="current" href="examples.php">Examples <span class="label label-warning">under construction</span></a>
					        <ul>
						        <li><a href="ping.php">Ping</a></li>
						        <li><a href="help.php">Help</a></li>
						        <li><a href="tiles.php">Tiles</a></li>
					        </ul>
				        </li>
			        </ul>
		        </div>
	        </div>

	        <!-- CONTENTS CONTAINER -->
	        <div class="col-lg-8">

		        <!-- PING -->
		        <section id="intro">
			        <h4>
				        Interactive examples
			        </h4>
			        <p>
				        From the list on the left you can choose some interactive examples
				        that will allow you to test the service.
			        </p>
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
</body>
</html>

