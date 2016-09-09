var dat = new DateHelper(); 
var tbb = {
    changedate : function(d) {
        var timestamp = dat.toTimestamp(d);
        document.getElementById('calendar-value-php').value = dat.toCustom(timestamp,'Y-m-d');
        document.adminForm.submit();
    },
    
    viewall : function() {
        document.getElementById('calendar-value-php').value = 0;
        document.adminForm.submit();
    },
    
    minus1Day : function() {
        var timestamp = dat.toTimestamp(document.getElementById('calendar-value-php').value, 'php');
        var nexttimestamp = dat.minus1Day(parseInt(timestamp));
        document.getElementById('calendar-value-php').value = dat.toCustom(nexttimestamp,'Y-m-d');
        document.adminForm.submit();
    },
    
    plus1Day : function() {
        var timestamp = dat.toTimestamp(document.getElementById('calendar-value-php').value, 'php');
        var nexttimestamp = dat.plus1Day(parseInt(timestamp));
        document.getElementById('calendar-value-php').value = dat.toCustom(nexttimestamp,'Y-m-d');
        document.adminForm.submit();
    },
    
    
    toogleAll : function() {
        var ids = document.getElementsByClassName('checkbox-id');
        for (var i = 1; i<ids.length; i++) {
            ids[i].checked = !ids[i].checked;
        }
    },

    deleteItems : function() {
        document.adminForm.task.value = 'bookings.delete';
        document.adminForm.submit();
    },

    exportItems : function() {
        document.location.href = tbb.root + "index.php?option=com_easyappointment&view=bookings&format=raw";
    },
};

