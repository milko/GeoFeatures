/**
 * Created with JetBrains PhpStorm.
 * User: milko
 * Date: 8/8/13
 * Time: 13:28
 * To change this template use File | Settings | File Templates.
 */

//
// View model.
//
function MyViewModel() {
    //
    // Reference this.
    //
    var self = this;

    //
    // MODIFIERS BLOCK.
    //
    self.requestModCopyRequest = ko.observable();
    self.requestModCopyConnection = ko.observable();
    self.requestModCount = ko.observable();
    self.requestModRange = ko.observable();

    //
    // REQUEST URL.
    //
    self.request = ko.computed(function() {
        // Base URL.
        var url = baseURL + "?";

        // Add operation.
        url += baseCMD;

        // Add modifiers.
        if( self.requestModCopyRequest() )
            url += ("&" + "cpy-request");
        if( self.requestModCopyConnection() )
            url += ("&" + "cpy-connection");
        if( self.requestModCount() )
            url += ("&" + "count");
        if( self.requestModRange() )
            url += ("&" + "range");

        return url;
    });

    //
    // RESPONSE DATA.
    //
    self.responseJSON = ko.observable("");
    self.responseOBJECT = ko.observable();
    self.hasResponse = ko.observable(false);
    self.responseData = ko.observable(null);

    //
    // STATUS BLOCK.
    //
    self.hasStatus = ko.observable(false);
    self.statusState = ko.observable(false);
    self.hasStatusMessage = ko.observable(false);
    self.statusMessage = ko.observable();
    self.hasStatusTotal = ko.observable(false);
    self.statusTotal = ko.observable();
    self.hasStatusCount = ko.observable(false);
    self.statusCount = ko.observable();
    self.hasStatusStart = ko.observable(false);
    self.statusStart = ko.observable();
    self.hasStatusLimit = ko.observable(false);
    self.statusLimit = ko.observable();

    //
    // REQUEST BLOCK.
    //
    self.hasRequest = ko.observable(false);
    self.hasRequestOperation = ko.observable(false);
    self.requestOperation = ko.observable();
    self.hasRequestModifiers = ko.observable(false);
    self.requestModifiers = ko.observableArray([]);

    //
    // CONNECTION BLOCK.
    //
    self.hasConnection = ko.observable(false);
    self.hasConnectionServer = ko.observable(false);
    self.connectionServer = ko.observable();
    self.hasConnectionDatabase = ko.observable(false);
    self.connectionDatabase = ko.observable();
    self.hasConnectionCollection = ko.observable(false);
    self.connectionCollection = ko.observable();

    //
    // DATA BLOCK.
    //
    self.hasData = ko.observable(false);

    //
    // RESPONSE FORMAT.
    //
    self.responseFormat = ko.observable( "JSON" );
    self.responseAsJSON = ko.computed(function() {
        return ( self.responseFormat() == "JSON" );
    });
    self.responseAsObject = ko.computed(function() {
        if( self.responseFormat() == "Object" )
        {
            // Handle response object.
            HandleResponse();

            return true;
        }
        return false;
    });

    //
    // SERVICE CALL.
    //
    self.call = function() {
        // Call and set JSON text.
        $.get( self.request(), function(theData){
            self.responseJSON(theData);
            self.responseOBJECT( JSON.parse(theData) );
        });

        // Handle response object.
        HandleResponse();
    };

    //
    // Handle response object.
    //
    function HandleResponse() {
        // Only if object is defined.
        if( typeof( self.responseOBJECT() ) != "undefined" )
        {
            // Toggle visibility switch.
            self.hasResponse(true);

            // Handle status block.
            HandleStatusBlock();

            // Handle request block.
            HandleRequestBlock();

            // Handle connection block.
            HandleConnectionBlock();

            // Handle data block.
            HandleDataBlock();

        } // Object is defined.

    }

    //
    // Handle status block.
    //
    function HandleStatusBlock() {
        self.hasStatus(typeof( self.responseOBJECT().status ) == "object" );
        self.statusState( ( self.hasStatus() ) ? self.responseOBJECT().status.state : "" );
        self.hasStatusMessage( self.hasStatus()
            && (typeof( self.responseOBJECT().status.message ) != "undefined") );
        self.statusMessage( ( self.hasStatusMessage() ) ? self.responseOBJECT().status.message : "" );
        self.hasStatusTotal( self.hasStatus()
            && (typeof( self.responseOBJECT().status.total ) != "undefined") );
        self.statusTotal( ( self.hasStatusTotal() ) ? self.responseOBJECT().status.total : "" );
        self.hasStatusCount( self.hasStatus()
            && (typeof( self.responseOBJECT().status.count ) != "undefined") );
        self.statusCount( ( self.hasStatusCount() ) ? self.responseOBJECT().status.count : "" );
        self.hasStatusStart( self.hasStatus()
            && (typeof( self.responseOBJECT().status.start ) != "undefined") );
        self.statusStart( ( self.hasStatusStart() ) ? self.responseOBJECT().status.start : "" );
        self.hasStatusLimit( self.hasStatus()
            && (typeof( self.responseOBJECT().status.limit ) != "undefined") );
        self.statusLimit( ( self.hasStatusLimit() ) ? self.responseOBJECT().status.limit : "" );
    }

    //
    // Handle request block.
    //
    function HandleRequestBlock() {
        self.hasRequest( typeof( self.responseOBJECT().request ) == "object" );
        self.hasRequestOperation( self.hasRequest()
            && (typeof( self.responseOBJECT().request.operation ) != "undefined") );
        self.requestOperation( ( self.hasRequestOperation() ) ? self.responseOBJECT().request.operation : "" );
        self.hasRequestModifiers( self.hasRequest()
            && (typeof( self.responseOBJECT().request.modifiers ) != "undefined") );
        self.requestModifiers([]);
        if( self.hasRequestModifiers )
        {
            for( var tag in self.responseOBJECT().request.modifiers )
                self.requestModifiers().push(tag);
        }
    }

    //
    // Handle connection block.
    //
    function HandleConnectionBlock() {
        self.hasConnection( typeof( self.responseOBJECT().connection ) == "object" );
        self.hasConnectionServer( self.hasConnection()
            && (typeof( self.responseOBJECT().connection.server ) != "undefined") );
        self.connectionServer( ( self.hasConnectionServer() ) ? self.responseOBJECT().connection.server : "" );
        self.hasConnectionDatabase( self.hasConnection()
            && (typeof( self.responseOBJECT().connection.database ) != "undefined") );
        self.connectionDatabase( ( self.hasConnectionDatabase() ) ? self.responseOBJECT().connection.database : "" );
        self.hasConnectionCollection( self.hasConnection()
            && (typeof( self.responseOBJECT().connection.collection ) != "undefined") );
        self.connectionCollection( ( self.hasConnectionCollection() ) ? self.responseOBJECT().connection.collection : "" );
    }

    //
    // Handle data block.
    //
    function HandleDataBlock() {
        self.hasData( typeof( self.responseOBJECT().data ) == "object" );
    }
}

//
// Instantiate model.
//
var myModel = new MyViewModel();

//
// Apply bindings.
//
ko.applyBindings( myModel );
