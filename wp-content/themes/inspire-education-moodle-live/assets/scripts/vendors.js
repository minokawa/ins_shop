/*!
 * hoverIntent v1.10.2 // 2020.04.28 // jQuery v1.7.0+
 * http://briancherne.github.io/jquery-hoverIntent/
 *
 * You may use hoverIntent under the terms of the MIT license. Basically that
 * means you are free to use hoverIntent as long as this header is left intact.
 * Copyright 2007-2019 Brian Cherne
 */
!function(factory){"use strict";"function"==typeof define&&define.amd?define(["jquery"],factory):"object"==typeof module&&module.exports?module.exports=factory(require("jquery")):jQuery&&!jQuery.fn.hoverIntent&&factory(jQuery)}(function($){"use strict";function track(ev){cX=ev.pageX,cY=ev.pageY}function isFunction(value){return"function"==typeof value}var cX,cY,_cfg={interval:100,sensitivity:6,timeout:0},INSTANCE_COUNT=0,compare=function(ev,$el,s,cfg){if(Math.sqrt((s.pX-cX)*(s.pX-cX)+(s.pY-cY)*(s.pY-cY))<cfg.sensitivity)return $el.off(s.event,track),delete s.timeoutId,s.isActive=!0,ev.pageX=cX,ev.pageY=cY,delete s.pX,delete s.pY,cfg.over.apply($el[0],[ev]);s.pX=cX,s.pY=cY,s.timeoutId=setTimeout(function(){compare(ev,$el,s,cfg)},cfg.interval)};$.fn.hoverIntent=function(handlerIn,handlerOut,selector){var instanceId=INSTANCE_COUNT++,cfg=$.extend({},_cfg);$.isPlainObject(handlerIn)?(cfg=$.extend(cfg,handlerIn),isFunction(cfg.out)||(cfg.out=cfg.over)):cfg=isFunction(handlerOut)?$.extend(cfg,{over:handlerIn,out:handlerOut,selector:selector}):$.extend(cfg,{over:handlerIn,out:handlerIn,selector:handlerOut});function handleHover(e){var ev=$.extend({},e),$el=$(this),hoverIntentData=$el.data("hoverIntent");hoverIntentData||$el.data("hoverIntent",hoverIntentData={});var state=hoverIntentData[instanceId];state||(hoverIntentData[instanceId]=state={id:instanceId}),state.timeoutId&&(state.timeoutId=clearTimeout(state.timeoutId));var mousemove=state.event="mousemove.hoverIntent.hoverIntent"+instanceId;if("mouseenter"===e.type){if(state.isActive)return;state.pX=ev.pageX,state.pY=ev.pageY,$el.off(mousemove,track).on(mousemove,track),state.timeoutId=setTimeout(function(){compare(ev,$el,state,cfg)},cfg.interval)}else{if(!state.isActive)return;$el.off(mousemove,track),state.timeoutId=setTimeout(function(){!function(ev,$el,s,out){var data=$el.data("hoverIntent");data&&delete data[s.id],out.apply($el[0],[ev])}(ev,$el,state,cfg.out)},cfg.timeout)}}return this.on({"mouseenter.hoverIntent":handleHover,"mouseleave.hoverIntent":handleHover},cfg.selector)}});

/*! jQuery Validation Plugin - v1.19.3 - 1/9/2021
 * https://jqueryvalidation.org/
 * Copyright (c) 2021 Jörn Zaefferer; Licensed MIT */

