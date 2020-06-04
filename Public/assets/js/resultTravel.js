/**
 *  @title : resultTravel.js
 *  @author : Matthis HOULES
 *  @author : Guillaume RISCH
 * 
 *  @brief : Search & create travels js page, 
 *              map display, 
 *              cities autocompleted inputs, 
 *              directions viewer on map, 
 *              travel time estimated with time & date inputs. 
 */


/*
    const var availables : 
        departureCity : string : city of departure
        arrivalCity : string : city of arrival
        dayDeparture : string : date of departure
        timeDeparture : string : time of departure.
*/


/**
 *  @name : initMap
 *  @author : Matthis HOULES
 *  @author : Guillaume RISCH
 * 
 *  @brief : callback GoogleMap init.
 *  
 */
function initMap() {
    
    // Map display
    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 8,
        center: {lat: 43.3, lng: 5.4},
        disableDefaultUI: true,
    });    


    // directions 
    directionsService = new google.maps.DirectionsService;
    directionsDisplay = new google.maps.DirectionsRenderer;
    directionsDisplay.setMap(map);



    directionsService.route({
        origin: document.getElementById('departureCity').innerText,

        destination: document.getElementById('arrivalCity').innerText,

        travelMode: 'DRIVING'

    }, function(response, status) {

        if (status === 'OK') {
          directionsDisplay.setDirections(response);

        } else {
          console.log('Directions request failed due to ' + status);

        }
    });



}