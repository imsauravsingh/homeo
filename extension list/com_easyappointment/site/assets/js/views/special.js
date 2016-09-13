var dat = new DateHelper();
var utils = new MedialUtilities();

var tbb = {

    save : function() {
        var date = document.getElementById('jform_date').value;
        var state = document.getElementById('jform_status').value;
   
        if (date) {
            var intervals = tbb.intervals == undefined ? '' : JSON.stringify(tbb.intervals.getvalues());
            var params = 'info[date]='+date+'&info[state]='+state+'&info[intervals]='+intervals+'&info[user]='+tbb.user+'&'+tbb.token;
            var url = tbb.root + 'index.php?option=com_easyappointment&task=special.addNewRecord&tmpl=component';
            utils.makeAjaxCall(url,'POST',params,function(msg) {
                document.location.href = tbb.return;
            });
        }
        return false;
    },

    changedate : function(d) {
        var timestamp = dat.toTimestamp(d);
        document.getElementById('jform_date').value = dat.toCustom(timestamp,'Y-m-d');
    },

    hideAddForm : function() {
        document.getElementById('addSchedule').style.display = 'none';
        document.getElementById('addSchedule').style.zIndex = '0';
    },

    close: function() {
        document.location.href = tbb.return;
    },

    addInterval : function () {
        if(tbb.intervals == undefined) {
            tbb.intervals = new Intervals();
            tbb.visibleIntervals = new Intervals();
        }
        var newinterval = {}, newvisible = {};
        newinterval.start = document.getElementById('addStart').value;
        newinterval.end = document.getElementById('addEnd').value;
        newvisible.start = document.getElementById('addStart').selectedOptions[0].innerHTML;
        newvisible.end = document.getElementById('addEnd').selectedOptions[0].innerHTML;
        tbb.intervals.add(newinterval);
        tbb.visibleIntervals.add(newvisible);
        tbb.displayNewInterval(tbb.visibleIntervals.getvalues());
        console.log(tbb.intervals.getvalues());
    },


    displayNewInterval: function(intervals) {
        var tbdy = document.getElementById('intervals').tBodies[0];
        var addition = '';
        for(var i=0;i<intervals.length;i++) {
            addition += '<tr><td>'+intervals[i].start+'</td><td>'+intervals[i].end+'</td></tr>';
        }
        tbdy.innerHTML = addition;
        tbb.hideAddForm();
    },
};

window.addEventListener('load',function() {

    document.getElementById('btn-save').addEventListener('click', function(el){
        if (el.preventDefault) { el.preventDefault(); } else { el.returnValue = false; }
        tbb.save();
    });
    document.getElementById('btn-close').addEventListener('click', function(el){
        if (el.preventDefault) { el.preventDefault(); } else { el.returnValue = false; }
        tbb.close();
    });

    if ( document.getElementById('btn-add')){
        document.getElementById('btn-add').addEventListener('click', function(el) {
            if (el.preventDefault) { el.preventDefault(); } else { el.returnValue = false; }
            var schedule = document.getElementById('addSchedule');
            var addForm = document.querySelector('#addSchedule .panel');
            schedule.style.display = 'block';schedule.style.zIndex = '99999';schedule.style.width = window.screen.width + 'px';schedule.style.height = window.screen.height + 'px';schedule.style.background = '#000';schedule.style.position = 'fixed';schedule.style.left = 0;schedule.style.top = 0;schedule.style.opacity = 1;
            addForm.style.display = 'block';addForm.style.zIndex = '99999';addForm.style.width = window.screen.width / 2 + 'px';addForm.style.height = window.screen.width / 4 + 'px';addForm.style.margin = '30px auto';
        });
    }

    document.getElementById('btn-add-save').addEventListener('click', function(el){
        if (el.preventDefault) { el.preventDefault(); } else { el.returnValue = false; }
        tbb.addInterval();
    });

    document.getElementById('btn-add-cancel').addEventListener('click', function(el){
        if (el.preventDefault) { el.preventDefault(); } else { el.returnValue = false; }
        tbb.hideAddForm();
    });
});


function Intervals() {
    
    var self = this;
    self.values = [];

    return { 
        add : function(n) {
            self.values.push(n);
            return self.values;
        },

        remove : function(n) {
            var newval = [];
            for (var i=0;i<self.values.length;i++) {
                if (self.values[i].start !== n.start && self.values[i].end !== n.end) {
                    newval.push(self.values[i]);
                }
            }
            self.values = newval;
            return self.values;
        },

        getvalues : function() {
            return self.values;
        },
    };
};
