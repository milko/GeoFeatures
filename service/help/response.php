<?php

/*=======================================================================================
 *																						*
 *								    response.php	           							*
 *																						*
 *======================================================================================*/

/**
 *	Response web-service help page.
 *
 *	This file contains the helo page for the response of the web-service.
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
    <title>GeoFeatures documentation - Response data structure</title>
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
                            <a class="current" href="response.php">Response data structure</a>
                            <ul>
                                <li><a href="#status">Status</a></li>
                                <ul>
                                    <li><a href="#state"><abbr title="state">Operation state</abbr></a></li>
                                    <li><a href="#total"><abbr title="total">Affected count</abbr></a></li>
                                    <li><a href="#start"><abbr title="start">Starting record</abbr></a></li>
                                    <li><a href="#limit"><abbr title="limit">Page limit</abbr></a></li>
                                    <li><a href="#count"><abbr title="count">Actual count</abbr></a></li>
                                    <li><a href="#message"><abbr title="message">Status message</abbr></a></li>
                                    <li><a href="#code"><abbr title="code">Error code</abbr></a></li>
                                    <li><a href="#file"><abbr title="file">Error file</abbr></a></li>
                                    <li><a href="#line"><abbr title="line">Error file line</abbr></a></li>
                                    <li><a href="#trace"><abbr title="trace">Error trace</abbr></a></li>
                                </ul>
                                <li><a href="#request">Request</a></li>
                                <li><a href="#connection">Connection</a></li>
                                <ul>
                                    <li><a href="#server"><abbr title="server">Database server</abbr></a></li>
                                    <li><a href="#database"><abbr title="database">Database name</abbr></a></li>
                                    <li><a href="#collection"><abbr title="collection">Collection name</abbr></a></li>
                                </ul>
                                <li><a href="#data">Response</a></li>
                                <ul>
                                    <li><a href="#_id"><abbr title="_id">Tile index</abbr></a></li>
                                    <li><a href="#pt"><abbr title="pt">Tile center point (deg)</abbr></a></li>
                                    <li><a href="#dms"><abbr title="dms">Tile center point (dms)</abbr></a></li>
                                    <li><a href="#tile"><abbr title="tile">Tile X and Y</abbr></a></li>
                                    <li><a href="#bdec"><abbr title="bdec">Tile vertices (deg)</abbr></a></li>
                                    <li><a href="#bdms"><abbr title="bdms">Tile vertices (dms)</abbr></a></li>
                                    <li><a href="#elev"><abbr title="elev">Tile elevation</abbr></a></li>
                                    <li><a href="#dist"><abbr title="dist">Distance</abbr></a></li>
                                    <li><a href="#clim"><abbr title="clim">Tile climate</abbr></a></li>
                                    <ul>
                                        <li><a href="#gens"><abbr title="gens">Global environment stratification</abbr></a></li>
                                        <li><a href="#bio"><abbr title="bio">Bioclimatic variables</abbr></a></li>
                                        <li><a href="#prec"><abbr title="prec">Monthly precipitation</abbr></a></li>
                                        <li><a href="#temp"><abbr title="temp">Monthly temperature</abbr></a></li>
                                    </ul>
                                </ul>
                            </ul>
                        </li>
                        <li>
                            <a href="request.php">Request data structure</a>
                        </li>
                        <li>
	                        <a href="examples.php">Examples <span class="label label-warning">under construction</span></a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- CONTENTS CONTAINER -->
            <div class="col-lg-8">

                <!-- INTRODUCTION -->
                <section id="intro">
                    <h4>
                        Response data structure
                    </h4>
                    <p>
                        The response of the service is a
                        <abbr title="JavaScript Object Notation">JSON</abbr> object divided
                        into four sections:
                    </p>
                    <dl class="dl-horizontal">
                        <dt><a href="#status">Status</a></dt>
                        <dd>
                            This section provides information regarding the outcome of the
                            service call, the number of elements processed by the
                            operation and paging information <small>in case the service call
                            returns more than one result record</small>.
                        </dd>
                        <dt><a href="#request">Request</a></dt>
                        <dd>
                            This section returns the request received by the service.<br />
                            <small>This section is useful for debugging purposes and it is
                            optional: it is disabled in production</small>.
                        </dd>
                        <dt><a href="#connection">Connection</a></dt>
                        <dd>
                            This section returns the database connection details.<br />
                            <small>This section is useful for debugging purposes and it is
                            optional: it is disabled in production</small>.
                        </dd>
                        <dt><a href="#data">Response</a></dt>
                        <dd>
                            This section contains the data requested from the service.
                        </dd>
                    </dl>
                    <p>
                        The service will <em>always</em> return the
                        <a href="#status">status</a> section, while the
                        <a href="#data">response</a> section will be returned only if
                        the service found results and there were no errors.
                    </p>
                </section>

                <!-- STATUS -->
                <section id="status">
                    <h4>
                        Status section [<strong><code>status</code></strong>]
                    </h4>
                    <p>
                        This section is comprised of elements that provide information on
                        the <em>operation status</em>, <em>errors or warnings</em>, on the
                        <em>affected count</em> of elements processed by the operation and
                        on current <em>paging limits</em>.
                    </p>
                    <div class="panel">
                        <dl id="state">
                            <dt>Operation state [<strong><code>state</code></strong>]</dt>
                            <dd>
                                The state indicates the <em>outcome</em> of the operation,
                                <strong>this item is always present</strong>.
                                <ul>
                                    <li>
                                        <strong><code>OK</code></strong>: <em>Successful</em> operation.
                                    </li>
                                    <li>
                                        <strong><code>ERROR</code></strong>: The operation
                                        <em>failed</em>.
                                    </li>
                                    <li>
                                        <strong><code>IDLE</code></strong>: This should never be
                                        returned: if that happens it means that there was an
                                        uncaught error before the service was done parsing the
                                        request.
                                    </li>
                                </ul>
                            </dd>
                        </dl>
                        <dl id="total">
                            <dt>Affected count [<strong><code>total</code></strong>]</dt>
                            <dd>
                                This element contains the <em>total count of objects affected by
                                the operation</em>. Suppose you request all tiles contained in
                                the provided square, this element will contain the total
                                count of the tiles selected by the service, altough you
                                might only request the first 10.
                            </dd>
                        </dl>
                        <dl id="start">
                            <dt>Starting record [<strong><code>start</code></strong>]</dt>
                            <dd>
                                This paging variable contains the <em>0-based</em> <em>index of
                                the first returned element</em>. If you were requesting the
                                second 10 records, this element would be <code>1</code>.
                            </dd>
                        </dl>
                        <dl id="limit">
                            <dt>Page limit [<strong><code>limit</code></strong>]</dt>
                            <dd>
                                This paging variable contains the <em>maximum number of elements</em>
                                to be returned by the current request. If you were
                                requesting at most 10 records, this element would be
                                <code>10</code>.<br />
                                <small class="text-warning">Note that this element does not
                                hold the actual number of returned elements</small>.
                            </dd>
                        </dl>
                        <dl id="count">
                            <dt>Actual count [<strong><code>count</code></strong>]</dt>
                            <dd>
                                This paging variable contains the <em>actual number of elements</em>
                                returned by the service.<br />
                                <small class="text-warning">Note that this number may be
                                smaller than the maximum number of requested elements
                            </small>.
                            </dd>
                        </dl>
                        <dl id="message">
                            <dt>Status message [<strong><code>message</code></strong>]</dt>
                            <dd>
                                This element holds eventual error <em>messages</em> or
                                <em>notices</em>. This element will always be returned in
                                case the service fails because of an error; it may be returned
                                if the service has enforced settings, such as a page limit
                                for operations that could return a large number of results.
                            </dd>
                        </dl>
                        <dl id="code">
                            <dt>Error code [<strong><code>code</code></strong>]</dt>
                            <dd>
                                This element holds the eventual error <em>code</em>, this
                                will only occur if there was an error.<br />
                                <small class="text-warning">Note that this is for debugging purposes and it is
                                    disabled in production</small>.
                            </dd>
                        </dl>
                        <dl id="file">
                            <dt>Error file [<strong><code>file</code></strong>]</dt>
                            <dd>
                                This element holds the eventual error <em>file path</em>, this
                                will only occur if there was an error.<br />
                                <small class="text-warning">Note that this is for debugging purposes and it is
                                    disabled in production</small>.
                            </dd>
                        </dl>
                        <dl id="line">
                            <dt>Error file line [<strong><code>line</code></strong>]</dt>
                            <dd>
                                This element holds the eventual error <em>file line</em>, this
                                will only occur if there was an error.<br />
                                <small class="text-warning">Note that this is for debugging purposes and it is
                                    disabled in production</small>.
                            </dd>
                        </dl>
                        <dl id="trace">
                            <dt>Error trace [<strong><code>trace</code></strong>]</dt>
                            <dd>
                                This element holds the eventual error <em>trace</em>, this
                                will only occur if there was an error.<br />
                                <small class="text-warning">Note that this is for debugging purposes and it is
                                    disabled in production</small>.
                            </dd>
                        </dl>
                    </div>
                </section>

                <!-- REQUEST -->
                <section id="request">
                    <h4>
                        Request section [<strong><code>request</code></strong>]
                    </h4>
                    <p>
                        This section will return the request as <em>interpreted by the service</em>.
                        This means that you will only see the parameters that the service
                        recognised or handled, in the format used by the service.<br />
                        <small class="text-warning">Note that this is generally used for debugging purposes and
                            is only available if
                            <a href="request.php#cpy-request"><abbr title="cpy-request">requested</abbr></a>
                            to the service.</small>
                    </p>
                </section>

                <!-- CONNECTION -->
                <section id="connection">
                    <h4>
                        Connection section [<strong><code>connection</code></strong>]
                    </h4>
                    <p>
                        This section will return the <em>database connection</em> information.<br />
                        <small class="text-warning">Note that this is generally used for debugging purposes and
                            is only available if
                            <a href="request.php#cpy-connection"><abbr title="cpy-connection">requested</abbr></a>
                            to the service.<br />
                            <strong>This option is disabled in production.</strong></small>
                    </p>
                    <div class="panel">
                        <dl id="server">
                            <dt>Database server [<strong><code>server</code></strong>]</dt>
                            <dd>
                                The server <abbr title="Data Source Name">DSN</abbr>.
                            </dd>
                        </dl>
                        <dl id="database">
                            <dt>Database name [<strong><code>database</code></strong>]</dt>
                            <dd>
                                The server <em>database</em>.
                            </dd>
                        </dl>
                        <dl id="collection">
                            <dt>Collection name [<strong><code>collection</code></strong>]</dt>
                            <dd>
                                The server database <em>collection</em>.
                            </dd>
                        </dl>
                    </div>
                </section>

                <!-- RESPONSE -->
                <section id="data">
                    <h4>
                        Response section [<strong><code>data</code></strong>]
                    </h4>
                    <p>
                        This section will return the <em>service data</em>, in case the
                        operation was successful and results were found.
                    </p>
                    <p>
                        The data is structured as a single or an array of records that contain
                        the following information:
                    </p>
                    <div class="panel">
                        <dl id="_id">
                            <dt>Tile index [<strong><code>_id</code></strong>]</dt>
                            <dd>
                                The tile <em>index</em> or <em>id</em>
                                [<small><abbr title="integer"><code>int</code></abbr></small>].
                                The grid is divided into 43200 horizontal and 18000 vertical
                                tiles, this element represents the unique identifier of the
                                tile and is calculated by the formula
                                <code>(Y * 43200) - (X + 1)</code>, where both X and Y are 0-based.
                            </dd>
                        </dl>
                        <dl id="pt">
                            <dt>Tile center point [<strong><code>pt</code></strong>]</dt>
                            <dd>
                                The tile <em>center coordinates</em>, in decimal degrees.
                                This element is an object formatted as a
                                <abbr title="GeoJSON is a format for encoding a variety of geographic data structures">GeoJSON</abbr>
                                point:
                                <ul>
                                    <li>
                                        <code>type</code>: The constant <code>Point</code>.
                                    </li>
                                    <li>
                                        <code>coordinates</code>: An array of two elements
                                        corresponding respectively to the <em>longitude</em>
                                        and <em>latitude</em> of the point in decimal degrees.
                                    </li>
                                </ul>
                            </dd>
                        </dl>
                        <dl id="dms">
                            <dt>Tile center point [<strong><code>dms</code></strong>]</dt>
                            <dd>
                                The tile <em>center coordinates</em>, in degrees, minutes
                                and seconds notation. This element is an array of two
                                elements corresponding respectively to the <em>longitude</em>
                                and <em>latitude</em> of the point, formatted as a
                                <code>DDD&deg;MM'SS"H</code> string in which <code>DDD</code>
                                corresponds to the degrees, <code>MM</code> to the minutes,
                                <code>SS</code> to the seconds and <code>H</code> to the
                                hemisphere (<em>N</em> or <em>S</em> for latitude
                                and <em>E</em> or <em>W</em> for longitude).
                            </dd>
                        </dl>
                        <dl id="tile">
                            <dt>Tile X and Y [<strong><code>tile</code></strong>]</dt>
                            <dd>
                                The tile <em>X</em> and <em>Y</em> indices as an array of
                                two integers.
                            </dd>
                        </dl>
                        <dl id="bdec">
                            <dt>Tile vertices [<strong><code>bdec</code></strong>]</dt>
                            <dd>
                                The tile <em>vertices</em> in decimal degrees. The element
                                is structured as an array of two items representing
                                respectively the top-left and bottom-right coordinates of
                                the tile. Both items are an array of two elements, longitude
                                and latitude, representing the coordinates of the vertex.
                            </dd>
                        </dl>
                        <dl id="bdms">
                            <dt>Tile vertices [<strong><code>bdms</code></strong>]</dt>
                            <dd>
                                The tile <em>vertices</em> in degrees, minutes and seconds.
                                The element is structured as an array of two items representing
                                respectively the top-left and bottom-right coordinates of
                                the tile. Both items are an array of two elements, longitude
                                and latitude, representing the coordinates of the vertex and
                                formatted as a <code>DDD&deg;MM'SS"H</code> string in which
                                <code>DDD</code> corresponds to the degrees, <code>MM</code>
                                to the minutes, <code>SS</code> to the seconds and
                                <code>H</code> to the hemisphere (<em>N</em> or <em>S</em>
                                for latitude and <em>E</em> or <em>W</em> for longitude).
                            </dd>
                        </dl>
                        <dl id="elev">
                            <dt>Tile elevation [<strong><code>elev</code></strong>]</dt>
                            <dd>
                                The tile <em>elevation</em> in meters.
                            </dd>
                        </dl>
                        <dl id="dist">
                            <dt>Distance [<strong><code>dist</code></strong>]</dt>
                            <dd>
                                The <em>distance</em> of the tile center from the provided
                                point in meters. This element is only returned for operations
                                requesting tiles by proximity.
                            </dd>
                        </dl>
                        <dl id="clim">
                            <dt>Tile climate [<strong><code>clim</code></strong>]</dt>
                            <dd>
                                The tile <em>climate</em> variables. This section holds a
                                series of sub-sections representing the period to which the
                                climatic variables refer to, each section is structured in the
                                same way.
                            </dd>
                            <dd>
                                Currently, the service only provides current climate conditions,
                                this sub-section is tagged by <strong><code>2000</code></strong>.
                            </dd>
                        </dl>
                        <div class="panel">
                            <dl id="gens">
                                <dt>Global Environment Stratification [<strong><code>gens</code></strong>]</dt>
                                <dd>
                                    This element represents the global environment
                                    stratification for the current tile, it is an array of
                                    three elements representing:
                                </dd>
                                <ul>
                                    <li>
                                        <strong><code>id</code></strong>: The global
                                        environment stratification identifier composed of the
                                        concatenation of the <em>environmental zone code</em>
                                        and the <em>stratification code</em>.
                                    </li>
                                    <li>
                                        <strong><code>c</code></strong>: The
                                        <em>climatic zone code</em>:
                                        <ul>
                                            <li><code>1</code>: Arctic / Alpine.</li>
                                            <li><code>2</code>: Boreal / Alpine.</li>
                                            <li><code>3</code>: Cool temperate.</li>
                                            <li><code>4</code>: Warm temperate.</li>
                                            <li><code>5</code>: Sub-tropical.</li>
                                            <li><code>6</code>: Drylands.</li>
                                            <li><code>7</code>: Tropical.</li>
                                        </ul>
                                    </li>
                                    <li>
                                        <strong><code>e</code></strong>: The
                                        <em>environmental zone code</em>:
                                        <ul>
                                            <li><code>A</code>: Arctic.</li>
                                            <li><code>B</code>: Arctic.</li>
                                            <li><code>C</code>: Extremely cold and wet.</li>
                                            <li><code>D</code>: Extremely cold and wet.</li>
                                            <li><code>E</code>: Cold and wet.</li>
                                            <li><code>F</code>: Extremely cold and mesic.</li>
                                            <li><code>G</code>: Cold and mesic.</li>
                                            <li><code>H</code>: Cool temperate and dry.</li>
                                            <li><code>I</code>: Cool temperate and xeric.</li>
                                            <li><code>J</code>: Cool temperate and moist.</li>
                                            <li><code>K</code>: Warm temperate and mesic.</li>
                                            <li><code>L</code>: Warm temperate and xeric.</li>
                                            <li><code>M</code>: Hot and mesic.</li>
                                            <li><code>N</code>: Hot and dry.</li>
                                            <li><code>O</code>: Hot and arid.</li>
                                            <li><code>P</code>: Extremely hot and arid.</li>
                                            <li><code>Q</code>: Extremely hot and xeric.</li>
                                            <li><code>R</code>: Extremely hot and moist.</li>
                                        </ul>
                                    </li>
                                </ul>
                            </dl>
                            <dl id="bio">
                                <dt>Bioclimatic variables [<strong><code>bio</code></strong>]</dt>
                                <dd>
                                    This element is an array of 19 bioclimatic variables
                                    tagged by <code>1</code> to <code>19</code>:
                                </dd>
                                <ul>
                                    <li>
                                        <strong><code>1</code></strong>: Annual Mean Temperature [<code>C&deg; * 10</code>].
                                    </li>
                                    <li>
                                        <strong><code>2</code></strong>: Mean Diurnal Range (<code>Mean of monthly (max temp - min temp)</code>) [<code>C&deg; * 10</code>].
                                    </li>
                                    <li>
                                        <strong><code>3</code></strong>: Isothermality (<code>bio[2]/bio[7]) (* 100)</code>.
                                    </li>
                                    <li>
                                        <strong><code>4</code></strong>: Temperature Seasonality (<code>standard deviation *100</code>).
                                    </li>
                                    <li>
                                        <strong><code>5</code></strong>: Max Temperature of Warmest Month [C&deg; * 10].
                                    </li>
                                    <li>
                                        <strong><code>6</code></strong>: Min Temperature of Coldest Month [C&deg; * 10].
                                    </li>
                                    <li>
                                        <strong><code>7</code></strong>: Temperature Annual Range (<code>bio[5]-bio[6]</code>).
                                    </li>
                                    <li>
                                        <strong><code>8</code></strong>: Mean Temperature of Wettest Quarter [C&deg; * 10].
                                    </li>
                                    <li>
                                        <strong><code>9</code></strong>: Mean Temperature of Driest Quarter [C&deg; * 10].
                                    </li>
                                    <li>
                                        <strong><code>10</code></strong>: Mean Temperature of Warmest Quarter [C&deg; * 10].
                                    </li>
                                    <li>
                                        <strong><code>11</code></strong>: Mean Temperature of Coldest Quarter [C&deg; * 10].
                                    </li>
                                    <li>
                                        <strong><code>12</code></strong>: Annual Precipitation.
                                    </li>
                                    <li>
                                        <strong><code>13</code></strong>: Precipitation of Wettest Month.
                                    </li>
                                    <li>
                                        <strong><code>14</code></strong>: Precipitation of Driest Month.
                                    </li>
                                    <li>
                                        <strong><code>15</code></strong>: Precipitation Seasonality (Coefficient of Variation).
                                    </li>
                                    <li>
                                        <strong><code>16</code></strong>: Precipitation of Wettest Quarter.
                                    </li>
                                    <li>
                                        <strong><code>17</code></strong>: Precipitation of Driest Quarter.
                                    </li>
                                    <li>
                                        <strong><code>18</code></strong>: Precipitation of Warmest Quarter.
                                    </li>
                                    <li>
                                        <strong><code>19</code></strong>: Precipitation of Coldest Quarter.
                                    </li>
                                </ul>
                            </dl>
                            <dl id="prec">
                                <dt>Monthly precipitation [<strong><code>prec</code></strong>]</dt>
                                <dd>
                                    This element collects the <em>monthly precipitation</em>, it is
                                    an array of 12 elements, one per month (<code>mm.</code>)
                                </dd>
                            </dl>
                            <dl id="temp">
                                <dt>Monthly temperature [<strong><code>temp</code></strong>]</dt>
                                <dd>
                                    This element collects the <em>monthly temperatures</em>, it is
                                    an array of 3 elements:
                                    <ul>
                                        <li>
                                            <strong><code>l</code></strong>: Average monthly
                                            <em>minimum</em> temperature [<code>C&deg; * 10</code>].<br />
                                            This element is an array of 12 items, tagged
                                            <code>1</code> to <code>12</code>, one per month.
                                        </li>
                                        <li>
                                            <strong><code>m</code></strong>: Average monthly
                                            <em>mean</em> temperature [<code>C&deg; * 10</code>].<br />
                                            This element is an array of 12 items, tagged
                                            <code>1</code> to <code>12</code>, one per month.
                                        </li>
                                        <li>
                                            <strong><code>h</code></strong>: Average monthly
                                            <em>maximum</em> temperature [<code>C&deg; * 10</code>].<br />
                                            This element is an array of 12 items, tagged
                                            <code>1</code> to <code>12</code>, one per month.
                                        </li>
                                    </ul>
                                </dd>
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
</body>
</html>
