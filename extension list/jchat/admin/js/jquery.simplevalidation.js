(function(e){var t=e;var n=function(){var n={email:{check:function(e,t){if(e)return r(e,"[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])");return true},msg:function(e){return"Error email format"}},url:{check:function(e,t){if(e)return r(e,"^https?://(.+.)+.{2,4}(/.*)?$");return true},msg:function(e){return"Invalid URL format"}},required:{check:function(e,t){if(e.trim())return true;else return false},msg:function(e){return"*Required"}},multiselect_required:{check:function(t,n){if(e.isArray(t)){var r=false;e.each(t,function(e,t){if(t!==null&&t!==undefined&&t){r=true}})}else{if(t)r=true;else r=false}return r},msg:function(e){return"*Required"}},minlength:{check:function(t,n){var r=e(n).attr("data-minlength");e.data(n,"minlength",r);if(r){var i=e.trim(t).length;if(i<r){return false}else{return true}}},msg:function(t){var n=parseInt(e.data(t,"minlength")).toString();return"Min "+n+" chars"}},alphaascii:{check:function(e,t){return!e.match(/[^a-zA-Z0-9]/gi)},msg:function(e){return"Only chars accepted a-zA-Z0-9"}},phone:{check:function(e,t){return!e.match(/[^a-zA-Z0-9-]/gi)},msg:function(e){return"Only chars accepted a-zA-Z0-9-"}},date:{check:function(e,t){if(e){return!/Invalid|NaN/.test(new Date(e))}return true},msg:function(e){return"Invalid date"}},dateISO:{check:function(e,t){if(e){return/^\d{4}[\/-]\d{1,2}[\/-]\d{1,2}$/.test(e)}return true},msg:function(e){return"Date format yyyy-mm-dd"}},digits:{check:function(e,t){if(e){return/^\d+$/.test(e)}return true},msg:function(e){return"Only numbers without comma"}},numbers:{check:function(e,t){if(e){return!/[^\d\.,]/gi.test(e)}return true},msg:function(e){return"Only integer numbers"}},range:{check:function(e,n){if(e){var r=parseInt(t(n).attr("min"));var i=parseInt(t(n).attr("max"));if(parseInt(e)>i||parseInt(e)<r)return false}return true},msg:function(e){return"Value out of range"}},ipaddress:{check:function(e,t){if(e){return/\b(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\b/.test(e)}return true},msg:function(e){return"Invalid IP address"}}};var r=function(e,t){var n=new RegExp(t,"");return n.test(e)};return{addRule:function(e,t){n[e]=t},getRule:function(e){if(n[e]!==undefined&&n[e]!==null){return n[e]}return false}}};var r=function(t){var n=[];t.find("[data-validation]").each(function(){var t=e(this);if(t.attr("data-validation")!==undefined){n.push(new i(t))}});this.fields=n};r.prototype={validateForm:function(){e.each(this.fields,function(e,t){t.validateField()})},isValid:function(){var t=true;var n=false;e.each(this.fields,function(r,i){if(!i.valid){if(!n){e("html, body").animate({scrollTop:i.field.offset().top-140},1e3,function(){i.field.focus()});n=true}t=false}});return t}};var i=function(e){this.field=e;this.valid=false;this.attach("change")};i.prototype={attach:function(e){var t=this;if(e=="change"){t.field.bind("change",function(){return t.validateField()})}if(e=="keyup"){t.field.bind("keyup",function(e){return t.validateField()})}},validateField:function(){var t=this,r=new n,i=t.field,s="errorlist",o=e(document.createElement("ul")).addClass(s),u=i.attr("data-validation").split(" "),a=[];i.next(".errorlist").remove();e.each(u,function(e,t){var n=r.getRule(t);if(n){if(!n.check(i.val(),i)){i.addClass("error");a.push(n.msg(i))}}});if(a.length){t.field.unbind("keyup");t.attach("keyup");i.after(o.empty());e.each(a,function(e,t){o.append("<li class='validation label label-important'>"+t+"</li>")});t.valid=false}else{o.remove();i.removeClass("error");t.valid=true}}};e.extend(e.fn,{validation:function(){e(this).unbind();var t=new r(e(this));e.data(e(this)[0],"formInstance",t);e(this).bind("submit",function(e){t.validateForm();if(!t.isValid()){e.preventDefault()}})},validate:function(){var t=e.data(e(this)[0],"formInstance");t.validateForm();return t.isValid()}})})(jQuery)
//Keep memoize own jQuery refence to recover prototype if overwritten
var jchatjQueryBackup = jQuery;