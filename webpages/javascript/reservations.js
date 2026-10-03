// Function to toggle visible fields based on Hotel or Zoo selection
function toggleBookingType() {
    const bookingTypeSelect = document.getElementById('booking_type');
    if (!bookingTypeSelect) return;

    const bookingType = bookingTypeSelect.value;

    const roomField = document.getElementById('field_room');
    const peopleField = document.getElementById('field_people_amount');
    const timeField = document.getElementById('field_time');
    const ticketField = document.getElementById('field_ticket_amount');

    if (bookingType === 'hotel') {
        if (roomField) roomField.style.display = 'flex';
        if (peopleField) peopleField.style.display = 'flex';
        if (timeField) timeField.style.display = 'none';
        if (ticketField) ticketField.style.display = 'none';
    } else if (bookingType === 'zoo') {
        if (roomField) roomField.style.display = 'none';
        if (peopleField) peopleField.style.display = 'none';
        if (timeField) timeField.style.display = 'flex';
        if (ticketField) ticketField.style.display = 'flex';
    } else {
        if (roomField) roomField.style.display = 'none';
        if (peopleField) peopleField.style.display = 'none';
        if (timeField) timeField.style.display = 'none';
        if (ticketField) timeField.style.display = 'none';
    }

    calculateTotal();
}

function calculateTotal() {
    const bookingTypeSelect = document.getElementById('booking_type');
    const totalDisplay = document.getElementById('total_amount');
    if (!bookingTypeSelect || !totalDisplay) return;

    const bookingType = bookingTypeSelect.value;
    let total = 0;

    if (bookingType === 'hotel') {
        const roomSelect = document.getElementById('room_type');

        const peopleSelect = document.getElementById('people_amount'); 
        
        const roomRate = roomSelect ? (parseFloat(roomSelect.value) || 0) : 0;
        const peopleCount = peopleSelect ? (parseInt(peopleSelect.value) || 1) : 1; 
        
        // Multiply room price by number of people
        total = roomRate * peopleCount; 
        
    } else if (bookingType === 'zoo') {
        const ticketSelect = document.getElementById('ticket_amount');
        const ticketCount = ticketSelect ? (parseInt(ticketSelect.value) || 0) : 0;
        const ticketPrice = 20; 
        total = ticketCount * ticketPrice;
    }

if (totalDisplay.tagName === 'INPUT') {
        totalDisplay.value = total.toFixed(2);
    } else {
        totalDisplay.textContent = total.toFixed(2);
    }
}

// Automatically trigger on page load and attach real-time event listeners
document.addEventListener('DOMContentLoaded', function () {
    // 1. Initialise the page states on load
    toggleBookingType();

    // 2. Listen for changes on the Booking Type dropdown
    const bookingTypeSelect = document.getElementById('booking_type');
    if (bookingTypeSelect) {
        bookingTypeSelect.addEventListener('change', toggleBookingType);
    }

    // 3. Listen for changes on Hotel inputs
    const roomSelect = document.getElementById('room_type');
    const peopleSelect = document.getElementById('people_amount');
    
    if (roomSelect) roomSelect.addEventListener('change', calculateTotal);
    // 'input' is used for number fields so it updates immediately when typing or clicking arrows
    if (peopleSelect) peopleSelect.addEventListener('input', calculateTotal); 

    // 4. Listen for changes on Zoo inputs
    const ticketSelect = document.getElementById('ticket_amount');
    if (ticketSelect) ticketSelect.addEventListener('input', calculateTotal);
});