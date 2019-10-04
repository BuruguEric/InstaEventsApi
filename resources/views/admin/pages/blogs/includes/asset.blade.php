<?php 

	//File Load path
	$pathModal = base_url().'application/views/'.$extRoute;

?>

<style type="text/css">
	.upload-zone {}
	.upload-area {}

	.upload-box {
		margin: 2% 38%;
		width: 60%;
	}

	.drop-upload {
		margin: 2% 27%;
	}

	.upload-btn > button {
		margin: 2% 39%;
	}

	.upload-txt {
		font-size: 11px;
		margin: 0 41%;
	} 

	#media-edit {
		border-right: 1px dashed #000;
		height: 466px;
	}

	.insert-setting {
		background-color: #909090fa;
		padding: 5%;
		height: 466px;
	}

	.insert-setting > h4, .insert-setting > p {
		color: #fff !important;
	}
</style>

<script type="text/javascript">
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
</script>