$(document).ready(function(){
	
	setInterval(function(){
		if($('#file-upload').val().length > 0){
			$('#file-input-overlay').html($('#file-upload').val());
		}
	}, 500);
	
});