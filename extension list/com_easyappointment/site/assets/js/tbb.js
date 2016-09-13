// IE fix
document.getElementsByClassName||(document.getElementsByClassName=function(e){return document.querySelectorAll("."+e)});
Array.prototype.indexOf||(Array.prototype.indexOf=function(r){for(var t=0,e=this.length;e>t;t++)if(this[t]===r)return t;return-1});
//addEventListener polyfill 1.0 / Eirik Backer / MIT Licence
!function(e,t){function n(e){var n=t[e];t[e]=function(e){return o(n(e))}}function a(t,n,a){return(a=this).attachEvent("on"+t,function(t){var t=t||e.event;t.preventDefault=t.preventDefault||function(){t.returnValue=!1},t.stopPropagation=t.stopPropagation||function(){t.cancelBubble=!0},n.call(a,t)})}function o(e,t){if(t=e.length)for(;t--;)e[t].addEventListener=a;else e.addEventListener=a;return e}e.addEventListener||(o([t,e]),"Element"in e?e.Element.prototype.addEventListener=a:(t.attachEvent("onreadystatechange",function(){o(t.all)}),n("getElementsByTagName"),n("getElementById"),n("createElement"),o(t.all)))}(window,document);
document.querySelectorAll||(document.querySelectorAll=function(e){var t,n=document.createElement("style"),o=[];for(document.documentElement.firstChild.appendChild(n),document._qsa=[],n.styleSheet.cssText=e+"{x-qsa:expression(document._qsa && document._qsa.push(this))}",window.scrollBy(0,0),n.parentNode.removeChild(n);document._qsa.length;)t=document._qsa.shift(),t.style.removeAttribute("x-qsa"),o.push(t);return document._qsa=null,o}),document.querySelector||(document.querySelector=function(e){var t=document.querySelectorAll(e);return t.length?t[0]:null});
window.Element.prototype.remove||(window.Element.prototype.remove=function(){var e=this.parentNode;e&&e.removeChild(this)});


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
	 	var next = new Date(now.getFullYear(), now.getMonth(), (now.getDate() - 1),0,0,0);
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
	 	var next = new Date(now.getFullYear(), now.getMonth(), (now.getDate() + 1),0,0,0);
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
		translated['j'] = d.getDate();
		translated['d'] = d.getDate() < 10 ? '0' + d.getDate() : d.getDate();
		translated['m'] = (d.getMonth() + 1) < 10 ? ( '0' + (d.getMonth() + 1) ) : (d.getMonth() + 1);
		translated['n'] = parseInt(d.getMonth()) + 1;
		translated['Y'] = d.getFullYear();
		translated['y'] = translated['Y'].toString().slice(2,4);
		translated['F'] = DateConfig.months[d.getMonth()];
		translated['M'] = translated['F'].slice(0,3);
		return format.replace(/(D|d|m|M|n|j|F|Y|y)/g, function(match) { return translated[match]; });
	};   

	this.toTimestamp = function(x,source) {
		
		if (x == 0) {
			var date = new Date();
			var els = new Array();
			els[0] = date.getFullYear(); 
			els[1] = date.getMonth();
			els[2] = date.getDate();
			source = 'js';
		} else {
			var els = x.split('-');
		}
		
		if (source == 'php') {
			var d = new Date(parseInt(els[0]), parseInt(els[1])-1, parseInt(els[2]), 0, 0, 0);
		} else {
			var d = new Date(parseInt(els[0]), parseInt(els[1]), parseInt(els[2]), 0, 0, 0);
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
    };


	this.isIE = function () { var myNav = navigator.userAgent.toLowerCase(); return (myNav.indexOf('msie') != -1) ? parseInt(myNav.split('msie')[1]) : false; };

}
