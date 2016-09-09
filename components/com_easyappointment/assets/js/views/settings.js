var utils = new MedialUtilities();

var tbb = {
    toggleState : function(checkbox) {
        var price = document.getElementById('price_' + checkbox.value);
        if (utils.hasClass(price,'hidden')) {
           checkbox.checked && utils.removeClass(price, 'hidden');   
        } else {
             utils.addClass(price, 'hidden');
        }
    },

    save : function() {
        document.adminForm.task.value = 'settings.save';
        document.adminForm.submit();
    },
};


window.addEventListener('load',function() {
    var services = document.getElementsByClassName('services');
    for (var i=0; i<services.length; i++) {
        var x = services[i];
        if (x.checked) {
             tbb.toggleState(x);
        }
        services[i].addEventListener('click', function() {
            tbb.toggleState(this);
        });
    }    
});
