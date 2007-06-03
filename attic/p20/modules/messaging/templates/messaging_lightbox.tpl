{literal}
	<script type="text/javascript">
		function lightbox_do_on_activate(content){
			// thanks to http://ajaxload.info/ for the animated gif!
			{/literal}document.getElementById('view_message').innerHTML = '<div class="loadingscreen"><center>{#PLIGG_MESSAGING_Loading2#}<br /><img src="{$messaging_path}images/ajax-loader.gif"></center></div>';{literal}
			var handlerFunc = function(t) {
			    document.getElementById('view_message').innerHTML = t.responseText;
			}	
			
			var brokenstring = content.split("~!~");
			var url = "";
			for(var i=0;i<brokenstring.length;i++){
				if(i > 0){
					var part = brokenstring[i].split("=");
					if(i > 1){url=url+"&";}
					url = url + part[0] + "=" + part[1];
				}
			}
					
			new Ajax.Request(my_pligg_base + '/user.php', {method:'post', postBody: url, onSuccess:handlerFunc});
		}

		function lightbox_do_on_activate_debug(content){
			document.getElementById('view_message').innerHTML = "loading...";
			var handlerFunc = function(t) {
			    document.getElementById('view_message').innerHTML = t.responseText;
			}	
			
			var brokenstring = content.split("~!~");
			var url = "";
			for(var i=0;i<brokenstring.length;i++){
				if(i > 0){
					var part = brokenstring[i].split("=");
					if(i > 1){url=url+"&";}
					url = url + part[0] + "=" + part[1];
				}
			}
					
			//new Ajax.Request('user.php', {method:'post', postBody: url, onSuccess:handlerFunc});
			
			window.location = 'user.php?' + url;
		}

	</script>
	
	<script type="text/javascript">
		function messaging_ajax_send(){
			var msg_subj = document.getElementById('msg_subject').value;
			var msg_body = document.getElementById('msg_body').value;
			var msg_to = document.getElementById('msg_to').value;
			var view = document.getElementById('view').value;

			{/literal}document.getElementById('view_message').innerHTML = '<div class="loadingscreen"><center>{#PLIGG_MESSAGING_Loading2#}<br /><img src="{$messaging_path}images/ajax-loader.gif"></center></div>';{literal}      
			
			var ajax = new Ajax.Updater(
         'view_message',        // DIV id (XXX: doesnt work?)
          my_pligg_base + '/user.php',        // URL
         {                // options
         method:'get',
             parameters: 'msg_subject=' + msg_subj + '&msg_body=' + msg_body + '&msg_to=' + msg_to + '&view=' + view
          })
		}
	</script>
	
{/literal}
