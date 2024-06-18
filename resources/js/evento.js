// When the window finishes loading
window.onload = function () {
    // Initialize Stripe payment button if present
    // let pagarButton = document.getElementById('pagar'); // Ensure button with ID 'pagar' exists
    // if (pagarButton) {
    //     pagarButton.addEventListener('click', pasarelaCompra);
    // }

    // Initialize Swiper for carousel/slider
    var swiper = new Swiper(".mySwiper", {
        slidesPerView: 3,
        spaceBetween: 30,
        loop: true,
        autoplay: {
            delay: 3500, // Auto-play delay in milliseconds
            disableOnInteraction: false, // Continue autoplay after user interaction
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true, // Allow pagination bullets to be clickable
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
    });

    // Add event listeners to play/pause buttons for each artist
    let playPauseButtons = document.querySelectorAll('[id^="playPauseButton"]');
    playPauseButtons.forEach(button => {
        button.addEventListener('click', function () {
            // Extract artist ID from button's ID
            let artistaId = this.id.replace('playPauseButton', '');
            togglePlayPause(artistaId);
        });
    });

    // Quantity selector functionality
    let decreaseButton = document.getElementById('decrease');
    let increaseButton = document.getElementById('increase');
    let quantityDisplay = document.getElementById('quantity');
    let pagarButton = document.getElementById('pagar');
    let eventoPrecio = parseFloat(pagarButton.getAttribute('data-precio')); // Get event price
    let quantity = parseInt(quantityDisplay.textContent, 10);
    let maxTickets = 10; // Maximum number of tickets

    function updateButtons() {
        // Disable/enable decrease and increase buttons based on quantity
        decreaseButton.disabled = quantity <= 1;
        increaseButton.disabled = quantity >= maxTickets;
    }

    function updateTotalPrice() {
        // Update total price based on quantity selected
        pagarButton.textContent = `Pay: ${quantity * eventoPrecio}€`;
    }

    decreaseButton.addEventListener('click', function () {
        // Decrease quantity button click handler
        if (quantity > 1) {
            quantity--;
            quantityDisplay.textContent = quantity;
            updateButtons();
            updateTotalPrice();
        }
    });

    increaseButton.addEventListener('click', function () {
        // Increase quantity button click handler
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

// Function to handle Stripe checkout process
async function pasarelaCompra() {
    let stripe = Stripe('pk_test_51PQ6aQLDBgcsEFMiQYBnEs7M0EArNiudZxQPUE2Tpn6vfEWI5tEWMoM5Lv83hWARUzRam9QkXdGZpo34JbSM7Ni600UtyCfy1m');

    let {
        error
    } = await stripe.redirectToCheckout({
        lineItems: [{
            price: 'PRICE_ID', // Replace with actual price ID from Stripe
            quantity: 1
        }],
        mode: 'payment',
        successUrl: 'http://localhost:8888/success.html', // URL to redirect after successful payment
        cancelUrl: 'http://localhost:8888/cancel.html', // URL to redirect after canceled payment
    });

    if (error) {
        console.error(error);
    }
}

// Function to toggle play/pause of SoundCloud widget
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

// DOMContentLoaded event listener to handle modal display
document.addEventListener('DOMContentLoaded', function () {
    let modal = document.getElementById('paymentModal'); // Get the payment modal element
    let btn = document.getElementById('pagar'); // Get the pay button element
    let span = document.getElementsByClassName('close')[0]; // Get the close button element within the modal

    // Show modal when pay button is clicked
    btn.onclick = function () {
        modal.style.display = 'block';
    }

    // Close modal when close button inside modal is clicked
    span.onclick = function () {
        modal.style.display = 'none';
    }

    // Close modal when clicking outside the modal content
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    }
});
