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
							<li><a class="current" href="ping.php">Ping</a></li>
							<li><a href="help.php">Help</a></li>
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

				<!-- Form panel. -->
				<div class="panel">
					<form class="form-inline" data-bind="submit: call">
						<div class="checkbox" data-bind="visible: modifiers.request.visible">
							<label>
								<input type="checkbox" data-bind="checked: modifiers.request.checked"> Copy request&nbsp;
							</label>
						</div>
						<div class="checkbox" data-bind="visible: modifiers.connection.visible">
							<label>
								<input type="checkbox" data-bind="checked: modifiers.connection.checked"> Copy connection&nbsp;
							</label>
						</div>
						<div class="checkbox" data-bind="visible: modifiers.range.visible">
							<label>
								<input type="checkbox" data-bind="checked: modifiers.range.checked"> Results range&nbsp;
							</label>
						</div>
						<div class="checkbox" data-bind="visible: modifiers.count.visible">
							<label>
								<input type="checkbox" data-bind="checked: modifiers.count.checked"> Results count&nbsp;
							</label>
						</div>
						<button type="submit" class="btn btn-primary" data-bind="disable: button.disabled()">
							Try
						</button>
					</form>
				</div>

				<!-- Request. -->
				<pre class="pre-scrollable" style="white-space: nowrap" data-bind="text: url"></pre>

				<!-- Response. -->
				<label class="radio-inline">
					<input type="radio" name="format" value="json" data-bind="checked: response.format">JSON
				</label>
				<label class="radio-inline">
					<input type="radio" name="format" value="object" data-bind="checked: response.format">Object
				</label>

				<!-- JSON. -->
				<pre class="pre-scrollable" data-bind="text: response.string(), visible: response.received() && (response.format() == 'json')"></pre>

				<!-- Object. -->
				<div class="panel" data-bind="visible: response.received() && (response.format() == 'object')">

					<!-- Status. -->
					<div data-bind="visible: hasStatus">
						<div class="panel-heading">
							<b>Status</b>
						</div>
						<dl class="dl-horizontal">
							<dt>State:</dt>
							<dd data-bind="text: statusState"></dd>
							<dt data-bind="visible: hasStatusMessage">Message:</dt>
							<dd data-bind="text: statusMessage, visible: hasStatusMessage"></dd>
							<dt data-bind="visible: hasStatusTotal">Affected count:</dt>
							<dd data-bind="text: statusTotal, visible: hasStatusTotal"></dd>
							<dt data-bind="visible: hasStatusCount">Actual count:</dt>
							<dd data-bind="text: statusCount, visible: hasStatusCount"></dd>
							<dt data-bind="visible: hasStatusStart">Start:</dt>
							<dd data-bind="text: statusStart, visible: hasStatusStart"></dd>
							<dt data-bind="visible: hasStatusLimit">Limit:</dt>
							<dd data-bind="text: statusLimit, visible: hasStatusLimit"></dd>
						</dl>
					</div>
				</div>
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
<!-- Set base stuff. -->
<script type="text/javascript">
	var baseURL = "<?php echo( kURL ); ?>";
	var baseCMD = "ping";
</script>
<!-- Include my.js -->
<script src="js/myBindings.js"></script>
<!-- Set defaults. -->
<script type="text/javascript">
	myModel.modifiers.request.visible(true);
	myModel.modifiers.connection.visible(true);
	myModel.modifiers.range.visible(false);
	myModel.modifiers.count.visible(false);
</script>
</body>
</html>
