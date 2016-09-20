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

    var $ = jQuery.noConflict();
    function specializationAddMore(){
      $("div.main_specialization_group div:hidden:first").show();        
    }

    function specializationRemove(id){
      $("div#div_specialization"+id+" input").val('');    
      $("div.main_specialization_group div#div_specialization"+id).hide();    
    }

    function awardsAddMore(){
      $("div.main_awards_group div:hidden:first").show();                
    }

    function awardsRemove(id){
      $("div#div_awards"+id+" input").val('');    
      $("div.main_awards_group div#div_awards"+id).hide();    
    }

    function educationAddMore(){
      $("div.main_education_group div:hidden:first").show();                
    }

    function educationRemove(id){
      $("div#div_education"+id+" input").val('');    
      $("div.main_education_group div#div_education"+id).hide();    
    }

    function experienceAddMore(){
      $("div.main_experience_group div:hidden:first").show();                
    }

    function experienceRemove(id){
      $("div#div_experience"+id+" input").val('');    
      $("div.main_experience_group div#div_experience"+id).hide();    
    }
