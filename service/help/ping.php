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
				<pre class="pre-scrollable" data-bind="text: response.string(), visible: asJson"></pre>

				<!-- Object. -->
				<div class="panel" data-bind="visible: asObject">

					<!-- Status. -->
					<div data-bind="visible: response.status.received">
						<h4 class="text-info">Status</h4>
						<table class="table table-condensed">
							<tr data-bind="visible: response.status.state.received, css: response.status.state.style">
								<th>State:</th>
								<td data-bind="text: response.status.state.data"></td>
							</tr>
							<tr data-bind="visible: response.status.message.received">
								<th>Message:</th>
								<td data-bind="text: response.status.message.data"></td>
							</tr>
							<tr data-bind="visible: response.status.total.received">
								<th>Affected count:</th>
								<td data-bind="text: response.status.total.data"></td>
							</tr>
						</table>
					</div>

					<!-- Request. -->
					<div data-bind="visible: response.request.received">
						<h4 class="text-info">Request</h4>
						<table class="table table-condensed">
							<tr data-bind="visible: response.request.operation.received">
								<th>Operation:</th>
								<td data-bind="text: response.request.operation.data"></td>
							</tr>
							<tr data-bind="visible: response.request.modifiers.received">
								<th>Modifiers:</th>
								<td data-bind="text: response.request.modifiers.data"></td>
							</tr>
							<tr data-bind="visible: response.request.geometry.received">
								<th>Geometry:</th>
								<td>
									<table class="table table-condensed">
										<tr data-bind="visible: response.request.geometry.type().length > 0">
											<th>Type:</th>
											<td data-bind="text: response.request.geometry.type"></td>
										</tr>
										<tr data-bind="visible: response.request.geometry.coordinates().length > 0">
											<th>Coordinates:</th>
											<td data-bind="text: response.request.geometry.coordinates"></td>
										</tr>
										<tr data-bind="visible: response.request.geometry.area().length > 0">
											<th>Area:</th>
											<td data-bind="text: response.request.geometry.area"></td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</div>

					<!-- Connection. -->
					<div data-bind="visible: response.connection.received">
						<h4 class="text-info">Connection</h4>
						<table class="table table-condensed">
							<tr data-bind="visible: response.connection.server.received">
								<th>Server:</th>
								<td data-bind="text: response.connection.server.data"></td>
							</tr>
							<tr data-bind="visible: response.connection.database.received">
								<th>Database:</th>
								<td data-bind="text: response.connection.database.data"></td>
							</tr>
							<tr data-bind="visible: response.connection.collection.received">
								<th>Collection:</th>
								<td data-bind="text: response.connection.collection.data"></td>
							</tr>
						</table>
					</div>

					<!-- Data. -->
					<div data-bind="visible: response.data.received">
						<h4 class="text-info">Response</h4>
						<div data-bind="visible: response.data.string().length > 0">
							<span data-bind="text: response.data.string"></span>
						</div>
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
<script src="js/ViewModel.js"></script>
<!-- Set defaults. -->
<script type="text/javascript">
	myModel.modifiers.request.visible(true);
	myModel.modifiers.connection.visible(true);
	myModel.modifiers.range.visible(false);
	myModel.modifiers.count.visible(false);
</script>
</body>
</html>
