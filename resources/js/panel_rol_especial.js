let clickCounter = 0; // Variable to count clicks for creating artists

window.onload = function () {
    // When the window loads
    var menuToggle = document.getElementById('menu-toggle');
    var wrapper = document.getElementById('wrapper');

    // Toggle menu functionality
    if (menuToggle && wrapper) {
        menuToggle.addEventListener('click', function (e) {
            e.preventDefault();
            wrapper.classList.toggle('toggled');
        });
    }

    // Ensure page content wrapper is visible
    document.getElementById('page-content-wrapper').classList.remove('hidden');

    // Event listeners for various buttons and locations
    btn_home.addEventListener('click', home);
    btn_nevo.addEventListener('click', createEvent);
    location_presencial.addEventListener('click', loadMap);
    btn_cuenta.addEventListener('click', accountA);
    location_online.addEventListener('click', showLink);
}

function home() {
    // Show home content, hide others
    document.getElementById('account').classList.add('hidden');
    document.getElementById('new').classList.add('hidden');
    document.getElementById('page-content-wrapper').classList.remove('hidden');
}

function createEvent() {
    // Show create event form, hide others
    document.getElementById('account').classList.add('hidden');
    document.getElementById('page-content-wrapper').classList.add('hidden');
    document.getElementById('new').classList.remove('hidden');

    // Event listeners for adding and deleting artists
    more.addEventListener('click', createArtist);
    less.addEventListener('click', deleteArtist);
}

function accountA() {
    // Show account details, hide others
    document.getElementById('new').classList.add('hidden');
    document.getElementById('page-content-wrapper').classList.add('hidden');
    document.getElementById('account').classList.remove('hidden');
}

function createArtist() {
    // Function to create new artist inputs dynamically
    if (clickCounter < 3) {
        // Create the div element with the "border" class
        var divBorder = document.createElement("div");
        divBorder.classList.add("border");

        // Create input fields for artist name, description, music, and image upload
        var div1 = document.createElement("div");
        div1.classList.add("mb-3");
        div1.innerHTML = '<label for="artistName" class="form-label">Artist Name</label><input type="text" class="form-control" name="artistName[]" required>';

        var div2 = document.createElement("div");
        div2.classList.add("mb-3");
        div2.innerHTML = '<label for="artistDescription" class="form-label">Artist Description</label><input type="text" class="form-control" name="description[]" required>';

        var div3 = document.createElement("div");
        div3.classList.add("mb-3");
        div3.innerHTML = '<label for="artistMusic" class="form-label">Artist Music</label><input type="text" class="form-control" name="artistMusic[]" required>';

        var div4 = document.createElement("div");
        div4.classList.add("mb-3");
        div4.innerHTML = '<label for="artistImage" class="form-label">Upload Image</label><input type="file" class="form-control" name="artistImg[]" accept="image/*" required>';

        // Append all created elements to the container
        divBorder.appendChild(div1);
        divBorder.appendChild(div2);
        divBorder.appendChild(div3);
        divBorder.appendChild(div4);
        container_multimedia.appendChild(divBorder);

        // Limit to 3 artists, disable add button after limit reached
        if (clickCounter === 3) {
            more.removeEventListener('click', createArtist);
            alert('Maximum of three artists reached.');
        }
        clickCounter++;
    }
}

function deleteArtist() {
    // Function to delete the last added artist entry
    let element = container_multimedia.lastChild;
    if (element) {
        container_multimedia.removeChild(element);
    }
}

function loadMap() {
    // Show map for presencial location, hide online content
    onlineContent.classList.add('hidden');
    presencialContent.classList.remove('hidden');

    // Initialize Leaflet map with default center and zoom
    let map = L.map('map', {
        center: [39.4699, -0.3763],
        zoom: 10
    });

    // Add OpenStreetMap tiles to the map
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 24
    }).addTo(map);

    // Add marker to the map
    let marker = L.marker([39.4699, -0.3763]).addTo(map);

    // Function to update map view and marker position based on selected place
    function updateMap(lat, lon) {
        map.setView([lat, lon], 10);
        marker.setLatLng([lat, lon]);

        // Update latitude and longitude inputs
        document.getElementById('latitude').value = lat;
        document.getElementById('longitude').value = lon;
    }

    // Event listener for place selection dropdown
    document.getElementById('place_name').addEventListener('change', function () {
        let place = this.value;

        // Fetch geolocation data for selected place using Nominatim API
        fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${place}`)
            .then(response => response.json())
            .then(data => {
                if (data.length > 0) {
                    let lat = data[0].lat;
                    let lon = data[0].lon;

                    // Update map with new coordinates
                    updateMap(lat, lon);
                    console.log(`Latitude: ${lat}, Longitude: ${lon}`);
                } else {
                    console.error('Place not found');
                }
            })
            .catch(error => console.error('Geocoding error:', error));
    });

    // Delayed resize to handle Leaflet map display
    setTimeout(() => {
        map.invalidateSize();
    }, 500);
}

function showLink() {
    // Show online content, hide presencial map
    presencialContent.classList.add('hidden');
    map.classList.add('hidden');
    onlineContent.classList.remove('hidden');
}
