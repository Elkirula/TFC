window.onload = function () {
    // let pagarButton = document.getElementById('pagar'); // Asegúrate de que el botón tenga este ID
    // if (pagarButton) {
    //     pagarButton.addEventListener('click', pasarelaCompra);
    // }



    var swiper = new Swiper(".mySwiper", {
        slidesPerView: 3,
        spaceBetween: 30,
        loop: true,
        autoplay: {
            delay: 3500, 
            disableOnInteraction: false, 
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
    });



 let playPauseButtons = document.querySelectorAll('[id^="playPauseButton"]');
 playPauseButtons.forEach(button => {
     button.addEventListener('click', function () {
         let artistaId = this.id.replace('playPauseButton', '');
         togglePlayPause(artistaId);
     });
 });

    let decreaseButton = document.getElementById('decrease');
    let increaseButton = document.getElementById('increase');
    let quantityDisplay = document.getElementById('quantity');
    let pagarButton = document.getElementById('pagar');
    let eventoPrecio = parseFloat(pagarButton.getAttribute('data-precio')); // Obtener el precio del evento
    let quantity = parseInt(quantityDisplay.textContent, 10);
    let maxTickets = 10; // Define el número máximo de tickets

    function updateButtons() {
        decreaseButton.disabled = quantity <= 1;
        increaseButton.disabled = quantity >= maxTickets;
    }

    function updateTotalPrice() {
        pagarButton.textContent = `Pagar: ${quantity * eventoPrecio}€`;
    }

    decreaseButton.addEventListener('click', function () {
        if (quantity > 1) {
            quantity--;
            quantityDisplay.textContent = quantity;
            updateButtons();
            updateTotalPrice();
        }
    });

    increaseButton.addEventListener('click', function () {
        if (quantity < maxTickets) {
            quantity++;
            quantityDisplay.textContent = quantity;
            updateButtons();
            updateTotalPrice();
        }
    });

    // Initial call to set button states and total price
    updateButtons();
    updateTotalPrice();
}

async function pasarelaCompra() {
    let stripe = Stripe('pk_test_51PQ6aQLDBgcsEFMiQYBnEs7M0EArNiudZxQPUE2Tpn6vfEWI5tEWMoM5Lv83hWARUzRam9QkXdGZpo34JbSM7Ni600UtyCfy1m');

    let {
        error
    } = await stripe.redirectToCheckout({
        lineItems: [{
            price: 'PRICE_ID',
            quantity: 1
        }],
        mode: 'payment',
        successUrl: 'http://localhost:8888/success.html',
        cancelUrl: 'http://localhost:8888/cancel.html',
    });

    if (error) {
        console.error(error);
    }
}

function togglePlayPause(artistaId) {
    var iframe = document.getElementById(`sc-player${artistaId}`);
    var widget = SC.Widget(iframe);
    var playPauseButton = document.getElementById(`playPauseButton${artistaId}`);

    widget.isPaused(function (paused) {
        if (paused) {
            widget.play();
            playPauseButton.classList.remove('fa-play');
            playPauseButton.classList.add('fa-pause');
        } else {
            widget.pause();
            playPauseButton.classList.remove('fa-pause');
            playPauseButton.classList.add('fa-play');
        }
    });
}

document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('paymentModal');
    const btn = document.getElementById('pagar');
    const span = document.getElementsByClassName('close')[0];

    btn.onclick = function () {
        modal.style.display = 'block';
    }

    span.onclick = function () {
        modal.style.display = 'none';
    }

    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    }
});
