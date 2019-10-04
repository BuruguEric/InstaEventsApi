<section id="content">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2><?= ucwords($ModuleName); ?> <small>Create / Add new <?= strtolower($ModuleName); ?></small></h2>
            </div>

	
            <div class="card-body card-padding">
                <!-- Notification -->
                <?= (!is_null($notify) && !empty($notify))? $notify : ''; ?>
		        <form class="" role="form" action="#" method="post" accept-charset="utf-8" id="core" enctype="multipart/form-data" autocomplete="off">
		            <script>
		                function submitForm(action){
		                    document.getElementById('core').action = action;
		                    document.getElementById('core').submit();
		                }
		            </script>
		            <?php $form_save_link = url($form_save);?>

					<div class="row">
					    <div class="col-md-4 col-sm-12">
					        <div class="form-group">
					            <div class="fg-line">
					            	<label>Upload Extension File <small>(allowed zip format)</small> <i class="fa fa-asterisk"></i></label>
					            </div>
					        </div>
					    </div>

					    <div class="col-md-8 col-sm-12">
					        <div class="form-group">
					            <div class="fg-line">
									<div class="fileinput fileinput-new" data-provides="fileinput">
                                        <span class="btn btn-warning btn-file m-r-10">
                                            <span class="fileinput-new">Upload Zip File</span>
                                            <span class="fileinput-exists">Change</span>
                                            <input type="file" name="extension[]">
                                        </span>
                                        <span class="fileinput-filename"></span>
                                        <a href="#" class="close fileinput-exists" data-dismiss="fileinput">&times;</a>
                                    </div>
					            </div>
                                @if ($errors->has('extension'))
                                    <span class="error">{{ $errors->first('extension') }}</span>
                                @endif
					        </div>
					    </div>
					</div>

					<div class="row">
					    <div class="col-md-12 col-sm-12">
			                <div class="form-group">
			                    <button class="btn btn-primary btn-lg waves-effect flt-right brd-20" 
			                    	onclick="submitForm('<?= $form_save_link ;?>')" type="submit">
			                    	Save
			                	</button>
			                </div>
					    </div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>
