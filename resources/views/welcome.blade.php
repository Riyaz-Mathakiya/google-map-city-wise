<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        .text-center {
            text-align: center;
        }

        #map {
            width: 100%;
            height: 400px;
        }
    </style>
</head>

<body>
    <h1 class="text-center">Laravel Google Maps</h1>
    <div id="map"></div>

    <!-- Google Maps JavaScript API -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA3k-BUtdbWY_lDCK_S4yE1M0hyJqeQu0I&callback=initMap" async defer></script>

    <script>
        let map, activeInfoWindow, markers = [];

        /* ----------------------------- Initialize Map ----------------------------- */
        function initMap() {
            map = new google.maps.Map(document.getElementById("map"), {
                center: {
                    lat: 20.5937, // Center of India
                    lng: 78.9629
                },
                zoom: 5
            });

            map.addListener("click", function(event) {
                mapClicked(event);
            });

            initMarkers();
        }

        /* --------------------------- Initialize Markers --------------------------- */
        function initMarkers() {
            const initialMarkers = <?php echo json_encode($initialMarkers); ?>;

            initialMarkers.forEach((markerData, index) => {
                const marker = new google.maps.Marker({
                    position: markerData.position,
                    label: markerData.label,
                    draggable: markerData.draggable,
                    map: map
                });
                markers.push(marker);

                const infowindow = new google.maps.InfoWindow({
                    content: `<b>${markerData.position.lat}, ${markerData.position.lng}</b>`,
                });

                marker.addListener("click", () => {
                    if (activeInfoWindow) {
                        activeInfoWindow.close();
                    }

                    infowindow.open(map, marker);
                    activeInfoWindow = infowindow;
                    markerClicked(marker, index);
                });

                marker.addListener("dragend", (event) => {
                    markerDragEnd(event, index);
                });
            });
        }

        /* ------------------------- Handle Map Click Event ------------------------- */
        function mapClicked(event) {
            console.log('Map clicked at:', event.latLng.lat(), event.latLng.lng());
        }

        /* ------------------------ Handle Marker Click Event ----------------------- */
        function markerClicked(marker, index) {
            console.log(`Marker ${index} clicked at:`, marker.position.lat(), marker.position.lng());
        }

        /* ----------------------- Handle Marker DragEnd Event ---------------------- */
        function markerDragEnd(event, index) {
            console.log(`Marker ${index} dragged to:`, event.latLng.lat(), event.latLng.lng());
        }
    </script>
</body>

</html>
