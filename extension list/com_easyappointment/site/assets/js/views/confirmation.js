// set event handlers and intialize date
window.addEventListener('load',function() {
    document.getElementById('continue').addEventListener('click', nextstep);
});

function nextstep(el) {
    if (el.preventDefault) { el.preventDefault(); } else { el.returnValue = false; }
    if (validForm() == true) {
        document.infoForm.task.value = 'confirmation.finish';
        document.infoForm.submit();
    }
    return false;
}

function validForm() {
    var el = document.querySelectorAll('input.booking-form.required');
    for (var i=0; i<el.length; i++) {
        if (!el[i].value) {
           	console.log('required field'); 
		return false;
        }
    }
    return true;
}
