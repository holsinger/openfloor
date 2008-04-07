function showBox(id){
    element = $(id);
	if (!element) {
		
		Lightview.show({
		  href: site_url+'/information/viewAjax/'+id,
		  rel: 'ajax',
		  options: {
		    autosize: true,
		    topclose: true,
		    ajax: {
		      method: 'post',
		      onSuccess: function(transport){
		      var response = transport.responseText;
				/*alert(response);*/
		      }
			}
		  }
		});	
	} else {
	Lightview.show({href:'#'+id,options: {autosize: true,topclose: false}});
	Field.focus('username');
	}
}

function showUrl(url){
		Lightview.show({
		  href: site_url+url,
		  rel: 'ajax',
		  options: {
		    autosize: true,
		    topclose: false,
		    ajax: {
		      method: 'post',
		      onSuccess: function(transport){
		      var response = transport.responseText;
				/*alert(response);*/
		      }
			}
		  }
		});	
}