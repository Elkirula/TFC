let contadorClicks = 0;


window.onload = function () {
    // Cuando se carga la ventana
    var menuToggle = document.getElementById('menu-toggle');
    var wrapper = document.getElementById('wrapper');

    if (menuToggle && wrapper) {
        menuToggle.addEventListener('click', function (e) {
            e.preventDefault();
            wrapper.classList.toggle('toggled');
        });
    }
    document.getElementById('page-content-wrapper').classList.remove('oculto')

    btn_home.addEventListener('click', home);
    btn_nevo.addEventListener('click', crearEvento);
    location_presencial.addEventListener('click', cargarMapa);
    btn_cuenta.addEventListener('click', cuentaA);
    location_online.addEventListener('click', muestraLink);
}

function home() {
    document.getElementById('cuenta').classList.add('oculto');
    document.getElementById('nuevo').classList.add('oculto');
    document.getElementById('page-content-wrapper').classList.remove('oculto');
}

function crearEvento() {
    document.getElementById('cuenta').classList.add('oculto');
    document.getElementById('page-content-wrapper').classList.add('oculto');
    document.getElementById('nuevo').classList.remove('oculto');

    mas.addEventListener('click', crearArtista);
    menos.addEventListener('click', borrarArtista);
}

function cuentaA() {

    document.getElementById('nuevo').classList.add('oculto');
    document.getElementById('page-content-wrapper').classList.add('oculto');
    document.getElementById('cuenta').classList.remove('oculto');
}

function crearArtista() {
    if (contadorClicks < 3) {
        // Crear el elemento div con la clase "borde"
        var divBorde = document.createElement("div");
        divBorde.classList.add("borde");

        // Crear el primer div con la clase "mb-3" y su contenido
        var div1 = document.createElement("div");
        div1.classList.add("mb-3");
        div1.innerHTML = '<label for="artistName" class="form-label">Nombre del Artista</label><input type="text" class="form-control" name="artistNombre[]" required>';

        // Crear el segundo div con la clase "mb-3" y su contenido
        var div2 = document.createElement("div");
        div2.classList.add("mb-3");
        div2.innerHTML = '<label for="artistName" class="form-label">Descripción del Artista</label><input type="text" class="form-control" name="descripcion[]" required>';

        // Crear el tercer div con la clase "mb-3" y su contenido
        var div3 = document.createElement("div");
        div3.classList.add("mb-3");
        div3.innerHTML = '<label for="artistMusica" class="form-label">Música del Artista</label><input type="text" class="form-control" name="artistMusica[]" required>';

        // Crear el cuarto div con la clase "mb-3" y su contenido
        var div4 = document.createElement("div");
        div4.classList.add("mb-3");
        div4.innerHTML = '<label for="artistImage" class="form-label">Subir Imagen</label><input type="file" class="form-control" name="artistImg[]" accept="image/*" required>';

        // Agregar los divs creados al div con clase "borde"
        divBorde.appendChild(div1);
        divBorde.appendChild(div2);
        divBorde.appendChild(div3);
        divBorde.appendChild(div4);
        container_multimedia.appendChild(divBorde);
        if (contadorClicks === 3) {
            mas.removeEventListener('click', crearArtista);
            alert('Se alcanzó el máximo de tres clics.');
        }
        contadorClicks++;
    }

}

function borrarArtista() {
    let elemento = container_multimedia.lastChild;

    if (elemento) {
        container_multimedia.removeChild(elemento);
    }
}


function cargarMapa() {
    onlineContent.classList.add('oculto');
    presencialContent.classList.remove('oculto');

    const map = L.map('map', {
        center: [39.4699, -0.3763],
        zoom: 10
    });

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 24
    }).addTo(map);

    let marker = L.marker([39.4699, -0.3763]).addTo(map);

    function updateMap(lat, lon) {
        map.setView([lat, lon], 10);
        marker.setLatLng([lat, lon]);

        document.getElementById('latitud').value = lat;
        document.getElementById('longitud').value = lon;
    }

    document.getElementById('nombre_lugar').addEventListener('change', function () {
        const place = this.value;

        fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${place}`)
            .then(response => response.json())
            .then(data => {
                if (data.length > 0) {
                    const lat = data[0].lat;
                    const lon = data[0].lon;

                    updateMap(lat, lon);
                    console.log(`Latitud: ${lat}, Longitud: ${lon}`);
                } else {
                    console.error('Lugar no encontrado');
                }
            })
            .catch(error => console.error('Error en la geocodificación:', error));
    });

    setTimeout(() => {
        map.invalidateSize();
    }, 500);
}


function muestraLink() {
    presencialContent.classList.add('oculto');
    map.classList.add('oculto');
    onlineContent.classList.remove('oculto')
}
