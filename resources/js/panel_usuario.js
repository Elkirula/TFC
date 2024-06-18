window.onload = function () {
    document.getElementById('cuenta').classList.remove('oculto');

    document.getElementById('btn_cuenta').addEventListener('click', cuenta);
    document.getElementById('btn_amigos').addEventListener('click', amigos);
    document.getElementById('btn_compra').addEventListener('click', compra);
        // Ajax request to send friend request
    // Ajax search for sending friend requests
    $('#searchForm').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            url: '{{ route("buscarAmigos") }}',
            method: 'GET',
            data: $(this).serialize(),
            success: function (response) {
                $('#searchResults').html(response);
            }
        });
    });

    // Ajax request to send friend request
    $(document).on('submit', '.sendRequestForm', function (e) {
        e.preventDefault();
        const form = $(this);
        $.ajax({
            url: form.attr('action'),
            method: 'POST',
            data: form.serialize(),
            success: function (response) {
                alert('Friend request sent successfully.');
                // Optionally, you can update the list of pending requests here
                // Or reload the entire friends section
            }
        });
    });

    // Function to remove a friend via Ajax
    window.eliminarAmigo = function (userId) {
        if (confirm('Are you sure you want to remove this friend?')) {
            $.ajax({
                url: '/panel_usuario/eliminar-amigo/' + userId,
                method: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    alert('Friend removed successfully.');
                    // Optionally, update the list of friends here
                    // Or reload the entire friends section
                }
            });
        }
    };

    // Function to accept a friend request via Ajax
    window.aceptarSolicitud = function (senderId) {
        $.ajax({
            url: '/panel_usuario/aceptar-solicitud/' + senderId,
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function (response) {
                alert('Friend request accepted.');
                // Optionally, update the list of pending requests here
                // Or reload the entire friends section
            }
        });
    };

    // Function to load the chat with a specific user
    window.loadChat = function (userId) {
        fetch(`/chat/${userId}`)
            .then(response => response.text())
            .then(data => {
                document.getElementById('chat').innerHTML = data;
            });
    };

    // Function to send a message via the chat form
    window.sendMessage = function (event) {
        event.preventDefault();
        const formData = new FormData(event.target);
        fetch(event.target.action, {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                document.getElementById('chat').innerHTML = data;
            });
    };
}

function cuenta() {
    document.getElementById('cuenta').classList.remove('oculto');
    document.getElementById('compra').classList.add('oculto');
    document.getElementById('amigos').classList.add('oculto');
}

function amigos() {
    document.getElementById('amigos').classList.remove('oculto');
    document.getElementById('compra').classList.add('oculto');
    document.getElementById('cuenta').classList.add('oculto');
}

function compra() {
    document.getElementById('compra').classList.remove('oculto');
    document.getElementById('amigos').classList.add('oculto');
    document.getElementById('cuenta').classList.add('oculto');
}

