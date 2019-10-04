<section id="content">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2><?= ucwords($ModuleName); ?> <small>Edit / Update <?= strtolower($ModuleName); ?></small></h2>
            </div>
			

            <div class="card-body card-padding">
                <!-- Notification -->
                <?= (!is_null($notify) && !empty($notify))? $notify : ''; ?>
                <form autocomplete="off" id="" role="form" method="post" action="{{ url($form_edit) }}">@csrf
					<div class="row">

						<input type="hidden" name="id" value="<?= $resultList[0]->id;?>">
					    <div class="col-md-4 col-sm-12">
				            <div class="fg-line">
				            	<label>Select Modules <small>(Modules allowed to access)</small> <i class="fa fa-asterisk"></i></label>
	                            <select name="level_module[]" multiple="" class="selectpicker" data-placeholder="Choose Modules...">
	                            	<?php $moduleselected = explode(",",trim($resultList[0]->module)); ?>

                                    <?php for ($i = 0; $i < count($modulelist); $i++): ?>
                                    	<?php if (in_array($modulelist[$i],$moduleselected)): ?>
                                    	<option selected="" value="<?= strtolower($modulelist[$i]) ?>"><?= ucwords($modulelist[$i])?></option>
                                    	<?php else: ?>
                                    	<option value="<?= strtolower($modulelist[$i]) ?>"><?= ucwords($modulelist[$i])?></option>
                                    	<?php endif ?>
                                    <?php endfor ?>
	                            </select>
				            </div>
                            @if ($errors->has('level_module'))
                                <span class="error">{{ $errors->first('level_module') }}</span>
                            @endif
					    </div>
					    <div class="col-md-8 col-sm-12">
					        <div class="form-group">
					            <div class="fg-line">
                                    <label>Access Name <small>(access / level name)</small><i class="fa fa-asterisk"></i></label>
					                <input type="text" class="form-control" disabled="" value="<?= $resultList[0]->name; ?>">
					            </div>
	                            @if ($errors->has('level_name'))
	                                <span class="error">{{ $errors->first('level_name') }}</span>
	                            @endif
					        </div>
					    </div>

					    <div class="col-md-4 col-sm-12">
					        <div class="form-group">
					            <div class="">
					            	<label><strong>Default Value</strong></label>
		                            <label class="radio radio-inline m-r-20">
		                                <input type="radio" name="level_default" value="yes"
		                                <?= ($resultList[0]->default == 'yes')? 'checked' : ''; ?>>
		                                <i class="input-helper"></i>
		                                <?= ucwords('Yes') ?>
		                            </label>
		                            <label class="radio radio-inline m-r-20">
		                                <input type="radio" name="level_default" value="no" 
		                                <?= ($resultList[0]->default == 'no')? 'checked' : ''; ?>>
		                                <i class="input-helper"></i>
		                                <?= ucwords('No') ?>
		                            </label>
					            </div>
	                            @if ($errors->has('level_default'))
	                                <span class="error">{{ $errors->first('level_default') }}</span>
	                            @endif
					        </div>
					    </div>
					    
					    <div class="col-md-12 col-sm-12">
			                <div class="form-group">
			                    <button type="submit" class="btn btn-primary btn-lg waves-effect flt-right brd-20">Update</button>
			                </div>
					    </div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>
