<?php

/*=======================================================================================
 *																						*
 *								    request.php	             							*
 *																						*
 *======================================================================================*/

/**
 *	Request web-service help page.
 *
 *	This file contains the helo page for the request to the web-service.
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
    <title>GeoFeatures documentation - Request data structure</title>

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
                            <a class="current" href="request.php">Request data structure</a>
                            <ul class="nav">
                                <li><a href="#operation">Operations</a></li>
	                            <ul class="nav">
                                    <li><a href="#ping"><abbr title="ping">Ping</abbr></a></li>
                                    <li><a href="#help"><abbr title="help">Help</abbr></a></li>
                                    <li><a href="#tiles"><abbr title="tiles">Tiles</abbr></a></li>
                                    <li><a href="#contains"><abbr title="contains">Contains</abbr></a></li>
                                    <li><a href="#intersects"><abbr title="intersects">Intersects</abbr></a></li>
                                    <li><a href="#near"><abbr title="near">Near</abbr></a></li>
                                </ul>
                                <li><a href="#shape">Shapes</a></li>
	                            <ul class="nav">
                                    <li><a href="#tile"><abbr title="tile">Tiles</abbr></a></li>
                                    <li><a href="#point"><abbr title="point">Point</abbr></a></li>
                                    <li><a href="#rect"><abbr title="rect">Rectangle</abbr></a></li>
                                    <li><a href="#polygon"><abbr title="polygon">Polygon</abbr></a></li>
                                </ul>
                                <li><a href="#modifiers">Modifiers</a></li>
	                            <ul class="nav">
                                    <li><a href="#count"><abbr title="count">Count</abbr></a></li>
                                    <li><a href="#range"><abbr title="range">Range</abbr></a></li>
                                    <li><a href="#cpy-request"><abbr title="cpy-request">Return request</abbr></a></li>
                                    <li><a href="#cpy-connection"><abbr title="cpy-connection">Return connection</abbr></a></li>
                                </ul>
                                <li><a href="#filters">Filters</a></li>
	                            <ul class="nav">
                                    <li><a href="#elevation"><abbr title="elevation">Elevation range</abbr></a></li>
                                    <li><a href="#distance"><abbr title="distance">Maximum distance</abbr></a></li>
                                    <li><a href="#select"><abbr title="select">Property selector</abbr></a></li>
                                </ul>
                                <li><a href="#paging">Paging</a></li>
	                            <ul class="nav">
                                    <li><a href="#start"><abbr title="start">Start</abbr></a></li>
                                    <li><a href="#limit"><abbr title="limit">Limit</abbr></a></li>
                                </ul>
                            </ul>
                        </li>
                        <li>
	                        <a href="examples.php">Examples</a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- CONTENTS CONTAINER -->
            <div class="col-lg-8">

                <!-- INTRODUCTION -->
                <section id="intro">
                    <h4>
                        Request data structure
                    </h4>
                    <p>
                        The service request is a GET
                        <abbr title="Hyper Text Transfer Protocol">HTTP</abbr> call, such as in
                        <code>http://service-url?param&amp;param=value&amp;...&amp;param=value</code>,<br />
                        where some parameters require an associated value, while others not.
                    </p>
                    <p>
                        These parameters can be divided into six categories:
                    </p>
                    <dl class="dl-horizontal">
                        <dt><a href="#operation">Operation</a></dt>
                        <dd>
                            The requested <em>operation</em> or <em>command</em>.<br />
                            This kind of parameter does not need to have a value, only one of the
                            accepted tags should be provided and the parameter is <em>required</em>.
                        </dd>
                        <dt><a href="#shape">Shapes</a></dt>
                        <dd>
                            The <em>geometric shape</em> used for selecting the grid tiles.<br />
                            All operations, except ping and help, require this parameter.
                        </dd>
                        <dt><a href="#modifiers">Modifiers</a></dt>
                        <dd>
                            Optional operation <em>modifiers</em> or <em>options</em>.<br />
                            This set of parameters can be used to <em>alter the result</em>
                            or <em>request optional results</em>. This kind of parameter does
                            not need to have a value and several of them may be combined as a
                            set of flags.
                        </dd>
                        <dt><a href="#filters">Filters</a></dt>
                        <dd>
                            This set of parameters can be used to <em>provide a filter</em>
                            based on variables other than the geometry.<br />
                            This can be useful to retrieve data for a location where the coordinates
                            are not precise, but where the elevation range is known. The other
                            function of this set of parameters is to reduce the number of
                            properties returned in the service data response.
                        </dd>
                        <dt><a href="#paging">Paging</a></dt>
                        <dd>
                            This set of parameters can be used to <em>limit the number of
                            returned records</em>.
                            This can be useful and is <em>enforced</em> in cases where the service
                            might return a large number of records.
                        </dd>
                    </dl>
                </section>

                <!-- OPERATIONS -->
                <section id="operation">
                    <h4>Operations</h4>
                    <p>
                        This set of parameters determines what the service is going to do,
                        only one of the following tags must be provided and it does not
                        require any value:
                    </p>
                    <div class="panel">
                        <dl id="ping">
                            <dt>Ping [<strong><code>ping</code></strong>]</dt>
                            <dd>
                                This operation can be used to check if the service is running,
                                it does not require any other parameter and simply returns the
                                <a href="response.php#status">status</a> and the string
                                <code>pong</code> in the <a href="response.php#data">response</a>
                                section.<br />
                            </dd>
                            <pre class="pre-scrollable" style="white-space: nowrap"><?php echo( kURL.'?' ); ?><strong>ping</strong></pre>
                        </dl>
                        <dl id="help">
                            <dt>Help [<strong><code>help</code></strong>]</dt>
                            <dd>
                                This operation can be used to get help in using this service,
                                it does not require any other parameter and simply returns the
                                help pages in <abbr title="HyperText Markup Language">HTML</abbr>.
                            </dd>
                            <pre class="pre-scrollable" style="white-space: nowrap"><?php echo( kURL.'?' ); ?><strong>help</strong></pre>
                        </dl>
                        <dl id="tiles">
                            <dt>Tiles [<strong><code>tiles</code></strong>]</dt>
                            <dd>
                                This operation can be used to retrieve a list of tiles by
                                <a href="response.php#_id"><abbr title="_id">identifier</abbr></a>. The operation
                                requires the <a href="#tile"><abbr title="tile">tile</abbr></a> shape parameter
                                holding the list of requested tile identifiers.
                            </dd>
                            <pre class="pre-scrollable" style="white-space: nowrap"><?php echo( kURL.'?' ); ?><strong>tiles</strong>&amp;tile=33065587,774896741</pre>
                        </dl>
                        <dl id="contains">
                            <dt>Contains [<strong><code>contains</code></strong>]</dt>
                            <dd>
                                This operation can be used to retrieve the tile that contains
                                the provided <a href="#point"><abbr title="point">point</abbr></a>, or all tiles whose center
                                point is contained by the provided <a href="#rect"><abbr title="rect">rectangle</abbr></a> or
                                <a href="#polygon"><abbr title="rect">polygon</abbr></a>. The operation requires the shape
                                parameter and will enforce paging if the provided geometry is not a point.
                            </dd>
                            <pre class="pre-scrollable" style="white-space: nowrap"><?php echo( kURL.'?' ); ?><strong>contains</strong>&amp;point=-16.6463,28.2768</pre>
                        </dl>
                        <dl id="intersects">
                            <dt>Intersects [<strong><code>intersects</code></strong>]</dt>
                            <dd>
                                This operation can be used to retrieve the tiles that intersect
                                with the provided <a href="#point"><abbr title="point">point</abbr></a>,
                                <a href="#rect"><abbr title="rect">rectangle</abbr></a>
                                or <a href="#polygon"><abbr title="rect">polygon</abbr></a>.
                                The operation requires the shape parameter and will enforce paging if
                                the provided geometry is not a point.
                            </dd>
                            <pre class="pre-scrollable" style="white-space: nowrap"><?php echo( kURL.'?' ); ?><strong>intersects</strong>&amp;rect=-16.6463,28.2768;-16.638,28.2685</pre>
                        </dl>
                        <dl id="near">
                            <dt>Near [<strong><code>near</code></strong>]</dt>
                            <dd>
                                This operation can be used to retrieve the tiles closest to the
                                provided <a href="#point"><abbr title="point">point</abbr></a>, the service will return a list
                                of tile records, 100 at most, sorted by distance, the closest first.
                                The operation requires the shape parameter in the form of a point.
                                This is the only operation that will add the
                                <a href="response.php#dist"><abbr title="dist">distance</abbr></a>
                                value to the results. The operatrion also accepts the
                                <a href="#distance"><abbr title="distance">maximum distance</abbr></a>
                                parameter to limit the selection to a maximum distance from the provided
                                point in meters.
                            </dd>
                            <pre class="pre-scrollable" style="white-space: nowrap"><?php echo( kURL.'?' ); ?><strong>near</strong>&amp;point=-16.6463,28.2768</pre>
                        </dl>
                    </div>
                </section>

                <!-- SHAPE -->
                <section id="shape">
                    <h4>Shapes</h4>
                    <p>
                        This set of parameters indicates the shape used to select the grid tiles,
                        only one of the following should be provided:
                    </p>
                    <div class="panel">
                        <dl id="tile">
                            <dt>Tiles [<strong><code>tile</code></strong>]</dt>
                            <dd>
                                This shape represents a comma-delimited list of tile
                                <a href="response.php#_id"><abbr title="_id">identifiers</abbr></a>, this geometry
                                is only used by the <a href="#tiles"><abbr title="tiles">tiles</abbr></a>
                                operation.
                            </dd>
                            <pre class="pre-scrollable" style="white-space: nowrap"><?php echo( kURL.'?' ); ?>tiles&amp;<strong>tile=33065587,774896741</strong></pre>
                        </dl>
                        <dl id="point">
                            <dt>Point [<strong><code>point</code></strong>]</dt>
                            <dd>
                                This shape represents a point, the value represents a pair
                                of decimal degrees comma delimited coordinates indicating
                                respectively the longitude and latitude of the point.
                            </dd>
                            <pre class="pre-scrollable" style="white-space: nowrap"><?php echo( kURL.'?' ); ?>contains&amp;<strong>point=-16.6463,28.2768</strong></pre>
                        </dl>
                        <dl id="rect">
                            <dt>Rectangle [<strong><code>rect</code></strong>]</dt>
                            <dd>
                                This shape represents a rectangle, the value represents the
                                two vertices of the shape in decimal degrees. The parameter
                                is expressed as two blocks separated by a semicolon, each
                                block represents a vertex composed of the longitude and
                                latitude separated by a comma.<br />
                                <small class="text-info">When requesting a
                                <a href="#cpy-request"><abbr title="cpy-request">copy</abbr></a>
                                of the request, an <abbr title="area">item</abbr> will be added
                                to the shape structure holding the area of the geometry.</small>
                            </dd>
                            <pre class="pre-scrollable" style="white-space: nowrap"><?php echo( kURL.'?' ); ?>contains&amp;<strong>rect=-16.6463,28.2768;-16.638,28.2685</strong></pre>
                        </dl>
                        <dl id="polygon">
                            <dt>Polygon [<strong><code>polygon</code></strong>]</dt>
                            <dd>
                                This shape represents a polygon in decimal degrees. The shape
                                is provided as a string using three divider tokens: the
                                <em>outer and inner rings</em> are divided by a colon, the
                                <em>ring vertices</em> are divided by a semicolon and the
                                <em>vertex coordinates</em> by a comma.<br />
                                <small class="text-info">When requesting a
                                    <a href="#cpy-request"><abbr title="cpy-request">copy</abbr></a>
                                    of the request, an <abbr title="area">item</abbr> will be added
                                    to the shape structure holding the area of the geometry.</small>
                            </dd>
                            <pre class="pre-scrollable" style="white-space: nowrap"><?php echo( kURL.'?' ); ?>contains&amp;<strong>polygon=12.8199,42.8422;12.8207,42.8158;12.8699,42.8166;12.8678,42.8398;12.8199,42.8422</strong><br /><?php echo( kURL.'?' ); ?>contains&amp;<strong>polygon=12.8199,42.8422;12.8207,42.8158;12.8699,42.8166;12.8678,42.8398;12.8199,42.8422:12.8344,42.8347;12.8348,42.8225;12.8570,42.8223;12.8566,42.8332;12.8344,42.8347</strong></pre>
                        </dl>
                    </div>
                </section>

                <!-- MODIFIERS -->
                <section id="modifiers">
                    <h4>Modifiers</h4>
                    <p>
                        This set of parameters modify the result of the service and are used
                        to activate cusstom options. The parameters do not need a value and
                        some may be concurrent:
                    </p>
                    <div class="panel">
                        <dl id="count">
                            <dt>Count [<strong><code>count</code></strong>]</dt>
                            <dd>
                                This option will disable the results pane and only return
                                the <a href="response.php#total"><abbr title="total">affected count</abbr></a>
                                in the <a href="response.php#status">status section</a>.<br />
                                This option is incompatible with the
                                <a href="#range"><abbr title="range">range</abbr></a> modifier,
                                if both are provided, this one will be chosen.
                                This options can be useful when a large set of results may be returned:
                                by calling the service with this modifier, one may organise
                                paged results retrieval.
                            </dd>
                            <pre class="pre-scrollable" style="white-space: nowrap"><?php echo( kURL.'?' ); ?>contains&amp;<strong>count</strong>&amp;rect=-16.6463,28.2768;-16.638,28.2685</pre>
                        </dl>
                        <dl id="range">
                            <dt>Range [<strong><code>range</code></strong>]</dt>
                            <dd>
                                This option will aggregate the results of the service into a
                                single record, where continuous values will be expanded into
                                an set of three elements in which <strong><code>l</code></strong>
                                will hold the <em>minimum</em> value,
                                <strong><code>m</code></strong> the <em>average</em> value and
                                <strong><code>h</code></strong> the <em>maximum</em> value; categorical
                                variables will be expanded into an array containing all distinct
                                values. Only the
                                <a href="response.php#elev"><abbr title="elev">elevation</abbr></a>
                                and the <a href="response.php#clim"><abbr title="clim">climate section</abbr></a>
                                will be included in the result (including the
                                <a href="response.php#dist"><abbr title="dist">distance</abbr></a>
                                when requesting the
                                <a href="#near"><abbr title="near">near</abbr></a> operation).<br />
                                This option is incompatible with the
                                <a href="#count"><abbr title="count">count</abbr></a> modifier,
                                if both are provided, the latter will be chosen. This modifier
                                is not active if you provide a
                                <a href="#point"><abbr title="point">point</abbr></a> to the
                                <a href="#contains"><abbr title="contains">contains</abbr></a>
                                or <a href="#intersects"><abbr title="intersects">intersects</abbr></a>
                                operations.<br />
                                This option can be useful to explore the variation and range
                                of a set of results.
                            </dd>
                            <pre class="pre-scrollable" style="white-space: nowrap"><?php echo( kURL.'?' ); ?>contains&amp;<strong>range</strong>&amp;rect=-16.6463,28.2768;-16.638,28.2685</pre>
                        </dl>
                        <dl id="cpy-request">
                            <dt>Copy request [<strong><code>cpy-request</code></strong>]</dt>
                            <dd>
                                This option will return the request provided to the service
                                in the <a href="response.php#request">request section</a> of
                                the response. This option can be useful to debug service requests
                                and can be cumulated with all other modifiers.
                            </dd>
                            <pre class="pre-scrollable" style="white-space: nowrap"><?php echo( kURL.'?' ); ?>contains&amp;range&amp;<strong>cpy-request</strong>rect=-16.6463,28.2768;-16.638,28.2685</pre>
                        </dl>
                        <dl id="cpy-connection">
                            <dt>Copy connection [<strong><code>cpy-connection</code></strong>]</dt>
                            <dd>
                                This option will return the database connection parameters used by the service
                                in the <a href="response.php#connection">connection section</a> of
                                the response. This option can be useful to debug service requests
                                and can be cumulated with all other modifiers.<br />
                                <small class="text-warning"><em>In the production environment this option is disabled</em></small>.
                            </dd>
                            <pre class="pre-scrollable" style="white-space: nowrap"><?php echo( kURL.'?' ); ?>contains&amp;range&amp;cpy-request&amp;<strong>cpy-connection</strong>&amp;point=-16.6463,28.2768</pre>
                        </dl>
                    </div>
                </section>

                <!-- FILTERS -->
                <section id="filters">
                    <h4>Filters</h4>
                    <p>
                        This set of parameters can be used to refine the results matching
                        the provided shape using a set of variables other than the geometry:
                    </p>
                    <div class="panel">
                        <dl id="elevation">
                            <dt>Elevation [<strong><code>elevation</code></strong>]</dt>
                            <dd>
                                The value of this parameter is a comma delimited set of two
                                values that represent the elevation range in meters. Results
                                of the operation will only include tiles belonging to that range.
                            </dd>
                            <pre class="pre-scrollable" style="white-space: nowrap"><?php echo( kURL.'?' ); ?>contains&amp;rect=-10,30;-11,29&amp;<strong>elevation=1000,1050</strong></pre>
                        </dl>
                        <dl id="distance">
                            <dt>Distance [<strong><code>distance</code></strong>]</dt>
                            <dd>
                                This parameter can be used for two purposes: when provided
                                along with a <a href="#point"><abbr title="point">point</abbr></a>,
                                it indicates that you are providing a circle shape as the geometry
                                selection; when provided with the
                                <a href="#near"><abbr title="near">near</abbr></a> operation, it
                                reduces the results to those tiles within that distance. The value
                                is expressed in meters.
                            </dd>
                            <pre class="pre-scrollable" style="white-space: nowrap"><?php echo( kURL.'?' ); ?>contains&amp;point=-16.6463,28.2768&amp;<strong>distance=5000</strong><br /><?php echo( kURL.'?' ); ?>near&amp;point=-16.6463,28.2768&amp;<strong>distance=5000</strong></pre>
                        </dl>
                        <dl id="select">
                            <dt>Property [<strong><code>select</code></strong>]</dt>
                            <dd>
                                This parameter can be used to include or exclude individual
                                elements of the service response. The parameter is a list
                                of blocks separated by a semicolon where each block represents
                                a key/value pair separated by a comma: the key part identifies
                                the property, if the value part is <code>1</code> the property
                                should be <em>included</em> in the result, if the value is
                                <code>0</code> the property should be <em>excluded</em>.
                                The property is represented by the label used in the
                                <a href="response.php#data">response data section</a>. To
                                select properties that are part of a subsection, separate
                                each level by a period: for instance, to select the average
                                minimum temperature in February, you would provide the
                                following block: <em>clim.2000.temp.l.2</em>
                            </dd>
                            <pre class="pre-scrollable" style="white-space: nowrap"><?php echo( kURL.'?' ); ?>contains&amp;rect=-10,30;-11,29&amp;<strong>select=elev,1;clim,1</strong><br /><?php echo( kURL.'?' ); ?>contains&amp;rect=-10,30;-11,29&amp;<strong>select=elev,1;clim.2000.gens.e,1</strong><br /><?php echo( kURL.'?' ); ?>contains&amp;rect=-10,30;-11,29&amp;<strong>select=clim,0</strong></pre>
                        </dl>
                    </div>
                </section>

                <!-- PAGING -->
                <section id="paging">
                    <h4>Paging</h4>
                    <p>
                        This set of parameters can be used to control the maximum number of
                        elements returned by the service and implement paging:
                    </p>
                    <div class="panel">
                        <dl id="start">
                            <dt>Start [<strong><code>start</code></strong>]</dt>
                            <dd>
                                The value of this parameter is an integer that indicates from
                                what record to start returning results; in other words, it
                                indicates the number of records to skip before returning data.
                            </dd>
                            <pre class="pre-scrollable" style="white-space: nowrap"><?php echo( kURL.'?' ); ?>contains&amp;rect=-10,30;-11,29&amp;<strong>start=0</strong></pre>
                        </dl>
                        <dl id="limit">
                            <dt>Limit [<strong><code>limit</code></strong>]</dt>
                            <dd>
                                The value of this parameter is an integer that indicates the
                                maximum count of records that the service should return. The
                                actual number of records that the service will actually return
                                will be smaller or equal to this value.
                            </dd>
                            <pre class="pre-scrollable" style="white-space: nowrap"><?php echo( kURL.'?' ); ?>contains&amp;rect=-10,30;-11,29&amp;start=0&amp;<strong>limit=10</strong></pre>
                        </dl>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <!-- JavaScript plugins (requires jQuery) -->
    <script src="http://code.jquery.com/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
</body>
</html>

