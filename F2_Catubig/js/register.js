document.getElementById('accountType').addEventListener('change', function(){
    var orgField = document.getElementById('orgField');
    if (this.value === 'Administrator'){
        orgField.style.display = 'block';
        orgField.querySelector('input').required = true;
    } else {
        orgField.style.display = 'none';
        orgField.querySelector('input').required = false;
    }
})