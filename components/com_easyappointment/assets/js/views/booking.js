var dat = new DateHelper(); 
var utils = new MedialUtilities();

var tbb = {

    changedate : function(d) {
        var timestamp = dat.toTimestamp(d);
        document.getElementById('jform_appointmentDate').value = dat.toCustom(timestamp,'Y-m-d');
        tbb.getSchedule();
    },

    getSchedule : function() {
        var service = document.getElementById('jform_service').value;
        var params = 'info[date]=' + document.getElementById('jform_appointmentDate').value + '&info[user]='+tbb.user+'&info[service]='+service+'&'+tbb.token;
        var url = tbb.root + 'index.php?option=com_easyappointment&task=json.getSchedule&tmpl=component';
        
        utils.makeAjaxCall(url,'POST',params,function(msg) {
            var response = JSON.parse(msg);
            if (response.error) {
                tbb.showErrorMessage(response.error);
            } else {

                var startOptions = '', endOptions = '', k = 0, timeframe = 0;

                for (var i in response.value) {
                	if (tbb.startingTime && tbb.startingTime == i) {
                		startOptions += '<option value="'+i+'" selected="selected">'+response.value[i]+'</option>';
                	} else {
                		startOptions += '<option value="'+i+'">'+response.value[i]+'</option>';
                	}
					
                	if (k && tbb.endingTime && tbb.endingTime == i) {
                		 endOptions += '<option value="'+i+'" selected="selected">'+response.value[i]+'</option>'; 
                	} else {
                		endOptions += '<option value="'+i+'">'+response.value[i]+'</option>'; 
                	}
                    
                    k++;
                }
                
                if (tbb.endingTime) {
					if (i < tbb.endingTime) 
					{
						endOptions += '<option selected="selected" value="'+tbb.endingTime+'">'+tbb.endingTimeD+'</option>'; 
					}
				} else {
						endOptions += '<option value="'+(response.last.value)+'">'+response.last.show+'</option>'; 
				}
				
                
                if (utils.isIE) {
					select_innerHTML(document.getElementById('jform_startingTime'),startOptions);
					select_innerHTML(document.getElementById('jform_endingTime'),endOptions);
				} else {
					document.getElementById('jform_startingTime').innerHTML = startOptions;
					document.getElementById('jform_endingTime').innerHTML = endOptions;
				}
            }
            tbb.checkStaffAvailable();
        });
    },


    checkStaffAvailable : function() {
        var date = document.getElementById('jform_appointmentDate').value;
        var start = document.getElementById('jform_startingTime').value;
        var end = document.getElementById('jform_endingTime').value;

        if (date && start && end) {
            var params = 'info[exclude]='+tbb.id+'&info[date]=' + date + '&info[starthour]=' + start + '&info[endhour]=' + end + '&info[user]='+tbb.user+'&'+tbb.token;
            var url = tbb.root + 'index.php?option=com_easyappointment&task=json.checkStaffAvailable&tmpl=component';
            utils.makeAjaxCall(url,'POST',params,function(msg) {
                var response = JSON.parse(msg);
                if (response.error) {
                    tbb.showErrorMessage(response.error);
                } 
            });
        }
    },

    changeEndHour : function() {
        var start = document.getElementById('jform_startingTime');
        var end = document.getElementById('jform_endingTime');
        var last = start.options[start.options.selectedIndex+1] != undefined ? start.options.selectedIndex+1 : start.options.selectedIndex;
        end.value = start.options[last].value;
    },

    showErrorMessage : function(err) {
        var d = document.getElementById('error-display');
        utils.removeClass(d, 'hidden');
        d.innerHTML = err;
        setTimeout(function() { 
            utils.addClass(d, 'hidden');
        }, 3000);
    },

    save : function() {document.adminForm.task.value='booking.save';document.adminForm.submit();},
    close : function() {document.adminForm.task.value='booking.close';document.adminForm.submit();},
};

// set event handlers and intialize date
window.addEventListener('load',function() {
    document.getElementById('jform_appointmentDate').value && tbb.getSchedule();
    document.getElementById('jform_service').addEventListener('change', tbb.getSchedule);
    document.getElementById('jform_startingTime').addEventListener('change', tbb.changeEndHour);
    document.getElementById('jform_startingTime').addEventListener('change', tbb.checkStaffAvailable);
    document.getElementById('jform_endingTime').addEventListener('change', tbb.checkStaffAvailable);
});

function select_innerHTML(e,t){e.innerHTML="";var n,o=document.createElement("xselect");o.id="xselect1",document.body.appendChild(o),o=document.getElementById("xselect1"),o.style.display="none",t.toLowerCase().indexOf("<option")<0&&(t="<option>"+t+"</option>"),t=t.replace(/<option/g,"<span").replace(/<\/option/g,"</span"),o.innerHTML=t;for(var a=0;a<o.childNodes.length;a++){var l=o.childNodes[a];if(l.tagName){n=document.createElement("OPTION"),document.all?e.add(n):e.appendChild(n);for(var i=0;i<l.attributes.length;i++){var c=l.attributes[i].nodeName,d=l.attributes[i].nodeValue;if(d)try{n.setAttribute(c,d),n.setAttributeNode(l.attributes[i].cloneNode(!0))}catch(r){}}if(l.style)for(var s in l.style)try{n.style[s]=l.style[s]}catch(r){}n.value=l.getAttribute("value"),n.text=l.innerHTML,n.selected=l.getAttribute("selected"),n.className=l.className}}document.body.removeChild(o),o=null}
