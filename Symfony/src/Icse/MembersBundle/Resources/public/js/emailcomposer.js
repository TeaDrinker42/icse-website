(function(){$(".email_buttons button").button();var j=$("#preview_frame");var g=$("#editable");j.dialog({autoOpen:false,modal:true,resizable:true,width:800,height:500});$("button.preview").click(function(){j.dialog("open");j.attr("src",j.data("base-url")+"?"+$.param({body:g.ckeditorGet().getData()}))});g.ckeditor(function(){},{extraPlugins:"webkit-span-fix,sourcedialog",customConfig:"",extraAllowedContent:"*[id](*)",toolbar:[{name:"basicstyles",items:["Bold","Italic","Underline","-","RemoveFormat"]},{name:"paragraph",items:[]},{name:"insert",items:["NumberedList","BulletedList","-","Link","Image","HorizontalRule"]},"/",{name:"styles",items:["Format"]},{name:"editing",items:["Sourcedialog","-","Scayt"]},{name:"tools",items:["Maximize","ShowBlocks","-","About"]}],width:490});function n(){var p="test";try{localStorage.setItem(p,p);localStorage.removeItem(p);return true}catch(o){return false}}var h;var m=$("#email_options_pane");var c=m.find("input[name=mailing_list]");var d=m.find("input[name=send_to_option]");var a=function(){};var f=function(o){};if(n()){var e=$.initNamespaceStorage("icse_email_draft").localStorage;function i(){var r=e.get("body");if(r){r=$("<div>").append(r);var q=$("<div>").append(g.ckeditorGet().getData());var o=q.find("#email_upcoming_rehearsals");var p=r.find("#email_upcoming_rehearsals");if(p.length){p.replaceWith(o)}else{r.append(o)}g.ckeditorGet().setData(r.html())}h=e.get(["subject","mailing_list","send_to_option","send_to_address"]);m.find("#email_subject").val(h.subject);m.find("#send_to_address").val(h.send_to_address);c.filter("[value="+h.mailing_list+"]").prop("checked",true);d.filter("[value="+h.send_to_option+"]").prop("checked",true)}i();a=function(){var o=g.ckeditorGet().getData();e.set("body",o);$(".saved_indicator").show()};f=function(o){e.set(o)}}var l;g.ckeditorGet().on("change",function(){$(".saved_indicator").hide();clearTimeout(l);l=setTimeout(a,1000)});m.find("#send_to_address").tagit({availableTags:["icse@imperial.ac.uk"],autocomplete:{delay:0,minLength:1}});var b=m.find("#send_to_row").find("ul.tagit");function k(){var q=m.find("#email_subject").val();var o=m.find("#send_to_address").val();var p=c.filter(":checked").val();if(p=="none"){d.filter("[value=mailing_list]").prop("disabled",true);d.filter("[value=other]").prop("checked",true)}else{d.filter("[value=mailing_list]").prop("disabled",false)}var r=d.filter(":checked").val();if(r=="other"){b.removeClass("disabled")}else{b.addClass("disabled")}h={subject:q,mailing_list:p,send_to_option:r,send_to_address:o};f(h)}k();m.find("input").change(k);b.click(function(){d.filter("[value=other]").prop("checked",true);k()})})();