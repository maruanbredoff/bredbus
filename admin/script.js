// script.js
$(document).ready(function() {
    // Obtenha o ID da viagem do elemento HTML
    const viagemId = $('#viagem-id').val();
    
    $.ajax({
        url: 'get_seat_status.php',
        type: 'GET',
        data: { idviagem: viagemId },
        success: function(response) {
            const seatStatus = JSON.parse(response);
            for (const seat in seatStatus) {
                if (seatStatus[seat] === 'occupied') {
                    $(`.bus-seat[data-seat="${seat}"]`).addClass('occupied');
                }
            }
        }
    });
});
