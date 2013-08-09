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
						<input type="checkbox" data-bind="checked: requestModCopyRequest"> Copy request</input>
						<input type="checkbox" data-bind="checked: requestModCopyConnection"> Copy connection</input>
						<input type="checkbox" data-bind="checked: requestModCount"> Results count</input>
						<input type="checkbox" data-bind="checked: requestModRange"> Results ranges</input>
						<div class="input-group">
							<input type="text" class="form-control" data-bind="value: geomTiles" />
							<span class="input-group-btn">
								<button type="submit" class="btn btn-primary">
									Try
								</button>
							</span>
						</div>
					</form>
				</div>

				<!-- Request. -->
				<pre class="pre-scrollable" style="white-space: nowrap" data-bind="text: request"></pre>

				<!-- Response. -->
				<div class="btn-group btn-group">
					<input type="radio" value="JSON" data-bind="checked: responseFormat" name="format"> JSON</input>
					<input type="radio" value="Object" data-bind="checked: responseFormat" name="format"> Object</input>
				</div>

				<!-- JSON. -->
				<pre class="pre-scrollable" data-bind="text: responseJSON, visible: responseAsJSON"></pre>

				<!-- Object. -->
				<div class="panel" data-bind="visible: responseAsObject">

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

					<!-- Request. -->
					<div data-bind="visible: hasRequest">
						<div class="panel-heading">
							<b>Request</b>
						</div>
						<dl class="dl-horizontal">
							<dt data-bind="visible: hasRequestOperation">Operation:</dt>
							<dd data-bind="text: requestOperation, visible: hasRequestOperation"></dd>
							<dt data-bind="visible: hasRequestModifiers">Modifiers:</dt>
							<dd data-bind="visible: hasRequestModifiers">
								<ul  data-bind="foreach: requestModifiers">
									<li>
										<span data-bind="text: $data"></span>
									</li>
								</ul>
							</dd>
							<dt data-bind="visible: hasRequestGeometry">Geometry type:</dt>
							<dd data-bind="text: requestGeometryType, visible: hasRequestGeometry"></dd>
							<dt data-bind="visible: hasRequestGeometry">Geometry coordinates:</dt>
							<dd data-bind="visible: hasRequestGeometry">
								<ul  data-bind="foreach: requestGeometryCoordinates">
									<li>
										<span data-bind="text: $data"></span>
									</li>
								</ul>
							</dd>
						</dl>
					</div>

					<!-- Connection. -->
					<div data-bind="visible: hasConnection">
						<div class="panel-heading">
							<b>Connection</b>
						</div>
						<dl class="dl-horizontal">
							<dt data-bind="visible: hasConnectionServer">Server:</dt>
							<dd data-bind="text: connectionServer, visible: hasConnectionServer"></dd>
							<dt data-bind="visible: hasConnectionDatabase">Database:</dt>
							<dd data-bind="text: connectionDatabase, visible: hasConnectionDatabase"></dd>
							<dt data-bind="visible: hasConnectionCollection">Collection:</dt>
							<dd data-bind="text: connectionCollection, visible: hasConnectionCollection"></dd>
						</dl>
					</div>

					<!-- Data. -->
					<div data-bind="visible: hasData">
						<div class="panel-heading">
							<b>Response</b>
						</div>
						<div data_bound="visible: requestModRange">
							<table class="table">
								<thead>
								<tr>
									<th>Month</th>
									<th>Precipitation</th>
									<th>Temperature</th>
								</tr>
								</thead>
								<tbody>
								<tr>
									<td>January</td>
									<td>120</td>
									<td>35</td>
								</tr>
								</tbody>
							</table>
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
<!-- Set base URL. -->
<script type="text/javascript">
	var baseURL = "<?php echo( kURL ); ?>";
	var baseCMD = "tiles";
	var baseTiles = "33065587,774896741";
</script>
<!-- Include my.js -->
<script src="js/myViewModels.js"></script>
</body>
</html>
