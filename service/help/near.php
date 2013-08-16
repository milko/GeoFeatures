<?php

/*=======================================================================================
 *																						*
 *								        near.php	           							*
 *																						*
 *======================================================================================*/

/**
 *	Response web-service near examples page.
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
	<title>GeoFeatures documentation - Examples - Near</title>

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- Bootstrap -->
	<link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
	<!-- Local -->
	<link href="css/my.css" rel="stylesheet" media="screen">
</head>
<body data-spy="scroll" data-target="#sidebar">
	<!-- HEADER -->
	<div class="container">
		<div class="page-header">
			<h1>GeoFeatures<br/><small>web-service documentation</small></h1>
		</div>
	</div>

	<!-- MAIN CONTAINER -->
	<div class="container">
	<div class="row">

	<!-- NAVIGATION SIDE BAR CONTAINER -->
	<div class="col-lg-4">
		<div id="sidebar" class="side-bar affix-top" data-spy="affix" data-offset-top="100">
			<ul class="nav side-nav">
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
					<a href="examples.php">Examples</a>
					<ul class="nav">
						<li><a href="ping.php">Ping</a></li>
						<li><a href="help.php">Help</a></li>
						<li><a href="tiles.php">Tiles</a></li>
						<li><a href="contains.php">Contains</a></li>
						<li><a href="intersects.php">Intersects</a></li>
						<li><a href="#near" class="current">Near</a></li>
					</ul>
				</li>
			</ul>
		</div>
	</div>

	<!-- CONTENTS CONTAINER -->
	<div class="col-lg-8">

	<!-- NEAR -->
	<section id="near">
	<h4>Near <small>[<strong><code>near</code></strong>]</small></h4>
	<p>
		This operation can be used to retrieve tiles by proximity, the service will return
		at most 100 tiles sorted by distance from the provided point.
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
			<div class="input-group" data-bind="if: geometry.type() == 'point'">
				<span class="input-group-addon">Point:</span>
				<input type="text" class="form-control" data-bind="value: geometry.point.coordinates" />
								<span class="input-group-btn">
									<button type="submit" class="btn btn-primary" data-bind="disable: button.disabled">
										Try
									</button>
								</span>
			</div>
			<div class="input-group">
				<span class="input-group-addon">Min elevation::</span>
				<input type="text" class="form-control" data-bind="value: elevation.min" />
				<span class="input-group-addon">Max elevation:</span>
				<input type="text" class="form-control" data-bind="value: elevation.max" />
				<span class="input-group-addon">Max distance:</span>
				<input type="text" class="form-control" data-bind="value: distance" />
			</div>
			<div class="input-group">
				<span class="input-group-addon">Start:</span>
				<input type="text" class="form-control" data-bind="value: paging.start" />
				<span class="input-group-addon">Limit:</span>
				<input type="text" class="form-control" data-bind="value: paging.limit" />
			</div>
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
			<tr data-bind="visible: response.status.count.received">
				<th>Actual count:</th>
				<td data-bind="text: response.status.count.data"></td>
			</tr>
			<tr data-bind="visible: response.status.start.received">
				<th>Page start:</th>
				<td data-bind="text: response.status.start.data"></td>
			</tr>
			<tr data-bind="visible: response.status.limit.received">
				<th>Page limit:</th>
				<td data-bind="text: response.status.limit.data"></td>
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
			<tr data-bind="visible: response.request.elevation.received">
				<th>Elevation:</th>
				<td data-bind="text: response.request.elevation.range"></td>
			</tr>
			<tr data-bind="visible: response.request.distance.received">
				<th>Maximum distance:</th>
				<td data-bind="text: response.request.distance.value"></td>
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
	<!-- Tiles list. -->
	<table data-bind="visible: modifiers.range.sent() == false">
		<tbody data-bind="foreach: response.data.array">
		<tr>
			<td>
				<div class="accordion" id="records">
					<div class="accordion-group">
						<div class="accordion-heading">
							<a class="accordion-toggle" data-toggle="collapse" data-parent="#records" data-bind="attr: {href: href}">
								<span data-bind="text: name"></span>
							</a>
						</div>
						<div class="accordion-body collapse" data-bind="attr: {id: id}">
							<div class="accordion-inner">
								<table>
									<tr data-bind="visible: data._id.received">
										<th>Identifier: </th>
										<td data-bind="text: data._id.data"></td>
									</tr>
									<tr data-bind="visible: data.pt.received">
										<th>Tile center (dec): </th>
										<td data-bind="text: data.pt.data"></td>
									</tr>
									<tr data-bind="visible: data.dms.received">
										<th>Tile center (dms): </th>
										<td data-bind="text: data.dms.data"></td>
									</tr>
									<tr data-bind="visible: data.tile.received">
										<th>Tile coordinates: </th>
										<td data-bind="text: data.tile.data"></td>
									</tr>
									<tr data-bind="visible: data.bdec.received">
										<th>Bounding box (dec): </th>
										<td data-bind="text: data.bdec.data"></td>
									</tr>
									<tr data-bind="visible: data.bdms.received">
										<th>Bounding box (dms): </th>
										<td data-bind="text: data.bdms.data"></td>
									</tr>
									<tr data-bind="visible: data.elev.received">
										<th>Elevation: </th>
										<td data-bind="text: data.elev.data"></td>
									</tr>
									<tr data-bind="visible: data.dist.received">
										<th>Distance: </th>
										<td data-bind="text: data.dist.data"></td>
									</tr>
									<tr data-bind="visible: data.gens.received">
										<th>Global environment stratification: </th>
										<td data-bind="text: data.gens.data.id"></td>
									</tr>
									<tr data-bind="visible: data.gens.received">
										<th>Climatic zone: </th>
										<td data-bind="text: data.gens.data.c"></td>
									</tr>
									<tr data-bind="visible: data.gens.received">
										<th>Environmental zone: </th>
										<td data-bind="text: data.gens.data.e"></td>
									</tr>
									<tr data-bind="visible: data.bio.received">
										<th>Annual Mean Temperature: </th>
										<td data-bind="text: data.bio.data[1] / 10"></td>
									</tr>
									<tr data-bind="visible: data.bio.received">
										<th>Mean Diurnal Range: </th>
										<td data-bind="text: data.bio.data[2] / 10"></td>
									</tr>
									<tr data-bind="visible: data.bio.received">
										<th>Isothermality: </th>
										<td data-bind="text: data.bio.data[3]"></td>
									</tr>
									<tr data-bind="visible: data.bio.received">
										<th>Temperature Seasonality: </th>
										<td data-bind="text: data.bio.data[4]"></td>
									</tr>
									<tr data-bind="visible: data.bio.received">
										<th>Max Temperature of Warmest Month: </th>
										<td data-bind="text: data.bio.data[5] / 10"></td>
									</tr>
									<tr data-bind="visible: data.bio.received">
										<th>Min Temperature of Coldest Month: </th>
										<td data-bind="text: data.bio.data[6] / 10"></td>
									</tr>
									<tr data-bind="visible: data.bio.received">
										<th>Temperature Annual Range: </th>
										<td data-bind="text: data.bio.data[7] / 10"></td>
									</tr>
									<tr data-bind="visible: data.bio.received">
										<th>Mean Temperature of Wettest Quarter: </th>
										<td data-bind="text: data.bio.data[8] / 10"></td>
									</tr>
									<tr data-bind="visible: data.bio.received">
										<th>Mean Temperature of Driest Quarter: </th>
										<td data-bind="text: data.bio.data[9] / 10"></td>
									</tr>
									<tr data-bind="visible: data.bio.received">
										<th>Mean Temperature of Warmest Quarter: </th>
										<td data-bind="text: data.bio.data[10] / 10"></td>
									</tr>
									<tr data-bind="visible: data.bio.received">
										<th>Mean Temperature of Coldest Quarter: </th>
										<td data-bind="text: data.bio.data[11] / 10"></td>
									</tr>
									<tr data-bind="visible: data.bio.received">
										<th>Annual Precipitation: </th>
										<td data-bind="text: data.bio.data[12]"></td>
									</tr>
									<tr data-bind="visible: data.bio.received">
										<th>Precipitation of Wettest Month: </th>
										<td data-bind="text: data.bio.data[13]"></td>
									</tr>
									<tr data-bind="visible: data.bio.received">
										<th>Precipitation of Driest Month: </th>
										<td data-bind="text: data.bio.data[14]"></td>
									</tr>
									<tr data-bind="visible: data.bio.received">
										<th>Precipitation Seasonality: </th>
										<td data-bind="text: data.bio.data[15]"></td>
									</tr>
									<tr data-bind="visible: data.bio.received">
										<th>Precipitation of Wettest Quarter: </th>
										<td data-bind="text: data.bio.data[16]"></td>
									</tr>
									<tr data-bind="visible: data.bio.received">
										<th>Precipitation of Driest Quarter: </th>
										<td data-bind="text: data.bio.data[17]"></td>
									</tr>
									<tr data-bind="visible: data.bio.received">
										<th>Precipitation of Warmest Quarter: </th>
										<td data-bind="text: data.bio.data[18]"></td>
									</tr>
									<tr data-bind="visible: data.bio.received">
										<th>Precipitation of Coldest Quarter: </th>
										<td data-bind="text: data.bio.data[19]"></td>
									</tr>
								</table>
								<hr />
								<table width=100%>
									<thead>
									<tr>
										<th></th>
										<th>Precipitation</th>
										<th>Min. temp</th>
										<th>Mean temp.</th>
										<th>Max temp.</th>
									</tr>
									</thead>
									<tbody data-bind="foreach: $root.monthIndexes">
									<tr>
										<th data-bind="text: $root.monthNames[$data]"></th>
										<td data-bind="text: $parent.data.prec.data[$data]"></td>
										<td data-bind="text: $parent.data.temp.data.l[$data] / 10"></td>
										<td data-bind="text: $parent.data.temp.data.m[$data] / 10"></td>
										<td data-bind="text: $parent.data.temp.data.h[$data] / 10"></td>
									</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</td>
		</tr>
		</tbody>
	</table>
	<!-- Tiles ranges. -->
	<div data-bind="if: modifiers.range.sent() == true">
	<table data-bind="if: typeof(response.data.range().elev) != 'undefined'" width=100%>
		<tr>
			<th width=40%></th>
			<th width=20%>Minimum</th>
			<th width=20%>Mean</th>
			<th width=20%>Maximum</th>
		</tr>
		<tr>
			<th>Elevation: </th>
			<td data-bind="text: response.data.range().elev.l"></td>
			<td data-bind="text: response.data.range().elev.m"></td>
			<td data-bind="text: response.data.range().elev.h"></td>
		</tr>
		<tr data-bind="if: typeof(response.data.range().dist) != 'undefined'">
			<th>Distance: </th>
			<td data-bind="text: response.data.range().dist.l"></td>
			<td data-bind="text: Math.round(response.data.range().dist.m*100)/100"></td>
			<td data-bind="text: response.data.range().dist.h"></td>
		</tr>
	</table>
	<div data-bind="if: typeof(response.data.range().clim) != 'undefined'">
		<table data-bind="if: typeof(response.data.range().clim['2000'].gens) != 'undefined'" width=100%>
			<tr>
				<th width=40%></th>
				<th width=20%>Identifiers</th>
				<th width=20%>Climatic zones</th>
				<th width=20%>Environmental zones</th>
			</tr>
			<tr>
				<th>Global environment stratification: </th>
				<td data-bind="text: response.data.range().clim['2000'].gens.id"></td>
				<td data-bind="text: response.data.range().clim['2000'].gens.c"></td>
				<td data-bind="text: response.data.range().clim['2000'].gens.e"></td>
			</tr>
		</table>
		<table data-bind="if: typeof(response.data.range().clim['2000'].bio) != 'undefined'" width=100%>
			<tr>
				<th width=40%></th>
				<th width=20%>Minimum</th>
				<th width=20%>Mean</th>
				<th width=20%>Maximum</th>
			</tr>
			<tr data-bind="if: typeof(response.data.range().clim['2000'].bio['1']) != 'undefined'">
				<th>Annual Mean Temperature: </th>
				<td data-bind="text: response.data.range().clim['2000'].bio['1'].l / 10"></td>
				<td data-bind="text: Math.round((response.data.range().clim['2000'].bio['1'].m / 10)*100)/100"></td>
				<td data-bind="text: response.data.range().clim['2000'].bio['1'].h / 10"></td>
			</tr>
			<tr data-bind="if: typeof(response.data.range().clim['2000'].bio['2']) != 'undefined'">
				<th>Mean Diurnal Range: </th>
				<td data-bind="text: response.data.range().clim['2000'].bio['2'].l / 10"></td>
				<td data-bind="text: Math.round((response.data.range().clim['2000'].bio['2'].m / 10)*100)/100"></td>
				<td data-bind="text: response.data.range().clim['2000'].bio['2'].h / 10"></td>
			</tr>
			<tr data-bind="if: typeof(response.data.range().clim['2000'].bio['3']) != 'undefined'">
				<th>Isothermality: </th>
				<td data-bind="text: response.data.range().clim['2000'].bio['3'].l / 100"></td>
				<td data-bind="text: Math.round((response.data.range().clim['2000'].bio['3'].m / 100)*100)/100"></td>
				<td data-bind="text: response.data.range().clim['2000'].bio['3'].h / 100"></td>
			</tr>
			<tr data-bind="if: typeof(response.data.range().clim['2000'].bio['4']) != 'undefined'">
				<th>Temperature Seasonality: </th>
				<td data-bind="text: response.data.range().clim['2000'].bio['4'].l / 100"></td>
				<td data-bind="text: Math.round((response.data.range().clim['2000'].bio['4'].m / 100)*100)/100"></td>
				<td data-bind="text: response.data.range().clim['2000'].bio['4'].h / 100"></td>
			</tr>
			<tr data-bind="if: typeof(response.data.range().clim['2000'].bio['5']) != 'undefined'">
				<th>Max Temperature of Warmest Month: </th>
				<td data-bind="text: response.data.range().clim['2000'].bio['5'].l / 10"></td>
				<td data-bind="text: Math.round((response.data.range().clim['2000'].bio['5'].m / 10)*100)/100"></td>
				<td data-bind="text: response.data.range().clim['2000'].bio['5'].h / 10"></td>
			</tr>
			<tr data-bind="if: typeof(response.data.range().clim['2000'].bio['6']) != 'undefined'">
				<th>Min Temperature of Coldest Month: </th>
				<td data-bind="text: response.data.range().clim['2000'].bio['6'].l / 10"></td>
				<td data-bind="text: Math.round((response.data.range().clim['2000'].bio['6'].m / 10)*100)/100"></td>
				<td data-bind="text: response.data.range().clim['2000'].bio['6'].h / 10"></td>
			</tr>
			<tr data-bind="if: typeof(response.data.range().clim['2000'].bio['7']) != 'undefined'">
				<th>Min Temperature Annual Range: </th>
				<td data-bind="text: response.data.range().clim['2000'].bio['7'].l / 10"></td>
				<td data-bind="text: Math.round((response.data.range().clim['2000'].bio['7'].m / 10)*100)/100"></td>
				<td data-bind="text: response.data.range().clim['2000'].bio['7'].h / 10"></td>
			</tr>
			<tr data-bind="if: typeof(response.data.range().clim['2000'].bio['7']) != 'undefined'">
				<th>Min Temperature Annual Range: </th>
				<td data-bind="text: response.data.range().clim['2000'].bio['7'].l / 10"></td>
				<td data-bind="text: Math.round((response.data.range().clim['2000'].bio['7'].m / 10)*100)/100"></td>
				<td data-bind="text: response.data.range().clim['2000'].bio['7'].h / 10"></td>
			</tr>
			<tr data-bind="if: typeof(response.data.range().clim['2000'].bio['8']) != 'undefined'">
				<th>Mean Temperature of Wettest Quarter: </th>
				<td data-bind="text: response.data.range().clim['2000'].bio['8'].l / 10"></td>
				<td data-bind="text: Math.round((response.data.range().clim['2000'].bio['8'].m / 10)*100)/100"></td>
				<td data-bind="text: response.data.range().clim['2000'].bio['8'].h / 10"></td>
			</tr>
			<tr data-bind="if: typeof(response.data.range().clim['2000'].bio['9']) != 'undefined'">
				<th>Mean Temperature of Driest Quarter: </th>
				<td data-bind="text: response.data.range().clim['2000'].bio['9'].l / 10"></td>
				<td data-bind="text: Math.round((response.data.range().clim['2000'].bio['9'].m / 10)*100)/100"></td>
				<td data-bind="text: response.data.range().clim['2000'].bio['9'].h / 10"></td>
			</tr>
			<tr data-bind="if: typeof(response.data.range().clim['2000'].bio['10']) != 'undefined'">
				<th>Mean Temperature of Warmest Quarter: </th>
				<td data-bind="text: response.data.range().clim['2000'].bio['10'].l / 10"></td>
				<td data-bind="text: Math.round((response.data.range().clim['2000'].bio['10'].m / 10)*100)/100"></td>
				<td data-bind="text: response.data.range().clim['2000'].bio['10'].h / 10"></td>
			</tr>
			<tr data-bind="if: typeof(response.data.range().clim['2000'].bio['11']) != 'undefined'">
				<th>Mean Mean Temperature of Coldest Quarter: </th>
				<td data-bind="text: response.data.range().clim['2000'].bio['11'].l / 10"></td>
				<td data-bind="text: Math.round((response.data.range().clim['2000'].bio['11'].m / 10)*100)/100"></td>
				<td data-bind="text: response.data.range().clim['2000'].bio['11'].h / 10"></td>
			</tr>
			<tr data-bind="if: typeof(response.data.range().clim['2000'].bio['12']) != 'undefined'">
				<th>Annual Precipitation: </th>
				<td data-bind="text: response.data.range().clim['2000'].bio['12'].l"></td>
				<td data-bind="text: Math.round(response.data.range().clim['2000'].bio['12'].m)"></td>
				<td data-bind="text: response.data.range().clim['2000'].bio['12'].h"></td>
			</tr>
			<tr data-bind="if: typeof(response.data.range().clim['2000'].bio['13']) != 'undefined'">
				<th>Precipitation of Wettest Month: </th>
				<td data-bind="text: response.data.range().clim['2000'].bio['13'].l"></td>
				<td data-bind="text: Math.round(response.data.range().clim['2000'].bio['13'].m)"></td>
				<td data-bind="text: response.data.range().clim['2000'].bio['13'].h"></td>
			</tr>
			<tr data-bind="if: typeof(response.data.range().clim['2000'].bio['14']) != 'undefined'">
				<th>Precipitation of Driest Month: </th>
				<td data-bind="text: response.data.range().clim['2000'].bio['14'].l"></td>
				<td data-bind="text: Math.round(response.data.range().clim['2000'].bio['14'].m)"></td>
				<td data-bind="text: response.data.range().clim['2000'].bio['14'].h"></td>
			</tr>
			<tr data-bind="if: typeof(response.data.range().clim['2000'].bio['15']) != 'undefined'">
				<th>Precipitation Seasonality: </th>
				<td data-bind="text: response.data.range().clim['2000'].bio['15'].l"></td>
				<td data-bind="text: Math.round(response.data.range().clim['2000'].bio['15'].m)"></td>
				<td data-bind="text: response.data.range().clim['2000'].bio['15'].h"></td>
			</tr>
			<tr data-bind="if: typeof(response.data.range().clim['2000'].bio['16']) != 'undefined'">
				<th>Precipitation of Wettest Quarter: </th>
				<td data-bind="text: response.data.range().clim['2000'].bio['16'].l"></td>
				<td data-bind="text: Math.round(response.data.range().clim['2000'].bio['16'].m)"></td>
				<td data-bind="text: response.data.range().clim['2000'].bio['16'].h"></td>
			</tr>
			<tr data-bind="if: typeof(response.data.range().clim['2000'].bio['17']) != 'undefined'">
				<th>Precipitation of Driest Quarter: </th>
				<td data-bind="text: response.data.range().clim['2000'].bio['17'].l"></td>
				<td data-bind="text: Math.round(response.data.range().clim['2000'].bio['17'].m)"></td>
				<td data-bind="text: response.data.range().clim['2000'].bio['17'].h"></td>
			</tr>
			<tr data-bind="if: typeof(response.data.range().clim['2000'].bio['18']) != 'undefined'">
				<th>Precipitation of Warmest Quarter: </th>
				<td data-bind="text: response.data.range().clim['2000'].bio['18'].l"></td>
				<td data-bind="text: Math.round(response.data.range().clim['2000'].bio['18'].m)"></td>
				<td data-bind="text: response.data.range().clim['2000'].bio['18'].h"></td>
			</tr>
			<tr data-bind="if: typeof(response.data.range().clim['2000'].bio['19']) != 'undefined'">
				<th>Precipitation of Coldest Quarter: </th>
				<td data-bind="text: response.data.range().clim['2000'].bio['19'].l"></td>
				<td data-bind="text: Math.round(response.data.range().clim['2000'].bio['19'].m)"></td>
				<td data-bind="text: response.data.range().clim['2000'].bio['19'].h"></td>
			</tr>
		</table>
		<hr />
		<table data-bind="if: typeof(response.data.range().clim['2000'].prec) != 'undefined' || typeof(response.data.range().clim['2000'].temp) != 'undefined'" width=100%>
			<thead>
			<tr>
				<th></th>
				<th data-bind="if: typeof(response.data.range().clim['2000'].prec) != 'undefined'" colspan="3">Precipitation</th>
				<th data-bind="if: typeof(response.data.range().clim['2000'].temp) != 'undefined'" colspan="3">Min. temp</th>
				<th data-bind="if: typeof(response.data.range().clim['2000'].temp) != 'undefined'" colspan="3">Mean temp.</th>
				<th data-bind="if: typeof(response.data.range().clim['2000'].temp) != 'undefined'" colspan="3">Max temp.</th>
			</tr>
			<tr>
				<th></th>
				<th data-bind="if: typeof(response.data.range().clim['2000'].prec) != 'undefined'">Min.</th>
				<th data-bind="if: typeof(response.data.range().clim['2000'].prec) != 'undefined'">Mean</th>
				<th data-bind="if: typeof(response.data.range().clim['2000'].prec) != 'undefined'">Max.</th>
				<th data-bind="if: typeof(response.data.range().clim['2000'].temp) != 'undefined'">Min.</th>
				<th data-bind="if: typeof(response.data.range().clim['2000'].temp) != 'undefined'">Mean</th>
				<th data-bind="if: typeof(response.data.range().clim['2000'].temp) != 'undefined'">Max.</th>
				<th data-bind="if: typeof(response.data.range().clim['2000'].temp) != 'undefined'">Min.</th>
				<th data-bind="if: typeof(response.data.range().clim['2000'].temp) != 'undefined'">Mean</th>
				<th data-bind="if: typeof(response.data.range().clim['2000'].temp) != 'undefined'">Max.</th>
				<th data-bind="if: typeof(response.data.range().clim['2000'].temp) != 'undefined'">Min.</th>
				<th data-bind="if: typeof(response.data.range().clim['2000'].temp) != 'undefined'">Mean</th>
				<th data-bind="if: typeof(response.data.range().clim['2000'].temp) != 'undefined'">Max.</th>
			</tr>
			</thead>
			<tbody data-bind="foreach: $root.monthIndexes">
			<tr>
				<th data-bind="text: $root.monthNames[$data]"></th>
				<td data-bind="text: $root.response.data.range().clim['2000'].prec[$data].l"></td>
				<td data-bind="text: Math.round($root.response.data.range().clim['2000'].prec[$data].m)"></td>
				<td data-bind="text: $root.response.data.range().clim['2000'].prec[$data].h"></td>
				<td data-bind="text: $root.response.data.range().clim['2000'].temp.l[$data].l / 10"></td>
				<td data-bind="text: Math.round(($root.response.data.range().clim['2000'].temp.l[$data].m / 10)*10)/10"></td>
				<td data-bind="text: $root.response.data.range().clim['2000'].temp.l[$data].h / 10"></td>
				<td data-bind="text: $root.response.data.range().clim['2000'].temp.m[$data].l / 10"></td>
				<td data-bind="text: Math.round(($root.response.data.range().clim['2000'].temp.m[$data].m / 10)*10)/10"></td>
				<td data-bind="text: $root.response.data.range().clim['2000'].temp.m[$data].h / 10"></td>
				<td data-bind="text: $root.response.data.range().clim['2000'].temp.h[$data].l / 10"></td>
				<td data-bind="text: Math.round(($root.response.data.range().clim['2000'].temp.h[$data].m / 10)*10)/10"></td>
				<td data-bind="text: $root.response.data.range().clim['2000'].temp.h[$data].h / 10"></td>
			</tr>
			</tbody>
		</table>
	</div>
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
		var baseCMD = "near";
	</script>
	<!-- Include my.js -->
	<script src="js/ViewModel.js"></script>
	<!-- Set defaults. -->
	<script type="text/javascript">
		myModel.modifiers.request.visible(true);
		myModel.modifiers.connection.visible(true);
		myModel.modifiers.range.visible(true);
		myModel.modifiers.count.visible(true);

		myModel.geometry.type("point");
	</script>
</body>
</html>
