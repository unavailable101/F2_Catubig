document.getElementById('accountType').addEventListener('change', function(){
    var orgField = document.getElementById('orgField');
    if (this.value === 'admin'){
        orgField.style.display = 'block';
        orgField.querySelector('input').required = true;
    }
    if (this.value === 'user') {
        orgField.style.display = 'none';
        orgField.querySelector('input').required = false;
    }
});