// IE fix
if (!document.getElementsByClassName) {
	document.getElementsByClassName = function (className) {
		return document.querySelectorAll('.' + className); 
	};
}

if (!Array.prototype.indexOf) {
    Array.prototype.indexOf = function(obj) {
         for (var i = 0, j = this.length; i < j; i++) {
             if (this[i] === obj) { return i; }
         }
         return -1;
    };
}

function DateHelper() {
    
    var self = this;
    
	/**
     * decrease with one day current value
     * 
     * x - current timestamp
     * return timestamp
     */
    this.minus1Day = function(x,e) {
    	var now = new Date(x);
	 	var next = new Date(Date.UTC(now.getFullYear(), now.getUTCMonth(), (now.getUTCDate() - 1),0,0,0));
	 	return next.getTime();
    }
    
    /**
     * increase with one day current value
     * 
     * x - current timestamp
     * return timestamp
     */
    this.plus1Day = function(x,e) {
    	var now = new Date(x);
	 	var next = new Date(Date.UTC(now.getFullYear(), now.getUTCMonth(), (now.getUTCDate() + 1),0,0,0));
	 	return next.getTime();
    }
    
    /**
     * format a date
     * 
     * current - current timestamp
     * format - desired format
     */
    this.toCustom = function(current, format) {

    	var d = new Date(parseInt(current));
		var translated = [];
		translated['j'] = d.getUTCDate();
		translated['d'] = d.getUTCDate() < 10 ? '0' + d.getUTCDate() : d.getUTCDate();
		translated['m'] = (d.getUTCMonth() + 1) < 10 ? ( '0' + (d.getUTCMonth() + 1) ) : (d.getUTCMonth() + 1);
		translated['n'] = parseInt(d.getUTCMonth()) + 1;
		translated['Y'] = d.getFullYear();
		translated['y'] = translated['Y'].toString().slice(2,4);
		translated['F'] = DateConfig.months[d.getUTCMonth()];
		translated['M'] = translated['F'].slice(0,3);
		return format.replace(/(D|d|m|M|n|j|F|Y|y)/g, function(match) { return translated[match]; });
	};    

	this.toTimestamp = function(x,source) {
		
		if (x == 0) {
			var date = new Date();
			var els = new Array();
			els[0] = date.getFullYear(); 
			els[1] = date.getUTCMonth();
			els[2] = date.getUTCDate();
			source = 'js';
		} else {
			var els = x.split('-');
		}
		
		if (source == 'php') {
			var d = new Date(Date.UTC( parseInt(els[0]), parseInt(els[1])-1, parseInt(els[2]), 0, 0, 0));
		} else {
			var d = new Date(Date.UTC( parseInt(els[0]), parseInt(els[1]), parseInt(els[2]), 0, 0, 0));
		}
		return d.getTime();
	}
}



function MedialUtilities() {

    var self = this;

    this.getAjax = function() {
        if (window.XMLHttpRequest) {
            return new window.XMLHttpRequest;
        }
        else {
            try {
                return new ActiveXObject("MSXML2.XMLHTTP.3.0");
            }
            catch(ex) {
                return null;
            }
        }
    };


    this.makeAjaxCall = function(url,method,params,handler) {
        
        var oReq = self.getAjax();
        if (oReq != null) {
            oReq.open(method, url, true);
            oReq.onreadystatechange=function() {
                if (oReq.readyState==4 && oReq.status==200 && handler) {
                    handler(oReq.responseText);
                }
            }
            if (method == 'POST') {
                 oReq.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            }
            oReq.send(params);
        }
    };


    /**
     * return a node parent corresponding to filter criteria
     * filter can be a class name ".class" or a element.class "div.class"
     */
    this.getParent = function(node,filter) {

        var result = node.parentElement;

        if (filter) {
            if (filter.indexOf('.') != -1) {
                var filters = filter.split('.');
                var className = filters[1];
                filter = filters[0];
            }

            while((filter != '' && node.tagName.toLowerCase() != filter) || (className != undefined && node.className.indexOf(className) == -1)) {
                node = node.parentElement;                
            }
        
            result = node;
        } 
        return result;
    };

    // check if element "el" has class "needle"
    this.hasClass = function(el,needle) {
        if (el.className.indexOf(needle) != -1) {
            return true;
        }
        return false;
    };


    // add class to a node element
    this.addClass = function(el,added) {
        el.className += ' ' + added;
        return el;
    };


    // remove class from a node element
    this.removeClass = function(el,removed) {
        el.className = el.className.replace(removed, '');
        return el;
    }


}
