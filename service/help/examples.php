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
						        <li><a href="#ping">Ping</a></li>
					        </ul>
				        </li>
			        </ul>
		        </div>
	        </div>

	        <!-- CONTENTS CONTAINER -->
	        <div class="col-lg-8">

		        <!-- PING -->
		        <section id="ping">
			        <h4>
				        Ping request
			        </h4>
			        <p>
				        This operation can be used to check if the service is working, if
				        so, the response <a href="response.php#data"><abbr title="data">data</abbr></a>
				        section will contain the string <code>pong</code>.
			        </p>
			        <form class="form-inline" id="form-ping" data-bind="submit: pingCALL">
				        <div class="input-group">
					        <input type="text" class="form-control" id="ping-request" data-bind="value: pingRequest" />
					        <span class="input-group-btn">
								<button type="submit" data-loading-text="Calling..." class="btn btn-primary">
									Try
								</button>
						    </span>
				        </div>
			        </form>
			        <pre id="ping-response" class="pre-scrollable" data-bind="text: pingResponse"></pre>
		        </section>

		        <!-- HELP -->
		        <section id="ping">
			        <h4>
				        Help request
			        </h4>
			        <p>
				        If you are here you must have done it ;-) In any case you can try it again:
			        </p>
			        <form class="form-inline" id="form-help" data-bind="submit: helpCALL">
				        <div class="input-group">
					        <input type="text" class="form-control" id="help-request" data-bind="value: helpRequest" />
					        <span class="input-group-btn">
								<button type="submit" data-loading-text="Calling..." class="btn btn-primary">
									Try
								</button>
						    </span>
				        </div>
			        </form>
			        <pre id="help-response" class="pre-scrollable" data-bind="text: helpResponse"></pre>
		        </section>

		        <!-- TILES -->
		        <section id="ping">
			        <h4>
				        Tiles request
			        </h4>
			        <p>
				        This operation can be used to retrieve a list of tiles by identifier.
			        </p>
			        <form class="form-inline" id="form-tiles" data-bind="submit: tilesCALL">
				        <div class="input-group">
					        <input type="text" class="form-control" id="tiles-request" data-bind="value: tilesRequest" />
					        <span class="input-group-btn">
								<button type="submit" data-loading-text="Calling..." class="btn btn-primary">
									Try
								</button>
						    </span>
				        </div>
			        </form>
			        <pre id="tiles-response" class="pre-scrollable" data-bind="text: tilesResponse"></pre>
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
    </script>
    <!-- Include my.js -->
    <script src="js/myViewModels.js"></script>
</body>
</html>

