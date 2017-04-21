/**
 * plugin.js
 *Add file upload selector
 By. CSKAZA
/*global tinymce:true */

tinymce.PluginManager.add('cszfile', function(editor) {

	tinymce.activeEditor.settings.file_browser_callback = cszFileBrowser;
        
        function cszFileBrowser (field_name, url, type, win) {

            //alert("Field_Name: " + field_name + " ,nURL: " + url + " ,nType: " + type + " ,nWin: " + win); // debug/testing

            /* If you work with sessions in PHP and your client doesn't accept cookies you might need to carry
               the session name and session ID in the request string (can look like this: "?PHPSESSID=88p0n70s9dsknra96qhuk6etm5").
               These lines of code extract the necessary parameters and add them back to the filebrowser URL again. */

            var width = window.innerWidth-30;
            var height = window.innerHeight-60;
            if(width > 1800) width=800;
            if(height > 1200) height=600;
            if(width>600){
		var width_reduce = (width - 20) % 138;
		width = width - width_reduce + 10;
            }
            var cmsURL = editor.settings.external_filemanager_path+'tinyMCEfile';  // script URL - use an absolute path!
            if (cmsURL.indexOf("?") < 0) {
              cmsURL = cmsURL + "?type=" + type;
            }
            else {
              cmsURL = cmsURL + "&type=" + type;
            }
            cmsURL += '&input=' + field_name + '&value=' + win.document.getElementById(field_name).value;

            tinyMCE.activeEditor.windowManager.open({
                file : cmsURL,
                title : 'CSZ File Browser',
                width: width, // Your dimensions may differ - toy around with them!
                height: height,
                resizable : "yes",
                inline : "yes",  // This parameter only has an effect if you use the inlinepopups plugin!
                close_previous : "no"
            }, {
                window : win,
                input : field_name
            });
            return false;
        }
});
