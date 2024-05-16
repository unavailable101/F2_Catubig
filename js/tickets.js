document.getElementById('event-type').addEventListener('change', function(){
    var ticketField = document.getElementById('ticket-field');
    if (this.value === 'PRIVATE' || this.value === 'SEMI-PUBLIC'){
        ticketField.style.display = 'block';
        ticketField.querySelector('input').required = true;
    }
    if (this.value === 'PUBLIC') {
        ticketField.style.display = 'none';
        ticketField.querySelector('input').required = false;
    }
});