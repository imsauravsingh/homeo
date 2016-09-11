var utils = new MedialUtilities();

var tbb = {

    id:0,

    updateIntervals: function(d){
        
        var url = tbb.root + 'index.php?option=com_easyappointment&task=schedules.newRow&' + tbb.token;
        var params = 'info[id]=' + d.id + '&info[start]=' + d.start + '&info[end]=' + d.end + '&info[user]=' + tbb.user; 
        utils.makeAjaxCall(url,'POST',params,function(msg) {
            var response = JSON.parse(msg);
            if (document.getElementById('intervals_for_' + d.id))
            {
                document.getElementById('intervals_for_' + d.id).innerHTML = '<td>'+response.start+'</td><td>'+response.end+'</td><td></td>';
            }
            else
            {
                var t = document.getElementById('table-'+d.id);
                t.tBodies[0].innerHTML += '<tr class="intervals"><td>'+response.start+'</td><td>'+response.end+'</td><td></td></tr>';
            }
        });
    },

    changeDayStatus: function(d,el) {
        var url = tbb.root + 'index.php?option=com_easyappointment&task=schedules.changeDayStatus&' + tbb.token;
        var params = 'info[id]=' + d.id + '&info[status]=' + d.status + '&info[user]=' + tbb.user;
        utils.makeAjaxCall(url,'POST',params,function(msg) {
            var response = JSON.parse(msg);
            var child = (document.getElementById('status-for-'+d.id).firstElementChild||document.getElementById('status-for-'+d.id).firstChild);
            child.innerHTML = response.status;
            el.target.innerHTML = response.button;
            el.target.attributes['data-status'].value = d.status;
        });
    },

    deleteInterval: function(parentN,data) {
        var url = tbb.root + 'index.php?option=com_easyappointment&task=schedules.deleteInterval&' + tbb.token;
        var params = 'info[id]=' + data['id'] + '&info[start]=' + data['start'] + '&info[end]=' + data['end'];
        utils.makeAjaxCall(url,'POST',params,function(msg) {
            parentN.remove()
        });
    },

    newSpecialDay: function() {
        document.adminForm.task.value = 'special.addNew';
        document.adminForm.submit();
    },

    deleteSpecialDay: function(el) {
        var url = tbb.root + 'index.php?option=com_easyappointment&task=schedules.delSpecialDay&' + tbb.token;
        var date = el.target.attributes['data-date'].value;
        var params = 'info[date]=' + date;
        utils.makeAjaxCall(url,'POST',params,function(msg) {
           utils.getParent(el.target,'.specials').remove();
        });
    },

    hideAddForm : function() {
        document.getElementById('addSchedule').style.display = 'none';
        document.getElementById('addSchedule').style.zIndex = '0';
    },
};

window.addEventListener('load',function() {

    var buttonsAdd = document.querySelectorAll('.btn-add');
    var buttonsToggle = document.querySelectorAll('.btn-toogle-work');
    var buttonsDel = document.querySelectorAll('.btn-del');
    var buttonsDelSpecial = document.querySelectorAll('.btn-del-special');

    for (var i=0;i<buttonsAdd.length;i++){

        // attach display popup form
        buttonsAdd[i].addEventListener('click', function(el) {
            if (el.preventDefault) {
                el.preventDefault();
            } else {
                el.returnValue = false;
            }
            var schedule = document.getElementById('addSchedule');
            var addForm = document.querySelector('#addSchedule .panel');
            schedule.style.display = 'block';schedule.style.zIndex = '99999';schedule.style.width = window.screen.width + 'px';schedule.style.height = window.screen.height + 'px';schedule.style.background = '#000';schedule.style.position = 'fixed';schedule.style.left = 0;schedule.style.top = 0;schedule.style.opacity = 1;
            addForm.style.display = 'block';addForm.style.zIndex = '99999';addForm.style.width = window.screen.width / 2 + 'px';addForm.style.height = window.screen.width / 4 + 'px';addForm.style.margin = '30px auto';
            tbb.id = el.target.attributes['data-id'].value;
        });


        // attach toggle day state
        buttonsToggle[i].addEventListener('click', function(el) {
            if (el.preventDefault) {
                el.preventDefault();
            } else {
                el.returnValue = false;
            }
            var d = {};
            d.id = el.target.attributes['data-id'].value;
            d.status = el.target.attributes['data-status'].value == 0 ? 1 : 0;
            tbb.changeDayStatus(d,el);
        });
    }

    // attach delete event
    for (var i=0;i<buttonsDel.length;i++) {
        buttonsDel[i].addEventListener('click', function(el) {
            if (el.preventDefault) {
                el.preventDefault();
            } else {
                el.returnValue = false;
            }
            var parent = utils.getParent(el.target, '.intervals');
            var data = {};
            data.id = el.target.attributes['data-id'].value;
            data.start = parent.children[0].attributes['data-value'].value;
            data.end = parent.children[1].attributes['data-value'].value;
            data.user = tbb.user;
            tbb.deleteInterval(parent,data);
        });
    }

    // attach cancel popup form
    document.getElementById('btn-cancel').addEventListener('click', function(el) {
        if (el.preventDefault) {
            el.preventDefault();
        } else {
            el.returnValue = false;
        }
         tbb.hideAddForm();
    });


    // attach delete special days
    for (var i=0; i<buttonsDelSpecial.length;i++) {
        buttonsDelSpecial[i].addEventListener('click', function(el) {
            if (el.preventDefault) {
                el.preventDefault();
            } else {
                el.returnValue = false;
            }
             tbb.deleteSpecialDay(el);
        });
    }
   


    // attach save interval event 
    document.getElementById('btn-save').addEventListener('click', function(el) {
        if (el.preventDefault) {
            el.preventDefault();
        } else {
            el.returnValue = false;
        }
        var newinput = {};
        newinput.start = document.getElementById('addStart').value;
        newinput.end = document.getElementById('addEnd').value;
        newinput.id = tbb.id;
        
        if (Number(newinput.start) > 0 && Number(newinput.end) >0) {
            tbb.updateIntervals(newinput);
        }
        tbb.hideAddForm();
    });
});
