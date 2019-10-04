/**
 * Media Manager Switch
 */

function mediaManager(argument) {
	
	if (argument == 'upload') {

		$('#upload-new').show();
		$('#media-new').hide();
	}
	else if (argument == 'media-new') {

		$('#media-new').show();
		$('#upload-new').hide();
	}
	else{

		$('#upload-new').show();
		$('#media-new').hide();
	}
}


$(window).load(function() {

	$('#media-new').hide();
});