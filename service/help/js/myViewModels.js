/**
 * Created with JetBrains PhpStorm.
 * User: milko
 * Date: 8/8/13
 * Time: 13:28
 * To change this template use File | Settings | File Templates.
 */

//
// PING view model.
//
function MyiewModel() {
    var self = this;

    self.pingURL = ko.observable("http://localhost/lib/GeoFeatures/service/GeoFeatures.php?ping");
    self.pingDATA = "";
    self.pingCALL = function() {
        $.get(self.pingURL, {}, self.pingDATA);
    }
}

// Activates knockout.js
ko.applyBindings(new MyiewModel());