(function(){var t=$(".doceditor");var e=$("#bundles_basedir").attr("href");var i="sourcedialog,image2,entities";["webkit-span-fix","heading-button"].forEach(function(t){CKEDITOR.plugins.addExternal(t,e+"/icsemembers/lib/ckeditor/plugins/"+t+"/","plugin.js");i+=","+t});t.ckeditor(function(){},{extraPlugins:i,customConfig:"",extraAllowedContent:"*[id](*)",toolbar:[{name:"styles",items:["HeadingButton"]},{name:"basicstyles",items:["Bold","Italic","-","RemoveFormat"]},{name:"editing",items:["Scayt","-","Sourcedialog"]},"/",{name:"styles2",items:["Format"]},{name:"insert",items:["NumberedList","BulletedList","-","Link","Image","HorizontalRule"]},{name:"tools",items:["Maximize","ShowBlocks","-","About"]}],width:490,image2_alignClasses:["image-left","image-center","image-right"],image2_captionedClass:"image-captioned",entities_processNumerical:true});function n(t){this.ckeditor=t.ckeditorGet()}n.prototype.getContent=function(){return this.ckeditor.getData()};n.prototype.setContent=function(t){return this.ckeditor.setData(t)};n.prototype.onChange=function(t){return this.ckeditor.on("change",t)};$.fn.icseDocEditor=function(){return new n(this)}})();
(function(){$(".email_buttons button").button();var e=$("#preview_dialog");var t=$("#editable");var i=$("#icse_email");e.dialog({autoOpen:false,modal:true,resizable:true,width:800,height:500});function n(e,t,i){var n=$.Deferred();var a=$("<div>").html(e).dialog({close:function(){},resizable:false,modal:true,width:400,buttons:{s:function(){}}});var o=a.parent().find(".ui-dialog-buttonset");a.dialog("option","buttons",[{text:t,click:function(){$(".email_buttons .loading_spinner").clone().prependTo(o).show();o.find("button").button("disable");var e=i();e.done(function(){a.dialog("close");n.resolve()}).fail(function(){o.find(".loading_spinner").remove();o.find("button").button("enable")})}},{text:"Cancel",click:function(){a.dialog("close")}}]);return n.promise()}function a(){var e="test";try{localStorage.setItem(e,e);localStorage.removeItem(e);return true}catch(t){return false}}var o;var l=$("#email_options_pane");var r=l.find("input[name='form[mailing_list]']");var s=l.find("input[name='form[send_to_option]']");var d=function(){};var c=function(){};if(a()){var u=$.initNamespaceStorage("icse_email_draft").localStorage;function f(){var e=u.get("body");if(e){e=$("<div>").append(e);var i=$("<div>").append(t.icseDocEditor().getContent());var n=i.find("#email_upcoming_rehearsals");var a=e.find("#email_upcoming_rehearsals");if(a.length){a.replaceWith(n)}else{e.append(n)}t.icseDocEditor().setContent(e.html())}o=u.get(["subject","mailing_list","send_to_option","send_to_address"]);if(o["email_subject"]){l.find("#email_subject").val(o["subject"])}if(o["send_to_address"]){l.find("#send_to_address").val(o["send_to_address"])}if(o["mailing_list"]){r.filter("[value="+o["mailing_list"]+"]").prop("checked",true)}if(o["send_to_option"]){s.filter("[value="+o["send_to_option"]+"]").prop("checked",true)}}f();d=function(){var e=t.icseDocEditor().getContent();u.set("body",e);$(".saved_indicator").show()};c=function(){u.set(o);u.remove("subject")}}var _;t.icseDocEditor().onChange(function(){$(".saved_indicator").hide();clearTimeout(_);_=setTimeout(d,1e3)});l.find("#send_to_address").tagit({availableTags:["icse@imperial.ac.uk"],autocomplete:{delay:0,minLength:1}});var v=l.find("#send_to_row").find("ul.tagit");function m(){var e=l.find("#email_subject").val();var t=l.find("#send_to_address").val();var n=r.filter(":checked").val();if(n=="none"){s.filter("[value=mailing_list]").prop("disabled",true);s.filter("[value=other]").prop("checked",true)}else{s.filter("[value=mailing_list]").prop("disabled",false)}var a=s.filter(":checked").val();if(a=="other"){v.removeClass("disabled")}else{v.addClass("disabled")}o={email_subject:e,mailing_list:n,send_to_option:a,send_to_address:t};c();i.find("[class^=ml_]").hide();i.find("[class^=ml_"+o["mailing_list"]+"]").show()}m();l.find("input").change(m);v.click(function(){s.filter("[value=other]").prop("checked",true);m()});function p(){l.find("#form_body").val(t.icseDocEditor().getContent());return l.find("form").serialize()}$("button.preview").click(function(){e.dialog("open");e.html($(".email_buttons .loading_spinner").clone().removeAttr("hidden"));e.load(e.data("base-url"),p())});$("button.send").click(function(){n("Send email?","Send",function(){var e=$.Deferred();var t=$("button.send").data("base-url");$.ajax({type:"POST",data:p(),url:t,dataType:"json"}).always(function(t){if(t.status=="success"){e.resolve()}else{e.reject()}});return e})})})();