!function(a){"function"==typeof define&&define.amd?define(["jquery"],a):"object"==typeof module&&module.exports?module.exports=a(require("jquery")):a(jQuery)}(function(a){a.extend(a.fn,{validate:function(b){if(!this.length)return void(b&&b.debug&&window.console&&console.warn("Nothing selected, can't validate, returning nothing."));var c=a.data(this[0],"validator");return c?c:(this.attr("novalidate","novalidate"),c=new a.validator(b,this[0]),a.data(this[0],"validator",c),c.settings.onsubmit&&(this.on("click.validate",":submit",function(b){c.submitButton=b.currentTarget,a(this).hasClass("cancel")&&(c.cancelSubmit=!0),void 0!==a(this).attr("formnovalidate")&&(c.cancelSubmit=!0)}),this.on("submit.validate",function(b){function d(){var d,e;return c.submitButton&&(c.settings.submitHandler||c.formSubmitted)&&(d=a("<input type='hidden'/>").attr("name",c.submitButton.name).val(a(c.submitButton).val()).appendTo(c.currentForm)),!(c.settings.submitHandler&&!c.settings.debug)||(e=c.settings.submitHandler.call(c,c.currentForm,b),d&&d.remove(),void 0!==e&&e)}return c.settings.debug&&b.preventDefault(),c.cancelSubmit?(c.cancelSubmit=!1,d()):c.form()?c.pendingRequest?(c.formSubmitted=!0,!1):d():(c.focusInvalid(),!1)})),c)},valid:function(){var b,c,d;return a(this[0]).is("form")?b=this.validate().form():(d=[],b=!0,c=a(this[0].form).validate(),this.each(function(){b=c.element(this)&&b,b||(d=d.concat(c.errorList))}),c.errorList=d),b},rules:function(b,c){var d,e,f,g,h,i,j=this[0],k="undefined"!=typeof this.attr("contenteditable")&&"false"!==this.attr("contenteditable");if(null!=j&&(!j.form&&k&&(j.form=this.closest("form")[0],j.name=this.attr("name")),null!=j.form)){if(b)switch(d=a.data(j.form,"validator").settings,e=d.rules,f=a.validator.staticRules(j),b){case"add":a.extend(f,a.validator.normalizeRule(c)),delete f.messages,e[j.name]=f,c.messages&&(d.messages[j.name]=a.extend(d.messages[j.name],c.messages));break;case"remove":return c?(i={},a.each(c.split(/\s/),function(a,b){i[b]=f[b],delete f[b]}),i):(delete e[j.name],f)}return g=a.validator.normalizeRules(a.extend({},a.validator.classRules(j),a.validator.attributeRules(j),a.validator.dataRules(j),a.validator.staticRules(j)),j),g.required&&(h=g.required,delete g.required,g=a.extend({required:h},g)),g.remote&&(h=g.remote,delete g.remote,g=a.extend(g,{remote:h})),g}}});var b=function(a){return a.replace(/^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g,"")};a.extend(a.expr.pseudos||a.expr[":"],{blank:function(c){return!b(""+a(c).val())},filled:function(c){var d=a(c).val();return null!==d&&!!b(""+d)},unchecked:function(b){return!a(b).prop("checked")}}),a.validator=function(b,c){this.settings=a.extend(!0,{},a.validator.defaults,b),this.currentForm=c,this.init()},a.validator.format=function(b,c){return 1===arguments.length?function(){var c=a.makeArray(arguments);return c.unshift(b),a.validator.format.apply(this,c)}:void 0===c?b:(arguments.length>2&&c.constructor!==Array&&(c=a.makeArray(arguments).slice(1)),c.constructor!==Array&&(c=[c]),a.each(c,function(a,c){b=b.replace(new RegExp("\\{"+a+"\\}","g"),function(){return c})}),b)},a.extend(a.validator,{defaults:{messages:{},groups:{},rules:{},errorClass:"error",pendingClass:"pending",validClass:"valid",errorElement:"label",focusCleanup:!1,focusInvalid:!0,errorContainer:a([]),errorLabelContainer:a([]),onsubmit:!0,ignore:":hidden",ignoreTitle:!1,onfocusin:function(a){this.lastActive=a,this.settings.focusCleanup&&(this.settings.unhighlight&&this.settings.unhighlight.call(this,a,this.settings.errorClass,this.settings.validClass),this.hideThese(this.errorsFor(a)))},onfocusout:function(a){this.checkable(a)||!(a.name in this.submitted)&&this.optional(a)||this.element(a)},onkeyup:function(b,c){var d=[16,17,18,20,35,36,37,38,39,40,45,144,225];9===c.which&&""===this.elementValue(b)||a.inArray(c.keyCode,d)!==-1||(b.name in this.submitted||b.name in this.invalid)&&this.element(b)},onclick:function(a){a.name in this.submitted?this.element(a):a.parentNode.name in this.submitted&&this.element(a.parentNode)},highlight:function(b,c,d){"radio"===b.type?this.findByName(b.name).addClass(c).removeClass(d):a(b).addClass(c).removeClass(d)},unhighlight:function(b,c,d){"radio"===b.type?this.findByName(b.name).removeClass(c).addClass(d):a(b).removeClass(c).addClass(d)}},setDefaults:function(b){a.extend(a.validator.defaults,b)},messages:{required:"This field is required.",remote:"Please fix this field.",email:"Please enter a valid email address.",url:"Please enter a valid URL.",date:"Please enter a valid date.",dateISO:"Please enter a valid date (ISO).",number:"Please enter a valid number.",digits:"Please enter only digits.",equalTo:"Please enter the same value again.",maxlength:a.validator.format("Please enter no more than {0} characters."),minlength:a.validator.format("Please enter at least {0} characters."),rangelength:a.validator.format("Please enter a value between {0} and {1} characters long."),range:a.validator.format("Please enter a value between {0} and {1}."),max:a.validator.format("Please enter a value less than or equal to {0}."),min:a.validator.format("Please enter a value greater than or equal to {0}."),step:a.validator.format("Please enter a multiple of {0}.")},autoCreateRanges:!1,prototype:{init:function(){function b(b){var c="undefined"!=typeof a(this).attr("contenteditable")&&"false"!==a(this).attr("contenteditable");if(!this.form&&c&&(this.form=a(this).closest("form")[0],this.name=a(this).attr("name")),d===this.form){var e=a.data(this.form,"validator"),f="on"+b.type.replace(/^validate/,""),g=e.settings;g[f]&&!a(this).is(g.ignore)&&g[f].call(e,this,b)}}this.labelContainer=a(this.settings.errorLabelContainer),this.errorContext=this.labelContainer.length&&this.labelContainer||a(this.currentForm),this.containers=a(this.settings.errorContainer).add(this.settings.errorLabelContainer),this.submitted={},this.valueCache={},this.pendingRequest=0,this.pending={},this.invalid={},this.reset();var c,d=this.currentForm,e=this.groups={};a.each(this.settings.groups,function(b,c){"string"==typeof c&&(c=c.split(/\s/)),a.each(c,function(a,c){e[c]=b})}),c=this.settings.rules,a.each(c,function(b,d){c[b]=a.validator.normalizeRule(d)}),a(this.currentForm).on("focusin.validate focusout.validate keyup.validate",":text, [type='password'], [type='file'], select, textarea, [type='number'], [type='search'], [type='tel'], [type='url'], [type='email'], [type='datetime'], [type='date'], [type='month'], [type='week'], [type='time'], [type='datetime-local'], [type='range'], [type='color'], [type='radio'], [type='checkbox'], [contenteditable], [type='button']",b).on("click.validate","select, option, [type='radio'], [type='checkbox']",b),this.settings.invalidHandler&&a(this.currentForm).on("invalid-form.validate",this.settings.invalidHandler)},form:function(){return this.checkForm(),a.extend(this.submitted,this.errorMap),this.invalid=a.extend({},this.errorMap),this.valid()||a(this.currentForm).triggerHandler("invalid-form",[this]),this.showErrors(),this.valid()},checkForm:function(){this.prepareForm();for(var a=0,b=this.currentElements=this.elements();b[a];a++)this.check(b[a]);return this.valid()},element:function(b){var c,d,e=this.clean(b),f=this.validationTargetFor(e),g=this,h=!0;return void 0===f?delete this.invalid[e.name]:(this.prepareElement(f),this.currentElements=a(f),d=this.groups[f.name],d&&a.each(this.groups,function(a,b){b===d&&a!==f.name&&(e=g.validationTargetFor(g.clean(g.findByName(a))),e&&e.name in g.invalid&&(g.currentElements.push(e),h=g.check(e)&&h))}),c=this.check(f)!==!1,h=h&&c,c?this.invalid[f.name]=!1:this.invalid[f.name]=!0,this.numberOfInvalids()||(this.toHide=this.toHide.add(this.containers)),this.showErrors(),a(b).attr("aria-invalid",!c)),h},showErrors:function(b){if(b){var c=this;a.extend(this.errorMap,b),this.errorList=a.map(this.errorMap,function(a,b){return{message:a,element:c.findByName(b)[0]}}),this.successList=a.grep(this.successList,function(a){return!(a.name in b)})}this.settings.showErrors?this.settings.showErrors.call(this,this.errorMap,this.errorList):this.defaultShowErrors()},resetForm:function(){a.fn.resetForm&&a(this.currentForm).resetForm(),this.invalid={},this.submitted={},this.prepareForm(),this.hideErrors();var b=this.elements().removeData("previousValue").removeAttr("aria-invalid");this.resetElements(b)},resetElements:function(a){var b;if(this.settings.unhighlight)for(b=0;a[b];b++)this.settings.unhighlight.call(this,a[b],this.settings.errorClass,""),this.findByName(a[b].name).removeClass(this.settings.validClass);else a.removeClass(this.settings.errorClass).removeClass(this.settings.validClass)},numberOfInvalids:function(){return this.objectLength(this.invalid)},objectLength:function(a){var b,c=0;for(b in a)void 0!==a[b]&&null!==a[b]&&a[b]!==!1&&c++;return c},hideErrors:function(){this.hideThese(this.toHide)},hideThese:function(a){a.not(this.containers).text(""),this.addWrapper(a).hide()},valid:function(){return 0===this.size()},size:function(){return this.errorList.length},focusInvalid:function(){if(this.settings.focusInvalid)try{a(this.findLastActive()||this.errorList.length&&this.errorList[0].element||[]).filter(":visible").trigger("focus").trigger("focusin")}catch(b){}},findLastActive:function(){var b=this.lastActive;return b&&1===a.grep(this.errorList,function(a){return a.element.name===b.name}).length&&b},elements:function(){var b=this,c={};return a(this.currentForm).find("input, select, textarea, [contenteditable]").not(":submit, :reset, :image, :disabled").not(this.settings.ignore).filter(function(){var d=this.name||a(this).attr("name"),e="undefined"!=typeof a(this).attr("contenteditable")&&"false"!==a(this).attr("contenteditable");return!d&&b.settings.debug&&window.console&&console.error("%o has no name assigned",this),e&&(this.form=a(this).closest("form")[0],this.name=d),this.form===b.currentForm&&(!(d in c||!b.objectLength(a(this).rules()))&&(c[d]=!0,!0))})},clean:function(b){return a(b)[0]},errors:function(){var b=this.settings.errorClass.split(" ").join(".");return a(this.settings.errorElement+"."+b,this.errorContext)},resetInternals:function(){this.successList=[],this.errorList=[],this.errorMap={},this.toShow=a([]),this.toHide=a([])},reset:function(){this.resetInternals(),this.currentElements=a([])},prepareForm:function(){this.reset(),this.toHide=this.errors().add(this.containers)},prepareElement:function(a){this.reset(),this.toHide=this.errorsFor(a)},elementValue:function(b){var c,d,e=a(b),f=b.type,g="undefined"!=typeof e.attr("contenteditable")&&"false"!==e.attr("contenteditable");return"radio"===f||"checkbox"===f?this.findByName(b.name).filter(":checked").val():"number"===f&&"undefined"!=typeof b.validity?b.validity.badInput?"NaN":e.val():(c=g?e.text():e.val(),"file"===f?"C:\\fakepath\\"===c.substr(0,12)?c.substr(12):(d=c.lastIndexOf("/"),d>=0?c.substr(d+1):(d=c.lastIndexOf("\\"),d>=0?c.substr(d+1):c)):"string"==typeof c?c.replace(/\r/g,""):c)},check:function(b){b=this.validationTargetFor(this.clean(b));var c,d,e,f,g=a(b).rules(),h=a.map(g,function(a,b){return b}).length,i=!1,j=this.elementValue(b);"function"==typeof g.normalizer?f=g.normalizer:"function"==typeof this.settings.normalizer&&(f=this.settings.normalizer),f&&(j=f.call(b,j),delete g.normalizer);for(d in g){e={method:d,parameters:g[d]};try{if(c=a.validator.methods[d].call(this,j,b,e.parameters),"dependency-mismatch"===c&&1===h){i=!0;continue}if(i=!1,"pending"===c)return void(this.toHide=this.toHide.not(this.errorsFor(b)));if(!c)return this.formatAndAdd(b,e),!1}catch(k){throw this.settings.debug&&window.console&&console.log("Exception occurred when checking element "+b.id+", check the '"+e.method+"' method.",k),k instanceof TypeError&&(k.message+=".  Exception occurred when checking element "+b.id+", check the '"+e.method+"' method."),k}}if(!i)return this.objectLength(g)&&this.successList.push(b),!0},customDataMessage:function(b,c){return a(b).data("msg"+c.charAt(0).toUpperCase()+c.substring(1).toLowerCase())||a(b).data("msg")},customMessage:function(a,b){var c=this.settings.messages[a];return c&&(c.constructor===String?c:c[b])},findDefined:function(){for(var a=0;a<arguments.length;a++)if(void 0!==arguments[a])return arguments[a]},defaultMessage:function(b,c){"string"==typeof c&&(c={method:c});var d=this.findDefined(this.customMessage(b.name,c.method),this.customDataMessage(b,c.method),!this.settings.ignoreTitle&&b.title||void 0,a.validator.messages[c.method],"<strong>Warning: No message defined for "+b.name+"</strong>"),e=/\$?\{(\d+)\}/g;return"function"==typeof d?d=d.call(this,c.parameters,b):e.test(d)&&(d=a.validator.format(d.replace(e,"{$1}"),c.parameters)),d},formatAndAdd:function(a,b){var c=this.defaultMessage(a,b);this.errorList.push({message:c,element:a,method:b.method}),this.errorMap[a.name]=c,this.submitted[a.name]=c},addWrapper:function(a){return this.settings.wrapper&&(a=a.add(a.parent(this.settings.wrapper))),a},defaultShowErrors:function(){var a,b,c;for(a=0;this.errorList[a];a++)c=this.errorList[a],this.settings.highlight&&this.settings.highlight.call(this,c.element,this.settings.errorClass,this.settings.validClass),this.showLabel(c.element,c.message);if(this.errorList.length&&(this.toShow=this.toShow.add(this.containers)),this.settings.success)for(a=0;this.successList[a];a++)this.showLabel(this.successList[a]);if(this.settings.unhighlight)for(a=0,b=this.validElements();b[a];a++)this.settings.unhighlight.call(this,b[a],this.settings.errorClass,this.settings.validClass);this.toHide=this.toHide.not(this.toShow),this.hideErrors(),this.addWrapper(this.toShow).show()},validElements:function(){return this.currentElements.not(this.invalidElements())},invalidElements:function(){return a(this.errorList).map(function(){return this.element})},showLabel:function(b,c){var d,e,f,g,h=this.errorsFor(b),i=this.idOrName(b),j=a(b).attr("aria-describedby");h.length?(h.removeClass(this.settings.validClass).addClass(this.settings.errorClass),h.html(c)):(h=a("<"+this.settings.errorElement+">").attr("id",i+"-error").addClass(this.settings.errorClass).html(c||""),d=h,this.settings.wrapper&&(d=h.hide().show().wrap("<"+this.settings.wrapper+"/>").parent()),this.labelContainer.length?this.labelContainer.append(d):this.settings.errorPlacement?this.settings.errorPlacement.call(this,d,a(b)):d.insertAfter(b),h.is("label")?h.attr("for",i):0===h.parents("label[for='"+this.escapeCssMeta(i)+"']").length&&(f=h.attr("id"),j?j.match(new RegExp("\\b"+this.escapeCssMeta(f)+"\\b"))||(j+=" "+f):j=f,a(b).attr("aria-describedby",j),e=this.groups[b.name],e&&(g=this,a.each(g.groups,function(b,c){c===e&&a("[name='"+g.escapeCssMeta(b)+"']",g.currentForm).attr("aria-describedby",h.attr("id"))})))),!c&&this.settings.success&&(h.text(""),"string"==typeof this.settings.success?h.addClass(this.settings.success):this.settings.success(h,b)),this.toShow=this.toShow.add(h)},errorsFor:function(b){var c=this.escapeCssMeta(this.idOrName(b)),d=a(b).attr("aria-describedby"),e="label[for='"+c+"'], label[for='"+c+"'] *";return d&&(e=e+", #"+this.escapeCssMeta(d).replace(/\s+/g,", #")),this.errors().filter(e)},escapeCssMeta:function(a){return a.replace(/([\\!"#$%&'()*+,.\/:;<=>?@\[\]^`{|}~])/g,"\\$1")},idOrName:function(a){return this.groups[a.name]||(this.checkable(a)?a.name:a.id||a.name)},validationTargetFor:function(b){return this.checkable(b)&&(b=this.findByName(b.name)),a(b).not(this.settings.ignore)[0]},checkable:function(a){return/radio|checkbox/i.test(a.type)},findByName:function(b){return a(this.currentForm).find("[name='"+this.escapeCssMeta(b)+"']")},getLength:function(b,c){switch(c.nodeName.toLowerCase()){case"select":return a("option:selected",c).length;case"input":if(this.checkable(c))return this.findByName(c.name).filter(":checked").length}return b.length},depend:function(a,b){return!this.dependTypes[typeof a]||this.dependTypes[typeof a](a,b)},dependTypes:{"boolean":function(a){return a},string:function(b,c){return!!a(b,c.form).length},"function":function(a,b){return a(b)}},optional:function(b){var c=this.elementValue(b);return!a.validator.methods.required.call(this,c,b)&&"dependency-mismatch"},startRequest:function(b){this.pending[b.name]||(this.pendingRequest++,a(b).addClass(this.settings.pendingClass),this.pending[b.name]=!0)},stopRequest:function(b,c){this.pendingRequest--,this.pendingRequest<0&&(this.pendingRequest=0),delete this.pending[b.name],a(b).removeClass(this.settings.pendingClass),c&&0===this.pendingRequest&&this.formSubmitted&&this.form()?(a(this.currentForm).submit(),this.submitButton&&a("input:hidden[name='"+this.submitButton.name+"']",this.currentForm).remove(),this.formSubmitted=!1):!c&&0===this.pendingRequest&&this.formSubmitted&&(a(this.currentForm).triggerHandler("invalid-form",[this]),this.formSubmitted=!1)},previousValue:function(b,c){return c="string"==typeof c&&c||"remote",a.data(b,"previousValue")||a.data(b,"previousValue",{old:null,valid:!0,message:this.defaultMessage(b,{method:c})})},destroy:function(){this.resetForm(),a(this.currentForm).off(".validate").removeData("validator").find(".validate-equalTo-blur").off(".validate-equalTo").removeClass("validate-equalTo-blur").find(".validate-lessThan-blur").off(".validate-lessThan").removeClass("validate-lessThan-blur").find(".validate-lessThanEqual-blur").off(".validate-lessThanEqual").removeClass("validate-lessThanEqual-blur").find(".validate-greaterThanEqual-blur").off(".validate-greaterThanEqual").removeClass("validate-greaterThanEqual-blur").find(".validate-greaterThan-blur").off(".validate-greaterThan").removeClass("validate-greaterThan-blur")}},classRuleSettings:{required:{required:!0},email:{email:!0},url:{url:!0},date:{date:!0},dateISO:{dateISO:!0},number:{number:!0},digits:{digits:!0},creditcard:{creditcard:!0}},addClassRules:function(b,c){b.constructor===String?this.classRuleSettings[b]=c:a.extend(this.classRuleSettings,b)},classRules:function(b){var c={},d=a(b).attr("class");return d&&a.each(d.split(" "),function(){this in a.validator.classRuleSettings&&a.extend(c,a.validator.classRuleSettings[this])}),c},normalizeAttributeRule:function(a,b,c,d){/min|max|step/.test(c)&&(null===b||/number|range|text/.test(b))&&(d=Number(d),isNaN(d)&&(d=void 0)),d||0===d?a[c]=d:b===c&&"range"!==b&&(a[c]=!0)},attributeRules:function(b){var c,d,e={},f=a(b),g=b.getAttribute("type");for(c in a.validator.methods)"required"===c?(d=b.getAttribute(c),""===d&&(d=!0),d=!!d):d=f.attr(c),this.normalizeAttributeRule(e,g,c,d);return e.maxlength&&/-1|2147483647|524288/.test(e.maxlength)&&delete e.maxlength,e},dataRules:function(b){var c,d,e={},f=a(b),g=b.getAttribute("type");for(c in a.validator.methods)d=f.data("rule"+c.charAt(0).toUpperCase()+c.substring(1).toLowerCase()),""===d&&(d=!0),this.normalizeAttributeRule(e,g,c,d);return e},staticRules:function(b){var c={},d=a.data(b.form,"validator");return d.settings.rules&&(c=a.validator.normalizeRule(d.settings.rules[b.name])||{}),c},normalizeRules:function(b,c){return a.each(b,function(d,e){if(e===!1)return void delete b[d];if(e.param||e.depends){var f=!0;switch(typeof e.depends){case"string":f=!!a(e.depends,c.form).length;break;case"function":f=e.depends.call(c,c)}f?b[d]=void 0===e.param||e.param:(a.data(c.form,"validator").resetElements(a(c)),delete b[d])}}),a.each(b,function(a,d){b[a]="function"==typeof d&&"normalizer"!==a?d(c):d}),a.each(["minlength","maxlength"],function(){b[this]&&(b[this]=Number(b[this]))}),a.each(["rangelength","range"],function(){var a;b[this]&&(Array.isArray(b[this])?b[this]=[Number(b[this][0]),Number(b[this][1])]:"string"==typeof b[this]&&(a=b[this].replace(/[\[\]]/g,"").split(/[\s,]+/),b[this]=[Number(a[0]),Number(a[1])]))}),a.validator.autoCreateRanges&&(null!=b.min&&null!=b.max&&(b.range=[b.min,b.max],delete b.min,delete b.max),null!=b.minlength&&null!=b.maxlength&&(b.rangelength=[b.minlength,b.maxlength],delete b.minlength,delete b.maxlength)),b},normalizeRule:function(b){if("string"==typeof b){var c={};a.each(b.split(/\s/),function(){c[this]=!0}),b=c}return b},addMethod:function(b,c,d){a.validator.methods[b]=c,a.validator.messages[b]=void 0!==d?d:a.validator.messages[b],c.length<3&&a.validator.addClassRules(b,a.validator.normalizeRule(b))},methods:{required:function(b,c,d){if(!this.depend(d,c))return"dependency-mismatch";if("select"===c.nodeName.toLowerCase()){var e=a(c).val();return e&&e.length>0}return this.checkable(c)?this.getLength(b,c)>0:void 0!==b&&null!==b&&b.length>0},email:function(a,b){return this.optional(b)||/^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/.test(a)},url:function(a,b){return this.optional(b)||/^(?:(?:(?:https?|ftp):)?\/\/)(?:\S+(?::\S*)?@)?(?:(?!(?:10|127)(?:\.\d{1,3}){3})(?!(?:169\.254|192\.168)(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z0-9\u00a1-\uffff][a-z0-9\u00a1-\uffff_-]{0,62})?[a-z0-9\u00a1-\uffff]\.)+(?:[a-z\u00a1-\uffff]{2,}\.?))(?::\d{2,5})?(?:[\/?#]\S*)?$/i.test(a)},date:function(){var a=!1;return function(b,c){return a||(a=!0,this.settings.debug&&window.console&&console.warn("The `date` method is deprecated and will be removed in version '2.0.0'.\nPlease don't use it, since it relies on the Date constructor, which\nbehaves very differently across browsers and locales. Use `dateISO`\ninstead or one of the locale specific methods in `localizations/`\nand `additional-methods.js`.")),this.optional(c)||!/Invalid|NaN/.test(new Date(b).toString())}}(),dateISO:function(a,b){return this.optional(b)||/^\d{4}[\/\-](0?[1-9]|1[012])[\/\-](0?[1-9]|[12][0-9]|3[01])$/.test(a)},number:function(a,b){return this.optional(b)||/^(?:-?\d+|-?\d{1,3}(?:,\d{3})+)?(?:\.\d+)?$/.test(a)},digits:function(a,b){return this.optional(b)||/^\d+$/.test(a)},minlength:function(a,b,c){var d=Array.isArray(a)?a.length:this.getLength(a,b);return this.optional(b)||d>=c},maxlength:function(a,b,c){var d=Array.isArray(a)?a.length:this.getLength(a,b);return this.optional(b)||d<=c},rangelength:function(a,b,c){var d=Array.isArray(a)?a.length:this.getLength(a,b);return this.optional(b)||d>=c[0]&&d<=c[1]},min:function(a,b,c){return this.optional(b)||a>=c},max:function(a,b,c){return this.optional(b)||a<=c},range:function(a,b,c){return this.optional(b)||a>=c[0]&&a<=c[1]},step:function(b,c,d){var e,f=a(c).attr("type"),g="Step attribute on input type "+f+" is not supported.",h=["text","number","range"],i=new RegExp("\\b"+f+"\\b"),j=f&&!i.test(h.join()),k=function(a){var b=(""+a).match(/(?:\.(\d+))?$/);return b&&b[1]?b[1].length:0},l=function(a){return Math.round(a*Math.pow(10,e))},m=!0;if(j)throw new Error(g);return e=k(d),(k(b)>e||l(b)%l(d)!==0)&&(m=!1),this.optional(c)||m},equalTo:function(b,c,d){var e=a(d);return this.settings.onfocusout&&e.not(".validate-equalTo-blur").length&&e.addClass("validate-equalTo-blur").on("blur.validate-equalTo",function(){a(c).valid()}),b===e.val()},remote:function(b,c,d,e){if(this.optional(c))return"dependency-mismatch";e="string"==typeof e&&e||"remote";var f,g,h,i=this.previousValue(c,e);return this.settings.messages[c.name]||(this.settings.messages[c.name]={}),i.originalMessage=i.originalMessage||this.settings.messages[c.name][e],this.settings.messages[c.name][e]=i.message,d="string"==typeof d&&{url:d}||d,h=a.param(a.extend({data:b},d.data)),i.old===h?i.valid:(i.old=h,f=this,this.startRequest(c),g={},g[c.name]=b,a.ajax(a.extend(!0,{mode:"abort",port:"validate"+c.name,dataType:"json",data:g,context:f.currentForm,success:function(a){var d,g,h,j=a===!0||"true"===a;f.settings.messages[c.name][e]=i.originalMessage,j?(h=f.formSubmitted,f.resetInternals(),f.toHide=f.errorsFor(c),f.formSubmitted=h,f.successList.push(c),f.invalid[c.name]=!1,f.showErrors()):(d={},g=a||f.defaultMessage(c,{method:e,parameters:b}),d[c.name]=i.message=g,f.invalid[c.name]=!0,f.showErrors(d)),i.valid=j,f.stopRequest(c,j)}},d)),"pending")}}});var c,d={};return a.ajaxPrefilter?a.ajaxPrefilter(function(a,b,c){var e=a.port;"abort"===a.mode&&(d[e]&&d[e].abort(),d[e]=c)}):(c=a.ajax,a.ajax=function(b){var e=("mode"in b?b:a.ajaxSettings).mode,f=("port"in b?b:a.ajaxSettings).port;return"abort"===e?(d[f]&&d[f].abort(),d[f]=c.apply(this,arguments),d[f]):c.apply(this,arguments)}),a});

// ajax mode: abort
// usage: $.ajax({ mode: "abort"[, port: "uniqueport"]});
// if mode:"abort" is used, the previous request on that port (port can be undefined) is aborted via XMLHttpRequest.abort()
(function($) {
	var pendingRequests = {};
	// Use a prefilter if available (1.5+)
	if ( $.ajaxPrefilter ) {
			$.ajaxPrefilter(function( settings, _, xhr ) {
					var port = settings.port;
					if ( settings.mode === "abort" ) {
							if ( pendingRequests[port] ) {
									pendingRequests[port].abort();
							}
							pendingRequests[port] = xhr;
					}
			});
	} else {
			// Proxy ajax
			var ajax = $.ajax;
			$.ajax = function( settings ) {
					var mode = ( "mode" in settings ? settings : $.ajaxSettings ).mode,
							port = ( "port" in settings ? settings : $.ajaxSettings ).port;
					if ( mode === "abort" ) {
							if ( pendingRequests[port] ) {
									pendingRequests[port].abort();
							}
							pendingRequests[port] = ajax.apply(this, arguments);
							return pendingRequests[port];
					}
					return ajax.apply(this, arguments);
			};
	}
}(jQuery));

// provides delegate(type: String, delegate: Selector, handler: Callback) plugin for easier event delegation
// handler is only called when $(event.target).is(delegate), in the scope of the jquery-object for event.target
(function($) {
	$.extend($.fn, {
			validateDelegate: function( delegate, type, handler ) {
					return this.bind(type, function( event ) {
							var target = $(event.target);
							if ( target.is(delegate) ) {
									return handler.apply(target, arguments);
							}
					});
			}
	});
}(jQuery));

/*
Garlic.js allows you to automatically persist your forms' text field values locally,
until the form is submitted. This way, your users don't lose any precious data if they
accidentally close their tab or browser.
author: Guillaume Potier - @guillaumepotier
*/

!function(t){"use strict";var e=function(t){this.defined="undefined"!=typeof localStorage;var e="garlic:"+document.domain+">test";try{localStorage.setItem(e,e),localStorage.removeItem(e)}catch(t){this.defined=!1}};e.prototype={constructor:e,get:function(t,e){var i=localStorage.getItem(t);if(i){try{i=JSON.parse(i)}catch(t){}return i}return void 0!==e?e:null},has:function(t){return!!localStorage.getItem(t)},set:function(t,e,i){return""===e||e instanceof Array&&0===e.length?this.destroy(t):(e=JSON.stringify(e),localStorage.setItem(t,e)),"function"!=typeof i||i()},destroy:function(t,e){return localStorage.removeItem(t),"function"!=typeof e||e()},clean:function(t){for(var e=localStorage.length-1;e>=0;e--)void 0===Array.indexOf&&-1!==localStorage.key(e).indexOf("garlic:")&&localStorage.removeItem(localStorage.key(e));return"function"!=typeof t||t()},clear:function(t){return localStorage.clear(),"function"!=typeof t||t()}};var i=function(t,e,i){this.init("garlic",t,e,i)};i.prototype={constructor:i,init:function(e,i,n,s){this.type=e,this.$element=t(i),this.options=this.getOptions(s),this.storage=n,this.path=this.options.getPath(this.$element)||this.getPath(),this.parentForm=this.$element.closest("form"),this.$element.addClass("garlic-auto-save"),this.expiresFlag=!!this.options.expires&&(this.$element.data("expires")?this.path:this.getPath(this.parentForm))+"_flag",this.$element.on(this.options.events.join("."+this.type+" "),!1,t.proxy(this.persist,this)),this.options.destroy&&t(this.parentForm).on("submit reset",!1,t.proxy(this.destroy,this)),this.retrieve()},getOptions:function(e){return t.extend({},t.fn[this.type].defaults,e,this.$element.data())},persist:function(){if(this.val!==this.getVal()){this.val=this.getVal(),this.options.expires&&this.storage.set(this.expiresFlag,((new Date).getTime()+1e3*this.options.expires).toString());var t=this.options.prePersist(this.$element,this.val);"string"==typeof t&&(this.val=t),this.storage.set(this.path,this.val),this.options.onPersist(this.$element,this.val)}},getVal:function(){return this.$element.is("input[type=checkbox]")?this.$element.prop("checked")?"checked":"unchecked":this.$element.val()},retrieve:function(){if(this.storage.has(this.path)){if(this.options.expires){var t=(new Date).getTime();if(this.storage.get(this.expiresFlag)<t.toString())return void this.storage.destroy(this.path);this.$element.attr("expires-in",Math.floor((parseInt(this.storage.get(this.expiresFlag))-t)/1e3))}var e=this.$element.val(),i=this.storage.get(this.path);if("boolean"==typeof(i=this.options.preRetrieve(this.$element,e,i))&&0==i)return;return this.options.conflictManager.enabled&&this.detectConflict()?this.conflictManager():this.$element.is("input[type=radio], input[type=checkbox]")?"checked"===i||this.$element.val()===i?this.$element.prop("checked",!0):void("unchecked"===i&&this.$element.prop("checked",!1)):(this.$element.val(i),this.$element.trigger("input"),void this.options.onRetrieve(this.$element,i))}},detectConflict:function(){var e=this;if(this.$element.is("input[type=checkbox], input[type=radio]"))return!1;if(this.$element.val()&&this.storage.get(this.path)!==this.$element.val()){if(this.$element.is("select")){var i=!1;return this.$element.find("option").each(function(){0!==t(this).index()&&t(this).attr("selected")&&t(this).val()!==e.storage.get(this.path)&&(i=!0)}),i}return!0}return!1},conflictManager:function(){if("function"==typeof this.options.conflictManager.onConflictDetected&&!this.options.conflictManager.onConflictDetected(this.$element,this.storage.get(this.path)))return!1;this.options.conflictManager.garlicPriority?(this.$element.data("swap-data",this.$element.val()),this.$element.data("swap-state","garlic"),this.$element.val(this.storage.get(this.path))):(this.$element.data("swap-data",this.storage.get(this.path)),this.$element.data("swap-state","default")),this.swapHandler(),this.$element.addClass("garlic-conflict-detected"),this.$element.closest("input[type=submit]").attr("disabled",!0)},swapHandler:function(){var e=t(this.options.conflictManager.template);this.$element.after(e.text(this.options.conflictManager.message)),e.on("click",!1,t.proxy(this.swap,this))},swap:function(){var e=this.$element.data("swap-data");this.$element.data("swap-state","garlic"===this.$element.data("swap-state")?"default":"garlic"),this.$element.data("swap-data",this.$element.val()),t(this.$element).val(e),this.options.onSwap(this.$element,this.$element.data("swap-data"),e)},destroy:function(){this.storage.destroy(this.path)},remove:function(){this.destroy(),this.$element.is("input[type=radio], input[type=checkbox]")?t(this.$element).attr("checked",!1):this.$element.val("")},getPath:function(e){if(void 0===e&&(e=this.$element),this.options.getPath(e))return this.options.getPath(e);if(1!=e.length)return!1;for(var i="",n=e.is("input[type=checkbox]"),s=e;s.length;){var a=s[0],o=a.nodeName;if(!o)break;o=o.toLowerCase();var r=s.parent(),h=r.children(o);if(t(a).is("form, input, select, textarea")||n){if(o+=t(a).attr("name")?"."+t(a).attr("name"):"",h.length>1&&!t(a).is("input[type=radio]")&&(o+=":eq("+h.index(a)+")"),i=o+(i?">"+i:""),"form"==a.nodeName.toLowerCase())break;s=r}else s=r}return"garlic:"+document.domain+(this.options.domain?"*":window.location.pathname)+">"+i},getStorage:function(){return this.storage}},t.fn.garlic=function(n,s){var a=t.extend(!0,{},t.fn.garlic.defaults,n,this.data()),o=new e,r=!1;if(!o.defined)return!1;function h(e){var s=t(e),r=s.data("garlic"),h=t.extend({},a,s.data());if((void 0===h.storage||h.storage)&&"password"!==t(e).attr("type"))return r||s.data("garlic",r=new i(e,o,h)),"string"==typeof n&&"function"==typeof r[n]?r[n]():void 0}return this.each(function(){if(t(this).is("form"))t(this).find(a.inputs).each(function(){t(this).is(a.excluded)||(r=h(t(this)))});else if(t(this).is(a.inputs)){if(t(this).is(a.excluded))return;r=h(t(this))}}),"function"==typeof s?s():r},t.fn.garlic.Constructor=i,t.fn.garlic.defaults={destroy:!0,inputs:"input, textarea, select",excluded:'input[type="file"], input[type="hidden"], input[type="submit"], input[type="reset"]',events:["DOMAttrModified","textInput","input","change","click","keypress","paste","focus"],domain:!1,expires:!1,conflictManager:{enabled:!1,garlicPriority:!0,template:'<span class="garlic-swap"></span>',message:"This is your saved data. Click here to see default one",onConflictDetected:function(t,e){return!0}},getPath:function(t){},preRetrieve:function(t,e,i){return i},onRetrieve:function(t,e){},prePersist:function(t,e){return!1},onPersist:function(t,e){},onSwap:function(t,e,i){}},t(window).on("load",function(){t('[data-persist="garlic"]').each(function(){t(this).garlic()})})}(window.jQuery||window.Zepto);


/* ========================================================================
* Bootstrap: modal.js v3.3.4
* http://getbootstrap.com/javascript/#modals
* ========================================================================
* Copyright 2011-2015 Twitter, Inc.
* Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
* ======================================================================== */

!function ($) {
	'use strict';
	var Modal = function (element, options) {
		this.options             = options
		this.$body               = $(document.body)
		this.$element            = $(element)
		this.$dialog             = this.$element.find('.modal-dialog')
		this.$backdrop           = null
		this.isShown             = null
		this.originalBodyPad     = null
		this.scrollbarWidth      = 0
		this.ignoreBackdropClick = false

		if (this.options.remote) {
			this.$element
				.find('.modal-content')
				.load(this.options.remote, $.proxy(function () {
					this.$element.trigger('loaded.bs.modal')
				}, this))
		}
	}

	Modal.VERSION  = '3.3.4'
	Modal.TRANSITION_DURATION = 300
	Modal.BACKDROP_TRANSITION_DURATION = 150

	Modal.DEFAULTS = {
		backdrop: true,
		keyboard: true,
		show: true
	}

	Modal.prototype.toggle = function (_relatedTarget) {
		return this.isShown ? this.hide() : this.show(_relatedTarget)
	}

	Modal.prototype.show = function (_relatedTarget) {
		var that = this
		var e    = $.Event('show.bs.modal', { relatedTarget: _relatedTarget })

		this.$element.trigger(e)

		if (this.isShown || e.isDefaultPrevented()) return

		this.isShown = true

		this.checkScrollbar()
		this.setScrollbar()
		this.$body.addClass('modal-open')

		this.escape()
		this.resize()

		this.$element.on('click.dismiss.bs.modal', '[data-dismiss="modal"]', $.proxy(this.hide, this))

		this.$dialog.on('mousedown.dismiss.bs.modal', function () {
			that.$element.one('mouseup.dismiss.bs.modal', function (e) {
				if ($(e.target).is(that.$element)) that.ignoreBackdropClick = true
			})
		})

		this.backdrop(function () {
			var transition = $.support.transition && that.$element.hasClass('fade')

			if (!that.$element.parent().length) {
				that.$element.appendTo(that.$body) // don't move modals dom position
			}

			that.$element
				.show()
				.scrollTop(0)

			that.adjustDialog()

			if (transition) {
				that.$element[0].offsetWidth // force reflow
			}

			that.$element.addClass('in')

			that.enforceFocus()

			var e = $.Event('shown.bs.modal', { relatedTarget: _relatedTarget })

			transition ?
				that.$dialog // wait for modal to slide in
					.one('bsTransitionEnd', function () {
						that.$element.trigger('focus').trigger(e)
					})
					.emulateTransitionEnd(Modal.TRANSITION_DURATION) :
				that.$element.trigger('focus').trigger(e)
		})
	}

	Modal.prototype.hide = function (e) {
		if (e) e.preventDefault()

		e = $.Event('hide.bs.modal')

		this.$element.trigger(e)

		if (!this.isShown || e.isDefaultPrevented()) return

		this.isShown = false

		this.escape()
		this.resize()

		$(document).off('focusin.bs.modal')

		this.$element
			.removeClass('in')
			.off('click.dismiss.bs.modal')
			.off('mouseup.dismiss.bs.modal')

		this.$dialog.off('mousedown.dismiss.bs.modal')

		$.support.transition && this.$element.hasClass('fade') ?
			this.$element
				.one('bsTransitionEnd', $.proxy(this.hideModal, this))
				.emulateTransitionEnd(Modal.TRANSITION_DURATION) :
			this.hideModal()
	}

	Modal.prototype.enforceFocus = function () {
		$(document)
			.off('focusin.bs.modal') // guard against infinite focus loop
			.on('focusin.bs.modal', $.proxy(function (e) {
				if (this.$element[0] !== e.target && !this.$element.has(e.target).length) {
					this.$element.trigger('focus')
				}
			}, this))
	}

	Modal.prototype.escape = function () {
		if (this.isShown && this.options.keyboard) {
			this.$element.on('keydown.dismiss.bs.modal', $.proxy(function (e) {
				e.which == 27 && this.hide()
			}, this))
		} else if (!this.isShown) {
			this.$element.off('keydown.dismiss.bs.modal')
		}
	}

	Modal.prototype.resize = function () {
		if (this.isShown) {
			$(window).on('resize.bs.modal', $.proxy(this.handleUpdate, this))
		} else {
			$(window).off('resize.bs.modal')
		}
	}

	Modal.prototype.hideModal = function () {
		var that = this
		this.$element.hide()
		this.backdrop(function () {
			that.$body.removeClass('modal-open')
			that.resetAdjustments()
			that.resetScrollbar()
			that.$element.trigger('hidden.bs.modal')
		})
	}

	Modal.prototype.removeBackdrop = function () {
		this.$backdrop && this.$backdrop.remove()
		this.$backdrop = null
	}

	Modal.prototype.backdrop = function (callback) {
		var that = this
		var animate = this.$element.hasClass('fade') ? 'fade' : ''

		if (this.isShown && this.options.backdrop) {
			var doAnimate = $.support.transition && animate

			this.$backdrop = $(document.createElement('div'))
				.addClass('modal-backdrop ' + animate)
				.appendTo(this.$body)

			this.$element.on('click.dismiss.bs.modal', $.proxy(function (e) {
				if (this.ignoreBackdropClick) {
					this.ignoreBackdropClick = false
					return
				}
				if (e.target !== e.currentTarget) return
				this.options.backdrop == 'static'
					? this.$element[0].focus()
					: this.hide()
			}, this))

			if (doAnimate) this.$backdrop[0].offsetWidth // force reflow

			this.$backdrop.addClass('in')

			if (!callback) return

			doAnimate ?
				this.$backdrop
					.one('bsTransitionEnd', callback)
					.emulateTransitionEnd(Modal.BACKDROP_TRANSITION_DURATION) :
				callback()

		} else if (!this.isShown && this.$backdrop) {
			this.$backdrop.removeClass('in')

			var callbackRemove = function () {
				that.removeBackdrop()
				callback && callback()
			}
			$.support.transition && this.$element.hasClass('fade') ?
				this.$backdrop
					.one('bsTransitionEnd', callbackRemove)
					.emulateTransitionEnd(Modal.BACKDROP_TRANSITION_DURATION) :
				callbackRemove()

		} else if (callback) {
			callback()
		}
	}

	Modal.prototype.handleUpdate = function () {
		this.adjustDialog()
	}

	Modal.prototype.adjustDialog = function () {
		var modalIsOverflowing = this.$element[0].scrollHeight > document.documentElement.clientHeight

		this.$element.css({
			paddingLeft:  !this.bodyIsOverflowing && modalIsOverflowing ? this.scrollbarWidth : '',
			paddingRight: this.bodyIsOverflowing && !modalIsOverflowing ? this.scrollbarWidth : ''
		})
	}

	Modal.prototype.resetAdjustments = function () {
		this.$element.css({
			paddingLeft: '',
			paddingRight: ''
		})
	}

	Modal.prototype.checkScrollbar = function () {
		var fullWindowWidth = window.innerWidth
		if (!fullWindowWidth) { // workaround for missing window.innerWidth in IE8
			var documentElementRect = document.documentElement.getBoundingClientRect()
			fullWindowWidth = documentElementRect.right - Math.abs(documentElementRect.left)
		}
		this.bodyIsOverflowing = document.body.clientWidth < fullWindowWidth
		this.scrollbarWidth = this.measureScrollbar()
	}

	Modal.prototype.setScrollbar = function () {
		var bodyPad = parseInt((this.$body.css('padding-right') || 0), 10)
		this.originalBodyPad = document.body.style.paddingRight || ''
		if (this.bodyIsOverflowing) this.$body.css('padding-right', bodyPad + this.scrollbarWidth)
	}

	Modal.prototype.resetScrollbar = function () {
		this.$body.css('padding-right', this.originalBodyPad)
	}

	Modal.prototype.measureScrollbar = function () { // thx walsh
		var scrollDiv = document.createElement('div')
		scrollDiv.className = 'modal-scrollbar-measure'
		this.$body.append(scrollDiv)
		var scrollbarWidth = scrollDiv.offsetWidth - scrollDiv.clientWidth
		this.$body[0].removeChild(scrollDiv)
		return scrollbarWidth
	}

	function Plugin(option, _relatedTarget) {
		return this.each(function () {
			var $this   = $(this)
			var data    = $this.data('bs.modal')
			var options = $.extend({}, Modal.DEFAULTS, $this.data(), typeof option == 'object' && option)

			if (!data) $this.data('bs.modal', (data = new Modal(this, options)))
			if (typeof option == 'string') data[option](_relatedTarget)
			else if (options.show) data.show(_relatedTarget)
		})
	}

	var old = $.fn.modal
	$.fn.modal             = Plugin
	$.fn.modal.Constructor = Modal

	$.fn.modal.noConflict = function () {
		$.fn.modal = old
		return this
	}

	$(document).on('click.bs.modal.data-api', '[data-toggle="modal"]', function (e) {
		var $this   = $(this)
		var href    = $this.attr('href')
		var $target = $($this.attr('data-target') || (href && href.replace(/.*(?=#[^\s]+$)/, ''))) // strip for ie7
		var option  = $target.data('bs.modal') ? 'toggle' : $.extend({ remote: !/#/.test(href) && href }, $target.data(), $this.data())

		if ($this.is('a')) e.preventDefault()

		$target.one('show.bs.modal', function (showEvent) {
			if (showEvent.isDefaultPrevented()) return // only register focus restorer if modal will actually get shown
			$target.one('hidden.bs.modal', function () {
				$this.is(':visible') && $this.trigger('focus')
			})
		})
		Plugin.call($target, option, this)
	})

}(jQuery);



function _defineProperties(n,t){for(var e=0;e<t.length;e++){var i=t[e];i.enumerable=i.enumerable||!1,i.configurable=!0,"value"in i&&(i.writable=!0),Object.defineProperty(n,i.key,i)}}function _createClass(n,t,e){return t&&_defineProperties(n.prototype,t),e&&_defineProperties(n,e),Object.defineProperty(n,"prototype",{writable:!1}),n}!function(n,t){"object"==typeof exports&&"undefined"!=typeof module?module.exports=t():"function"==typeof define&&define.amd?define(t):(n="undefined"!=typeof globalThis?globalThis:n||self).Splide=t()}(this,function(){"use strict";var d="(prefers-reduced-motion: reduce)",R=4,W=5,n={CREATED:1,MOUNTED:2,IDLE:3,MOVING:R,SCROLLING:W,DRAGGING:6,DESTROYED:7};function x(n){n.length=0}function _(n,t,e){return Array.prototype.slice.call(n,t,e)}function D(n){return n.bind.apply(n,[null].concat(_(arguments,1)))}function G(){}var v=setTimeout;function p(n){return requestAnimationFrame(n)}function t(n,t){return typeof t===n}function X(n){return!r(n)&&t("object",n)}var o=Array.isArray,w=D(t,"function"),M=D(t,"string"),z=D(t,"undefined");function r(n){return null===n}function g(n){return n instanceof HTMLElement}function m(n){return o(n)?n:[n]}function y(n,t){m(n).forEach(t)}function b(n,t){return-1<n.indexOf(t)}function E(n,t){return n.push.apply(n,m(t)),n}function L(t,n,e){t&&y(n,function(n){n&&t.classList[e?"add":"remove"](n)})}function C(n,t){L(n,M(t)?t.split(" "):t,!0)}function P(n,t){y(t,n.appendChild.bind(n))}function k(n,e){y(n,function(n){var t=(e||n).parentNode;t&&t.insertBefore(n,e)})}function B(n,t){return g(n)&&(n.msMatchesSelector||n.matches).call(n,t)}function S(n,t){n=n?_(n.children):[];return t?n.filter(function(n){return B(n,t)}):n}function A(n,t){return t?S(n,t)[0]:n.firstElementChild}var h=Object.keys;function N(n,t,e){if(n)for(var i=h(n),i=e?i.reverse():i,o=0;o<i.length;o++){var r=i[o];if("__proto__"!==r&&!1===t(n[r],r))break}return n}function T(i){return _(arguments,1).forEach(function(e){N(e,function(n,t){i[t]=e[t]})}),i}function O(e){return _(arguments,1).forEach(function(n){N(n,function(n,t){o(n)?e[t]=n.slice():X(n)?e[t]=O({},X(e[t])?e[t]:{},n):e[t]=n})}),e}function I(t,n){m(n||h(t)).forEach(function(n){delete t[n]})}function F(n,e){y(n,function(t){y(e,function(n){t&&t.removeAttribute(n)})})}function j(e,t,i){X(t)?N(t,function(n,t){j(e,t,n)}):y(e,function(n){r(i)||""===i?F(n,t):n.setAttribute(t,String(i))})}function H(n,t,e){n=document.createElement(n);return t&&(M(t)?C:j)(n,t),e&&P(e,n),n}function Y(n,t,e){if(z(e))return getComputedStyle(n)[t];r(e)||(n.style[t]=""+e)}function q(n,t){Y(n,"display",t)}function U(n){n.setActive&&n.setActive()||n.focus({preventScroll:!0})}function K(n,t){return n.getAttribute(t)}function J(n,t){return n&&n.classList.contains(t)}function Q(n){return n.getBoundingClientRect()}function V(n){y(n,function(n){n&&n.parentNode&&n.parentNode.removeChild(n)})}function Z(n){return A((new DOMParser).parseFromString(n,"text/html").body)}function $(n,t){n.preventDefault(),t&&(n.stopPropagation(),n.stopImmediatePropagation())}function nn(n,t){return n&&n.querySelector(t)}function tn(n,t){return t?_(n.querySelectorAll(t)):[]}function en(n,t){L(n,t,!1)}function on(n){return n.timeStamp}function rn(n){return M(n)?n:n?n+"px":""}var un="splide",i="data-"+un;function sn(n,t){if(!n)throw new Error("["+un+"] "+(t||""))}var cn=Math.min,an=Math.max,fn=Math.floor,ln=Math.ceil,dn=Math.abs;function pn(n,t,e){return dn(n-t)<e}function hn(n,t,e,i){var o=cn(t,e),e=an(t,e);return i?o<n&&n<e:o<=n&&n<=e}function vn(n,t,e){var i=cn(t,e),e=an(t,e);return cn(an(i,n),e)}function gn(n){return(0<n)-(n<0)}function mn(t,n){return y(n,function(n){t=t.replace("%s",""+n)}),t}function yn(n){return n<10?"0"+n:""+n}var bn={};function wn(){var s=[];function e(n,e,i){y(n,function(t){t&&y(e,function(n){n.split(" ").forEach(function(n){n=n.split(".");i(t,n[0],n[1])})})})}return{bind:function(n,t,r,u){e(n,t,function(n,t,e){var i="addEventListener"in n,o=i?n.removeEventListener.bind(n,t,r,u):n.removeListener.bind(n,r);i?n.addEventListener(t,r,u):n.addListener(r),s.push([n,t,e,r,o])})},unbind:function(n,t,o){e(n,t,function(t,e,i){s=s.filter(function(n){return!!(n[0]!==t||n[1]!==e||n[2]!==i||o&&n[3]!==o)||(n[4](),!1)})})},dispatch:function(n,t,e){var i;return"function"==typeof CustomEvent?i=new CustomEvent(t,{bubbles:!0,detail:e}):(i=document.createEvent("CustomEvent")).initCustomEvent(t,!0,!1,e),n.dispatchEvent(i),i},destroy:function(){s.forEach(function(n){n[4]()}),x(s)}}}var En="mounted",Sn="move",xn="moved",_n="shifted",Cn="click",Pn="active",kn="inactive",Ln="visible",An="hidden",Dn="slide:keydown",Mn="refresh",zn="updated",Nn="resize",Tn="resized",On="scroll",In="scrolled",u="destroy",Fn="navigation:mounted",jn="autoplay:play",Rn="autoplay:pause",Wn="lazyload:loaded";function Gn(n){var e=n?n.event.bus:document.createDocumentFragment(),i=wn();return n&&n.event.on(u,i.destroy),T(i,{bus:e,on:function(n,t){i.bind(e,m(n).join(" "),function(n){t.apply(t,o(n.detail)?n.detail:[])})},off:D(i.unbind,e),emit:function(n){i.dispatch(e,n,_(arguments,1))}})}function Xn(t,n,e,i){var o,r,u=Date.now,s=0,c=!0,a=0;function f(){if(!c){if(s=t?cn((u()-o)/t,1):1,e&&e(s),1<=s&&(n(),o=u(),i&&++a>=i))return l();p(f)}}function l(){c=!0}function d(){r&&cancelAnimationFrame(r),c=!(r=s=0)}return{start:function(n){n||d(),o=u()-(n?s*t:0),c=!1,p(f)},rewind:function(){o=u(),s=0,e&&e(s)},pause:l,cancel:d,set:function(n){t=n},isPaused:function(){return c}}}function s(n){var t=n;return{set:function(n){t=n},is:function(n){return b(m(n),t)}}}var e="Arrow",Bn=e+"Left",Hn=e+"Right",c=e+"Up",a=e+"Down",Yn="ttb",f={width:["height"],left:["top","right"],right:["bottom","left"],x:["y"],X:["Y"],Y:["X"],ArrowLeft:[c,Hn],ArrowRight:[a,Bn]};var qn="role",Un="tabindex",e="aria-",Kn=e+"controls",Jn=e+"current",Qn=e+"selected",Vn=e+"label",Zn=e+"labelledby",$n=e+"hidden",nt=e+"orientation",tt=e+"roledescription",l=e+"live",et=e+"busy",it=e+"atomic",ot=[qn,Un,"disabled",Kn,Jn,Vn,Zn,$n,nt,tt],rt=un,ut=un+"__track",st=un+"__list",ct=un+"__slide",at=ct+"--clone",ft=ct+"__container",lt=un+"__arrows",dt=un+"__arrow",pt=dt+"--prev",ht=dt+"--next",vt=un+"__pagination",gt=vt+"__page",mt=un+"__progress"+"__bar",yt=un+"__toggle",bt=un+"__sr",wt="is-active",Et="is-prev",St="is-next",xt="is-visible",_t="is-loading",Ct="is-focus-in",Pt=[wt,xt,Et,St,_t,Ct];var kt="touchstart mousedown",Lt="touchmove mousemove",At="touchend touchcancel mouseup click";var Dt="slide",Mt="loop",zt="fade";function Nt(o,e,t,r){var i,n=Gn(o),u=n.on,s=n.emit,c=n.bind,a=o.Components,f=o.root,l=o.options,d=l.isNavigation,p=l.updateOnMove,h=l.i18n,v=l.pagination,g=l.slideFocus,m=a.Direction.resolve,y=K(r,"style"),b=K(r,Vn),w=-1<t,E=A(r,"."+ft),S=tn(r,l.focusableNodes||"");function x(){var n=o.splides.map(function(n){n=n.splide.Components.Slides.getAt(e);return n?n.slide.id:""}).join(" ");j(r,Vn,mn(h.slideX,(w?t:e)+1)),j(r,Kn,n),j(r,qn,g?"button":""),g&&F(r,tt)}function _(){i||C()}function C(){var n,t;i||(n=o.index,(t=P())!==J(r,wt)&&(L(r,wt,t),j(r,Jn,d&&t||""),s(t?Pn:kn,k)),function(){var n=function(){if(o.is(zt))return P();var n=Q(a.Elements.track),t=Q(r),e=m("left",!0),i=m("right",!0);return fn(n[e])<=ln(t[e])&&fn(t[i])<=ln(n[i])}(),t=!n&&(!P()||w);o.state.is([R,W])||j(r,$n,t||"");j(S,Un,t?-1:""),g&&j(r,Un,t?-1:0);n!==J(r,xt)&&(L(r,xt,n),s(n?Ln:An,k));n||document.activeElement!==r||(n=a.Slides.getAt(o.index))&&U(n.slide)}(),L(r,Et,e===n-1),L(r,St,e===n+1))}function P(){var n=o.index;return n===e||l.cloneStatus&&n===t}var k={index:e,slideIndex:t,slide:r,container:E,isClone:w,mount:function(){w||(r.id=f.id+"-slide"+yn(e+1),j(r,qn,v?"tabpanel":"group"),j(r,tt,h.slide),j(r,Vn,b||mn(h.slideLabel,[e+1,o.length]))),c(r,"click",D(s,Cn,k)),c(r,"keydown",D(s,Dn,k)),u([xn,_n,In],C),u(Fn,x),p&&u(Sn,_)},destroy:function(){i=!0,n.destroy(),en(r,Pt),F(r,ot),j(r,"style",y),j(r,Vn,b||"")},update:C,style:function(n,t,e){Y(e&&E||r,n,t)},isWithin:function(n,t){return n=dn(n-e),(n=!w&&(l.rewind||o.is(Mt))?cn(n,o.length-n):n)<=t}};return k}var Tt=i+"-interval";var Ot={passive:!1,capture:!0};var It={Spacebar:" ",Right:Hn,Left:Bn,Up:c,Down:a};function Ft(n){return n=M(n)?n:n.key,It[n]||n}var jt="keydown";var Rt=i+"-lazy",Wt=Rt+"-srcset",Gt="["+Rt+"], ["+Wt+"]";var Xt=[" ","Enter"];var Bt=Object.freeze({__proto__:null,Media:function(i,n,o){var r=i.state,t=o.breakpoints||{},u=o.reducedMotion||{},e=wn(),s=[];function c(n){n&&e.destroy()}function a(n,t){t=matchMedia(t);e.bind(t,"change",f),s.push([n,t])}function f(){var n=r.is(7),t=o.direction,e=s.reduce(function(n,t){return O(n,t[1].matches?t[0]:{})},{});I(o),l(e),o.destroy?i.destroy("completely"===o.destroy):n?(c(!0),i.mount()):t!==o.direction&&i.refresh()}function l(n,t){O(o,n),t&&O(Object.getPrototypeOf(o),n),r.is(1)||i.emit(zn,o)}return{setup:function(){var e="min"===o.mediaQuery;h(t).sort(function(n,t){return e?+n-+t:+t-+n}).forEach(function(n){a(t[n],"("+(e?"min":"max")+"-width:"+n+"px)")}),a(u,d),f()},destroy:c,reduce:function(n){matchMedia(d).matches&&(n?O(o,u):I(o,h(u)))},set:l}},Direction:function(n,t,o){return{resolve:function(n,t,e){var i="rtl"!==(e=e||o.direction)||t?e===Yn?0:-1:1;return f[n]&&f[n][i]||n.replace(/width|left|right/i,function(n,t){n=f[n.toLowerCase()][i]||n;return 0<t?n.charAt(0).toUpperCase()+n.slice(1):n})},orient:function(n){return n*("rtl"===o.direction?1:-1)}}},Elements:function(n,t,e){var i,o,r,u=Gn(n),s=u.on,c=u.bind,a=n.root,f=e.i18n,l={},d=[],p=[],h=[];function v(){i=y("."+ut),o=A(i,"."+st),sn(i&&o,"A track/list element is missing."),E(d,S(o,"."+ct+":not(."+at+")")),N({arrows:lt,pagination:vt,prev:pt,next:ht,bar:mt,toggle:yt},function(n,t){l[t]=y("."+n)}),T(l,{root:a,track:i,list:o,slides:d}),function(){var n=a.id||function(n){return""+n+yn(bn[n]=(bn[n]||0)+1)}(un),t=e.role;a.id=n,i.id=i.id||n+"-track",o.id=o.id||n+"-list",!K(a,qn)&&"SECTION"!==a.tagName&&t&&j(a,qn,t);j(a,tt,f.carousel),j(o,qn,"presentation")}(),m()}function g(n){var t=ot.concat("style");x(d),en(a,p),en(i,h),F([i,o],t),F(a,n?t:["style",tt])}function m(){en(a,p),en(i,h),p=b(rt),h=b(ut),C(a,p),C(i,h),j(a,Vn,e.label),j(a,Zn,e.labelledby)}function y(n){n=nn(a,n);return n&&function(n,t){if(w(n.closest))return n.closest(t);for(var e=n;e&&1===e.nodeType&&!B(e,t);)e=e.parentElement;return e}(n,"."+rt)===a?n:void 0}function b(n){return[n+"--"+e.type,n+"--"+e.direction,e.drag&&n+"--draggable",e.isNavigation&&n+"--nav",n===rt&&wt]}return T(l,{setup:v,mount:function(){s(Mn,g),s(Mn,v),s(zn,m),c(document,kt+" keydown",function(n){r="keydown"===n.type},{capture:!0}),c(a,"focusin",function(){L(a,Ct,!!r)})},destroy:g})},Slides:function(i,o,r){var n=Gn(i),t=n.on,u=n.emit,s=n.bind,c=(n=o.Elements).slides,a=n.list,f=[];function e(){c.forEach(function(n,t){d(n,t,-1)})}function l(){h(function(n){n.destroy()}),x(f)}function d(n,t,e){n=Nt(i,t,e,n);n.mount(),f.push(n)}function p(n){return n?v(function(n){return!n.isClone}):f}function h(n,t){p(t).forEach(n)}function v(t){return f.filter(w(t)?t:function(n){return M(t)?B(n.slide,t):b(m(t),n.index)})}return{mount:function(){e(),t(Mn,l),t(Mn,e),t([En,Mn],function(){f.sort(function(n,t){return n.index-t.index})})},destroy:l,update:function(){h(function(n){n.update()})},register:d,get:p,getIn:function(n){var t=o.Controller,e=t.toIndex(n),i=t.hasFocus()?1:r.perPage;return v(function(n){return hn(n.index,e,e+i-1)})},getAt:function(n){return v(n)[0]},add:function(n,o){y(n,function(n){var t,e,i;g(n=M(n)?Z(n):n)&&((t=c[o])?k(n,t):P(a,n),C(n,r.classes.slide),n=n,e=D(u,Nn),n=tn(n,"img"),(i=n.length)?n.forEach(function(n){s(n,"load error",function(){--i||e()})}):e())}),u(Mn)},remove:function(n){V(v(n).map(function(n){return n.slide})),u(Mn)},forEach:h,filter:v,style:function(t,e,i){h(function(n){n.style(t,e,i)})},getLength:function(n){return(n?c:f).length},isEnough:function(){return f.length>r.perPage}}},Layout:function(n,t,e){var i,o,r=(c=Gn(n)).on,u=c.bind,s=c.emit,c=t.Slides,a=t.Direction.resolve,f=(t=t.Elements).root,l=t.track,d=t.list,p=c.getAt,h=c.style;function v(){o=null,i=e.direction===Yn,Y(f,"maxWidth",rn(e.width)),Y(l,a("paddingLeft"),m(!1)),Y(l,a("paddingRight"),m(!0)),g()}function g(){var n=Q(f);o&&o.width===n.width&&o.height===n.height||(Y(l,"height",function(){var n="";i&&(sn(n=y(),"height or heightRatio is missing."),n="calc("+n+" - "+m(!1)+" - "+m(!0)+")");return n}()),h(a("marginRight"),rn(e.gap)),h("width",e.autoWidth?null:rn(e.fixedWidth)||(i?"":b())),h("height",rn(e.fixedHeight)||(i?e.autoHeight?null:b():y()),!0),o=n,s(Tn))}function m(n){var t=e.padding,n=a(n?"right":"left");return t&&rn(t[n]||(X(t)?0:t))||"0px"}function y(){return rn(e.height||Q(d).width*e.heightRatio)}function b(){var n=rn(e.gap);return"calc((100%"+(n&&" + "+n)+")/"+(e.perPage||1)+(n&&" - "+n)+")"}function w(n,t){var e=p(n);if(e){n=Q(e.slide)[a("right")],e=Q(d)[a("left")];return dn(n-e)+(t?0:E())}return 0}function E(){var n=p(0);return n&&parseFloat(Y(n.slide,a("marginRight")))||0}return{mount:function(){var n,t,e;v(),u(window,"resize load",(n=D(s,Nn),function(){e||(e=Xn(t||0,function(){n(),e=null},null,1)).start()})),r([zn,Mn],v),r(Nn,g)},listSize:function(){return Q(d)[a("width")]},slideSize:function(n,t){return(n=p(n||0))?Q(n.slide)[a("width")]+(t?0:E()):0},sliderSize:function(){return w(n.length-1,!0)-w(-1,!0)},totalSize:w,getPadding:function(n){return parseFloat(Y(l,a("padding"+(n?"Right":"Left"))))||0}}},Clones:function(s,e,c){var n,t=Gn(s),i=t.on,o=t.emit,a=e.Elements,f=e.Slides,r=e.Direction.resolve,l=[];function u(){(n=h())&&(function(o){var r=f.get().slice(),u=r.length;if(u){for(;r.length<o;)E(r,r);E(r.slice(-o),r.slice(0,o)).forEach(function(n,t){var e=t<o,i=function(n,t){n=n.cloneNode(!0);return C(n,c.classes.clone),n.id=s.root.id+"-clone"+yn(t+1),n}(n.slide,t);e?k(i,r[0].slide):P(a.list,i),E(l,i),f.register(i,t-o+(e?0:u),n.index)})}}(n),o(Nn))}function d(){V(l),x(l)}function p(){n<h()&&o(Mn)}function h(){var n,t=c.clones;return s.is(Mt)?t||(t=(n=c[r("fixedWidth")]&&e.Layout.slideSize(0))&&ln(Q(a.track)[r("width")]/n)||c[r("autoWidth")]&&s.length||2*c.perPage):t=0,t}return{mount:function(){u(),i(Mn,d),i(Mn,u),i([zn,Nn],p)},destroy:d}},Move:function(i,s,o){var u,n=Gn(i),t=n.on,c=n.emit,a=i.state.set,r=(n=s.Layout).slideSize,e=n.getPadding,f=n.totalSize,l=n.listSize,d=n.sliderSize,p=(n=s.Direction).resolve,h=n.orient,v=(n=s.Elements).list,g=n.track;function m(){s.Controller.isBusy()||(s.Scroll.cancel(),y(i.index),s.Slides.update())}function y(n){b(x(n,!0))}function b(n,t){i.is(zt)||(t=t?n:function(n){{var t,e;i.is(Mt)&&(t=S(n),e=t>s.Controller.getEnd(),(t<0||e)&&(n=w(n,e)))}return n}(n),Y(v,"transform","translate"+p("X")+"("+t+"px)"),n!==t&&c(_n))}function w(n,t){var e=n-C(t),i=d();return n-=h(i*(ln(dn(e)/i)||1))*(t?1:-1)}function E(){b(_()),u.cancel()}function S(n){for(var t=s.Slides.get(),e=0,i=1/0,o=0;o<t.length;o++){var r=t[o].index,u=dn(x(r,!0)-n);if(!(u<=i))break;i=u,e=r}return e}function x(n,t){var e=h(f(n-1)-(e=n,"center"===(n=o.focus)?(l()-r(e,!0))/2:+n*r(e)||0));return t?function(n){o.trimSpace&&i.is(Dt)&&(n=vn(n,0,h(d()-l())));return n}(e):e}function _(){var n=p("left");return Q(v)[n]-Q(g)[n]+h(e(!1))}function C(n){return x(n?s.Controller.getEnd():0,!!o.trimSpace)}return{mount:function(){u=s.Transition,t([En,Tn,zn,Mn],m)},move:function(n,t,e,i){var o,r;n!==t&&(o=e<n,r=h(w(_(),o)),o?0<=r:r<=v[p("scrollWidth")]-Q(g)[p("width")])&&(E(),b(w(_(),e<n),!0)),a(R),c(Sn,t,e,n),u.start(t,function(){a(3),c(xn,t,e,n),i&&i()})},jump:y,translate:b,shift:w,cancel:E,toIndex:S,toPosition:x,getPosition:_,getLimit:C,exceededLimit:function(n,t){t=z(t)?_():t;var e=!0!==n&&h(t)<h(C(!1)),t=!1!==n&&h(t)>h(C(!0));return e||t},reposition:m}},Controller:function(r,o,u){var s,c,a,n=Gn(r).on,f=o.Move,l=f.getPosition,i=f.getLimit,d=f.toPosition,t=o.Slides,p=t.isEnough,e=t.getLength,h=r.is(Mt),v=r.is(Dt),g=D(E,!1),m=D(E,!0),y=u.start||0,b=y;function w(){s=e(!0),c=u.perMove,a=u.perPage;var n=vn(y,0,s-1);n!==y&&(y=n,f.reposition())}function E(n,t){var e=c||(L()?1:a),e=S(y+e*(n?-1:1),y,!(c||L()));return-1===e&&v&&!pn(l(),i(!n),1)?n?0:_():t?e:x(e)}function S(n,t,e){var i,o;return p()?(i=_(),(o=function(n){if(v&&"move"===u.trimSpace&&n!==y)for(var t=l();t===d(n,!0)&&hn(n,0,r.length-1,!u.rewind);)n<y?--n:++n;return n}(n))!==n&&(t=n,n=o,e=!1),n<0||i<n?n=c||!hn(0,n,t,!0)&&!hn(i,t,n,!0)?h?e?n<0?-(s%a||a):s:n:u.rewind?n<0?i:0:-1:C(P(n)):e&&n!==t&&(n=C(P(t)+(n<t?-1:1)))):n=-1,n}function x(n){return h?(n+s)%s||0:n}function _(){return an(s-(L()||h&&c?1:a),0)}function C(n){return vn(L()?n:a*n,0,_())}function P(n){return L()?n:fn((n>=_()?s-1:n)/a)}function k(n){n!==y&&(b=y,y=n)}function L(){return!z(u.focus)||u.isNavigation}function A(){return r.state.is([R,W])&&!!u.waitForTransition}return{mount:function(){w(),n([zn,Mn],w)},go:function(n,t,e){var i;A()||-1<(n=x(i=function(n){var t=y;{var e,i;M(n)?(i=n.match(/([+\-<>])(\d+)?/)||[],e=i[1],i=i[2],"+"===e||"-"===e?t=S(y+ +(""+e+(+i||1)),y):">"===e?t=i?C(+i):g(!0):"<"===e&&(t=m(!0))):t=h?n:vn(n,0,_())}return t}(n)))&&(t||n!==y)&&(k(n),f.move(i,n,b,e))},scroll:function(n,t,e,i){o.Scroll.scroll(n,t,e,function(){k(x(f.toIndex(l()))),i&&i()})},getNext:g,getPrev:m,getAdjacent:E,getEnd:_,setIndex:k,getIndex:function(n){return n?b:y},toIndex:C,toPage:P,toDest:function(n){return n=f.toIndex(n),v?vn(n,0,_()):n},hasFocus:L,isBusy:A}},Arrows:function(o,n,t){var e,i,r=Gn(o),u=r.on,s=r.bind,c=r.emit,a=t.classes,f=t.i18n,l=n.Elements,d=n.Controller,p=l.arrows,h=l.track,v=p,g=l.prev,m=l.next,y={};function b(){!function(){var n=t.arrows;!n||g&&m||(v=p||H("div",a.arrows),g=x(!0),m=x(!1),e=!0,P(v,[g,m]),p||k(v,h));g&&m&&(T(y,{prev:g,next:m}),q(v,n?"":"none"),C(v,i=lt+"--"+t.direction),n&&(u([xn,Mn,In],_),s(m,"click",D(S,">")),s(g,"click",D(S,"<")),_(),j([g,m],Kn,h.id),c("arrows:mounted",g,m)))}(),u(zn,w)}function w(){E(),b()}function E(){r.destroy(),en(v,i),e?(V(p?[g,m]:v),g=m=null):F([g,m],ot)}function S(n){d.go(n,!0)}function x(n){return Z('<button class="'+a.arrow+" "+(n?a.prev:a.next)+'" type="button"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 40 40" width="40" height="40" focusable="false"><path d="'+(t.arrowPath||"m15.5 0.932-4.3 4.38 14.5 14.6-14.5 14.5 4.3 4.4 14.6-14.6 4.4-4.3-4.4-4.4-14.6-14.6z")+'" />')}function _(){var n=o.index,t=d.getPrev(),e=d.getNext(),i=-1<t&&n<t?f.last:f.prev,n=-1<e&&e<n?f.first:f.next;g.disabled=t<0,m.disabled=e<0,j(g,Vn,i),j(m,Vn,n),c("arrows:updated",g,m,t,e)}return{arrows:y,mount:b,destroy:E}},Autoplay:function(n,t,e){var i,o,r=Gn(n),u=r.on,s=r.bind,c=r.emit,a=Xn(e.interval,n.go.bind(n,">"),function(n){var t=l.bar;t&&Y(t,"width",100*n+"%"),c("autoplay:playing",n)}),f=a.isPaused,l=t.Elements,d=(n=t.Elements).root,p=n.toggle,h=e.autoplay,v="pause"===h;function g(){f()&&t.Slides.isEnough()&&(a.start(!e.resetProgress),o=i=v=!1,b(),c(jn))}function m(n){v=!!(n=void 0===n?!0:n),b(),f()||(a.pause(),c(Rn))}function y(){v||(i||o?m(!1):g())}function b(){p&&(L(p,wt,!v),j(p,Vn,e.i18n[v?"play":"pause"]))}function w(n){n=t.Slides.getAt(n);a.set(n&&+K(n.slide,Tt)||e.interval)}return{mount:function(){h&&(function(){e.pauseOnHover&&s(d,"mouseenter mouseleave",function(n){i="mouseenter"===n.type,y()});e.pauseOnFocus&&s(d,"focusin focusout",function(n){o="focusin"===n.type,y()});p&&s(p,"click",function(){v?g():m(!0)});u([Sn,On,Mn],a.rewind),u(Sn,w)}(),p&&j(p,Kn,l.track.id),v||g(),b())},destroy:a.cancel,play:g,pause:m,isPaused:f}},Cover:function(n,t,e){var i=Gn(n).on;function o(e){t.Slides.forEach(function(n){var t=A(n.container||n.slide,"img");t&&t.src&&r(e,t,n)})}function r(n,t,e){e.style("background",n?'center/cover no-repeat url("'+t.src+'")':"",!0),q(t,n?"none":"")}return{mount:function(){e.cover&&(i(Wn,D(r,!0)),i([En,zn,Mn],D(o,!0)))},destroy:D(o,!1)}},Scroll:function(r,s,u){var c,a,n=Gn(r),t=n.on,f=n.emit,l=r.state.set,d=s.Move,p=d.getPosition,h=d.getLimit,v=d.exceededLimit,g=d.translate,m=1;function y(n,t,e,i,o){var r=p();E(),e&&(e=s.Layout.sliderSize(),u=gn(n)*e*fn(dn(n)/e)||0,n=d.toPosition(s.Controller.toDest(n%e))+u);var u=pn(r,n,1);m=1,t=u?0:t||an(dn(n-r)/1.5,800),a=i,c=Xn(t,b,D(w,r,n,o),1),l(W),f(On),c.start()}function b(){l(3),a&&a(),f(In)}function w(n,t,e,i){var o=p(),n=(n+(t-n)*(n=i,(i=u.easingFunc)?i(n):1-Math.pow(1-n,4))-o)*m;g(o+n),r.is(Dt)&&!e&&v()&&(m*=.6,dn(n)<10&&y(h(v(!0)),600,!1,a,!0))}function E(){c&&c.cancel()}function e(){c&&!c.isPaused()&&(E(),b())}return{mount:function(){t(Sn,E),t([zn,Mn],e)},destroy:E,scroll:y,cancel:e}},Drag:function(r,i,u){var s,t,o,c,a,f,l,d,n=Gn(r),e=n.on,p=n.emit,h=n.bind,v=n.unbind,g=r.state,m=i.Move,y=i.Scroll,b=i.Controller,w=i.Elements.track,E=i.Media.reduce,S=(n=i.Direction).resolve,x=n.orient,_=m.getPosition,C=m.exceededLimit,P=!1;function k(){var n=u.drag;j(!n),c="free"===n}function L(n){var t,e,i;f=!1,l||(t=F(n),e=n.target,i=u.noDrag,B(e,"."+gt+", ."+dt)||i&&B(e,i)||!t&&n.button||(b.isBusy()?$(n,!0):(d=t?w:window,a=g.is([R,W]),o=null,h(d,Lt,A,Ot),h(d,At,D,Ot),m.cancel(),y.cancel(),z(n))))}function A(n){var t,e,i,o;g.is(6)||(g.set(6),p("drag")),n.cancelable&&(a?(m.translate(s+N(n)/(P&&r.is(Dt)?5:1)),e=200<T(n),i=P!==(P=C()),(e||i)&&z(n),f=!0,p("dragging"),$(n)):dn(N(o=n))>dn(N(o,!0))&&(t=n,e=u.dragMinThreshold,i=X(e),o=i&&e.mouse||0,e=(i?e.touch:+e)||10,a=dn(N(t))>(F(t)?e:o),$(n)))}function D(n){g.is(6)&&(g.set(3),p("dragged")),a&&(function(n){var t=function(n){if(r.is(Mt)||!P){var t=T(n);if(t&&t<200)return N(n)/t}return 0}(n),e=function(n){return _()+gn(n)*cn(dn(n)*(u.flickPower||600),c?1/0:i.Layout.listSize()*(u.flickMaxPages||1))}(t),n=u.rewind&&u.rewindByDrag;E(!1),c?b.scroll(e,0,u.snap):r.is(zt)?b.go(x(gn(t))<0?n?"<":"-":n?">":"+"):r.is(Dt)&&P&&n?b.go(C(!0)?">":"<"):b.go(b.toDest(e),!0);E(!0)}(n),$(n)),v(d,Lt,A),v(d,At,D),a=!1}function M(n){!l&&f&&$(n,!0)}function z(n){o=t,t=n,s=_()}function N(n,t){return I(n,t)-I(O(n),t)}function T(n){return on(n)-on(O(n))}function O(n){return t===n&&o||t}function I(n,t){return(F(n)?n.changedTouches[0]:n)["page"+S(t?"Y":"X")]}function F(n){return"undefined"!=typeof TouchEvent&&n instanceof TouchEvent}function j(n){l=n}return{mount:function(){h(w,Lt,G,Ot),h(w,At,G,Ot),h(w,kt,L,Ot),h(w,"click",M,{capture:!0}),h(w,"dragstart",$),e([En,zn],k)},disable:j,isDragging:function(){return a}}},Keyboard:function(t,n,e){var i,o,r=Gn(t),u=r.on,s=r.bind,c=r.unbind,a=t.root,f=n.Direction.resolve;function l(){var n=e.keyboard;n&&(i="global"===n?window:a,s(i,jt,h))}function d(){c(i,jt)}function p(){var n=o;o=!0,v(function(){o=n})}function h(n){o||((n=Ft(n))===f(Bn)?t.go("<"):n===f(Hn)&&t.go(">"))}return{mount:function(){l(),u(zn,d),u(zn,l),u(Sn,p)},destroy:d,disable:function(n){o=n}}},LazyLoad:function(e,n,o){var t=Gn(e),i=t.on,r=t.off,u=t.bind,s=t.emit,c="sequential"===o.lazyLoad,a=[En,Mn,xn,In],f=[];function l(){x(f),n.Slides.forEach(function(i){tn(i.slide,Gt).forEach(function(n){var t=K(n,Rt),e=K(n,Wt);t===n.src&&e===n.srcset||(t=o.classes.spinner,e=A(e=n.parentElement,"."+t)||H("span",t,e),f.push([n,i,e]),n.src||q(n,"none"))})}),c&&v()}function d(){(f=f.filter(function(n){var t=o.perPage*((o.preloadPages||1)+1)-1;return!n[1].isWithin(e.index,t)||p(n)})).length||r(a)}function p(n){var t=n[0];C(n[1].slide,_t),u(t,"load error",D(h,n)),j(t,"src",K(t,Rt)),j(t,"srcset",K(t,Wt)),F(t,Rt),F(t,Wt)}function h(n,t){var e=n[0],i=n[1];en(i.slide,_t),"error"!==t.type&&(V(n[2]),q(e,""),s(Wn,e,i),s(Nn)),c&&v()}function v(){f.length&&p(f.shift())}return{mount:function(){o.lazyLoad&&(l(),i(Mn,l),c||i(a,d))},destroy:D(x,f)}},Pagination:function(f,n,l){var d,p,t=Gn(f),e=t.on,i=t.emit,h=t.bind,v=n.Slides,g=n.Elements,o=n.Controller,m=o.hasFocus,r=o.getIndex,u=o.go,s=n.Direction.resolve,y=[];function c(){d&&(V(g.pagination?_(d.children):d),en(d,p),x(y),d=null),t.destroy()}function b(n){u(">"+n,!0)}function w(n,t){var e=y.length,i=Ft(t),o=E(),r=-1;i===s(Hn,!1,o)?r=++n%e:i===s(Bn,!1,o)?r=(--n+e)%e:"Home"===i?r=0:"End"===i&&(r=e-1);e=y[r];e&&(U(e.button),u(">"+r),$(t,!0))}function E(){return l.paginationDirection||l.direction}function a(n){return y[o.toPage(n)]}function S(){var n,t=a(r(!0)),e=a(r());t&&(en(n=t.button,wt),F(n,Qn),j(n,Un,-1)),e&&(C(n=e.button,wt),j(n,Qn,!0),j(n,Un,"")),i("pagination:updated",{list:d,items:y},t,e)}return{items:y,mount:function n(){c(),e([zn,Mn],n),l.pagination&&v.isEnough()&&(e([Sn,On,In],S),function(){var n=f.length,t=l.classes,e=l.i18n,i=l.perPage,o=m()?n:ln(n/i);C(d=g.pagination||H("ul",t.pagination,g.track.parentElement),p=vt+"--"+E()),j(d,qn,"tablist"),j(d,Vn,e.select),j(d,nt,E()===Yn?"vertical":"");for(var r=0;r<o;r++){var u=H("li",null,d),s=H("button",{class:t.page,type:"button"},u),c=v.getIn(r).map(function(n){return n.slide.id}),a=!m()&&1<i?e.pageX:e.slideX;h(s,"click",D(b,r)),l.paginationKeyboard&&h(s,"keydown",D(w,r)),j(u,qn,"presentation"),j(s,qn,"tab"),j(s,Kn,c.join(" ")),j(s,Vn,mn(a,r+1)),j(s,Un,-1),y.push({li:u,button:s,page:r})}}(),S(),i("pagination:mounted",{list:d,items:y},a(f.index)))},destroy:c,getAt:a,update:S}},Sync:function(e,n,t){var i=t.isNavigation,o=t.slideFocus,r=[];function u(){var n,t;e.splides.forEach(function(n){n.isParent||(c(e,n.splide),c(n.splide,e))}),i&&(n=Gn(e),(t=n.on)(Cn,f),t(Dn,l),t([En,zn],a),r.push(n),n.emit(Fn,e.splides))}function s(){r.forEach(function(n){n.destroy()}),x(r)}function c(n,i){n=Gn(n);n.on(Sn,function(n,t,e){i.go(i.is(Mt)?e:n)}),r.push(n)}function a(){j(n.Elements.list,nt,t.direction===Yn?"vertical":"")}function f(n){e.go(n.index)}function l(n,t){b(Xt,Ft(t))&&(f(n),$(t))}return{setup:function(){e.options={slideFocus:z(o)?i:o}},mount:u,destroy:s,remount:function(){s(),u()}}},Wheel:function(u,s,c){var n=Gn(u).bind,a=0;function t(n){var t,e,i,o,r;n.cancelable&&(r=(t=n.deltaY)<0,e=on(n),i=c.wheelMinThreshold||0,o=c.wheelSleep||0,dn(t)>i&&o<e-a&&(u.go(r?"<":">"),a=e),r=r,c.releaseWheel&&!u.state.is(R)&&-1===s.Controller.getAdjacent(r)||$(n))}return{mount:function(){c.wheel&&n(s.Elements.track,"wheel",t,Ot)}}},Live:function(n,t,e){var i=Gn(n).on,o=t.Elements.track,r=e.live&&!e.isNavigation,u=H("span",bt),s=Xn(90,D(c,!1));function c(n){j(o,et,n),n?(P(o,u),s.start()):V(u)}function a(n){r&&j(o,l,n?"off":"polite")}return{mount:function(){r&&(a(!t.Autoplay.isPaused()),j(o,it,!0),u.textContent="…",i(jn,D(a,!0)),i(Rn,D(a,!1)),i([xn,In],D(c,!0)))},disable:a,destroy:function(){F(o,[l,it,et]),V(u)}}}}),Ht={type:"slide",role:"region",speed:400,perPage:1,cloneStatus:!0,arrows:!0,pagination:!0,paginationKeyboard:!0,interval:5e3,pauseOnHover:!0,pauseOnFocus:!0,resetProgress:!0,easing:"cubic-bezier(0.25, 1, 0.5, 1)",drag:!0,direction:"ltr",trimSpace:!0,focusableNodes:"a, button, textarea, input, select, iframe",live:!0,classes:{slide:ct,clone:at,arrows:lt,arrow:dt,prev:pt,next:ht,pagination:vt,page:gt,spinner:un+"__spinner"},i18n:{prev:"Previous slide",next:"Next slide",first:"Go to first slide",last:"Go to last slide",slideX:"Go to slide %s",pageX:"Go to page %s",play:"Start autoplay",pause:"Pause autoplay",carousel:"carousel",slide:"slide",select:"Select a slide to show",slideLabel:"%s of %s"},reducedMotion:{speed:0,rewindSpeed:0,autoplay:"pause"}};function Yt(n,i,t){var e=Gn(n).on;return{mount:function(){e([En,Mn],function(){v(function(){i.Slides.style("transition","opacity "+t.speed+"ms "+t.easing)})})},start:function(n,t){var e=i.Elements.track;Y(e,"height",rn(Q(e).height)),v(function(){t(),Y(e,"height","")})},cancel:G}}function qt(r,n,u){var s,t=Gn(r).bind,c=n.Move,a=n.Controller,f=n.Scroll,e=n.Elements.list,l=D(Y,e,"transition");function i(){l(""),f.cancel()}return{mount:function(){t(e,"transitionend",function(n){n.target===e&&s&&(i(),s())})},start:function(n,t){var e=c.toPosition(n,!0),i=c.getPosition(),o=function(n){var t=u.rewindSpeed;if(r.is(Dt)&&t){var e=a.getIndex(!0),i=a.getEnd();if(0===e&&i<=n||i<=e&&0===n)return t}return u.speed}(n);1<=dn(e-i)&&1<=o?u.useScroll?f.scroll(e,o,!1,t):(l("transform "+o+"ms "+u.easing),c.translate(e,!0),s=t):(c.jump(n),t())},cancel:i}}a=function(){function e(n,t){this.event=Gn(),this.Components={},this.state=s(1),this.splides=[],this._o={},this._E={};n=M(n)?nn(document,n):n;sn(n,n+" is invalid."),t=O({label:K(this.root=n,Vn)||"",labelledby:K(n,Zn)||""},Ht,e.defaults,t||{});try{O(t,JSON.parse(K(n,i)))}catch(n){sn(!1,"Invalid JSON")}this._o=Object.create(O({},t))}var n=e.prototype;return n.mount=function(n,t){var e=this,i=this.state,o=this.Components;return sn(i.is([1,7]),"Already mounted!"),i.set(1),this._C=o,this._T=t||this._T||(this.is(zt)?Yt:qt),this._E=n||this._E,N(T({},Bt,this._E,{Transition:this._T}),function(n,t){n=n(e,o,e._o);(o[t]=n).setup&&n.setup()}),N(o,function(n){n.mount&&n.mount()}),this.emit(En),C(this.root,"is-initialized"),i.set(3),this.emit("ready"),this},n.sync=function(n){return this.splides.push({splide:n}),n.splides.push({splide:this,isParent:!0}),this.state.is(3)&&(this._C.Sync.remount(),n.Components.Sync.remount()),this},n.go=function(n){return this._C.Controller.go(n),this},n.on=function(n,t){return this.event.on(n,t),this},n.off=function(n){return this.event.off(n),this},n.emit=function(n){var t;return(t=this.event).emit.apply(t,[n].concat(_(arguments,1))),this},n.add=function(n,t){return this._C.Slides.add(n,t),this},n.remove=function(n){return this._C.Slides.remove(n),this},n.is=function(n){return this._o.type===n},n.refresh=function(){return this.emit(Mn),this},n.destroy=function(t){void 0===t&&(t=!0);var n=this.event,e=this.state;return e.is(1)?Gn(this).on("ready",this.destroy.bind(this,t)):(N(this._C,function(n){n.destroy&&n.destroy(t)},!0),n.emit(u),n.destroy(),t&&x(this.splides),e.set(7)),this},_createClass(e,[{key:"options",get:function(){return this._o},set:function(n){this._C.Media.set(n,!0)}},{key:"length",get:function(){return this._C.Slides.getLength(!0)}},{key:"index",get:function(){return this._C.Controller.getIndex()}}]),e}();return a.defaults={},a.STATES=n,a});
//# sourceMappingURL=splide.min.js.map
