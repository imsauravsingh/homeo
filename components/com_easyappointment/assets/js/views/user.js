// set event handlers and intialize date
var utils = new MedialUtilities();
var week = 0;

window.addEventListener('load',function() {
    document.getElementById('appointment').addEventListener('click', overlayCalendar);
    document.getElementById('calendar-close').addEventListener('click', closeCalendar);
    document.getElementById('go-back') && document.getElementById('go-back').addEventListener('click', back);
    document.getElementById('go-next') && document.getElementById('go-next').addEventListener('click', next);
    document.getElementById('go-next-cal').addEventListener('click', nextcal);
    document.getElementById('go-back-cal').addEventListener('click', backcal);
});

function overlayCalendar() {
    newdiv = document.createElement('div');
    newdiv.id = 'calendarOverlay';
    newdiv.style.width = window.screen.width + 'px';
    newdiv.style.height = window.screen.height + 'px';
    newdiv.style.position = 'fixed';
    newdiv.style.display = 'block';
    newdiv.style.background = 'rgba(0,0,0,0.8)';
    newdiv.style.zIndex = 9999;
    newdiv.style.top = 0;
    document.getElementsByTagName('body')[0].appendChild(newdiv);
    document.getElementById('calendar').style.zIndex = 99999;
    document.getElementById('calendar').style.position = 'relative';
    document.getElementById('calendar').style.background = 'rgba(255,255,255,1)';
    document.getElementById('calendar-close').style.display = 'block';
}


function closeCalendar() {
    document.getElementById('calendarOverlay').remove();
    document.getElementById('calendar').style.background = '#F4F7FB';
    document.getElementById('calendar-close').style.display = 'none';
}


function back(){if (week == 0) {return false;} else { week -= 1; } if (week >= 0) {getCalendar();}}
function next(){if (week == eamax) {return false;} else {week += 1;} if (week <= eamax) {getCalendar();}}


function getCalendar() {
    var params = 'info[user]=' + eauser + '&info[service]=' + easervice + '&info[week]=' + week + '&' + eatoken;
    var url = earoot + 'index.php?option=com_easyappointment&task=json.getCalendar&tmpl=component';
    utils.makeAjaxCall(url,'POST',params,function(msg) {
        var response = JSON.parse(msg);
        if (!response.error) {
            document.getElementById('calendar-table').innerHTML = response.value;
        }
    });
}

function nextcal() {
	document.getElementById('calendar-table').scrollLeft+= parseInt(document.getElementById('calendar').clientWidth/3);
}

function backcal() {
	document.getElementById('calendar-table').scrollLeft -= parseInt(document.getElementById('calendar').clientWidth/3);
}
