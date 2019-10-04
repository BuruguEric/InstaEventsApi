<section id="content">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2><?= ucwords($Module); ?> <small>Edit / Update <?= strtolower($Module); ?></small></h2>
            </div>


            <div class="card-body card-padding">
                <!-- Notification -->
                <?= (!is_null($notify) && !empty($notify))? $notify : ''; ?>
                <form autocomplete="off" id="" role="form" method="post" action="{{ url($form_edit) }}">@csrf
					<div class="row">
						<input type="hidden" name="id" value="<?= $resultList[0]->id;?>">
					    <div class="col-md-4 col-sm-12">
					        <div class="form-group">
					            <div class="fg-line">
					            	<label>Title <small>(Unique Name Identifier)</small> <i class="fa fa-asterisk"></i></label>
                                    <input type="text" class="form-control" id="" autocomplete="off" disabled="" value="<?= stripcslashes($resultList[0]->title);?>">
					            </div>
					        </div>
					    </div>
						<?php $required = json_decode($resultList[0]->required, True); ?>
						<?php $filters = json_decode($resultList[0]->filters, True); ?>

					    <div class="col-md-4 col-sm-12">
					        <div class="form-group">
					            <div class="fg-line">
					            	<label>Set Default Filters <small>(Fields used when filtering)</small></label>
									<?php if ($resultList[0]->default == 'yes'): ?>
									<?php $filter_data = array_values($filters) ?>
                                    <select class="selectpicker" name="customfield_filters[]" multiple>
                                    	<?php foreach ($required as $key => $value): ?>
                                    		<?php if (in_array(strtolower(str_replace("-", "_",str_replace(" ", "_",trim($value)))), $filter_data)): ?>
                                    			<?php $filter_selected = 'selected=""'; ?>
                                    		<?php else: ?>
                                    			<?php $filter_selected = ''; ?>
                                    		<?php endif ?>
                                        <option <?= $filter_selected; ?> 
                                        value="<?= strtolower(str_replace("-", "_",str_replace(" ", "_",trim($value)))); ?>"><?= $value ?>
                                        </option>
                                    	<?php endforeach ?>
                                    </select>
			                        <?php else: ?>
                                    <select class="selectpicker" name="customfield_filters[]" multiple>
                                    	<?php foreach ($required as $key => $value): ?>
                                        <option 
                                        value="<?= strtolower(str_replace("-", "_",str_replace(" ", "_",trim($value)))); ?>"><?= $value ?>
                                        </option>
                                    	<?php endforeach ?>
                                    </select>
									<?php endif ?>
					            </div>
	                            @if ($errors->has('customfield_filters'))
	                                <span class="error">{{ $errors->first('customfield_filters') }}</span>
	                            @endif
					        </div>
					    </div>

						<?php foreach ($required as $key => $value): ?>
							<?php if (!is_null($value) && !empty($value)): ?>
							    <div class="col-md-4 col-sm-12 required" id="required">
							        <div class="form-group">
							            <div class="fg-line">
					            			<label>Required <small>(Required Fields)</small><i class="fa fa-asterisk"></i></label>
							                <input type="text" class="form-control" name="customfield_required[]" id="" autocomplete="off" 
							                value="<?= stripcslashes($value); ?>">
							            </div>
			                            @if ($errors->has('customfield_required'))
			                                <span class="error">{{ $errors->first('customfield_required') }}</span>
			                            @endif
							        </div>
							    </div>
							<?php endif ?>
						<?php endforeach ?>

						<?php $optional = json_decode($resultList[0]->optional, True); ?>
						<?php if (!empty($optional) || is_null($optional)): ?>
						<?php foreach ($optional as $key => $value): ?>
							<?php if (!is_null($value) && !empty($value)): ?>
							    <div class="col-md-4 col-sm-12 optional" id="optional">
							        <div class="form-group">
							            <div class="fg-line">
					            			<label>Optional <small>(Optional Fields)</small></label>
							                <input type="text" class="form-control" name="customfield_optional[]" id="" autocomplete="off" 
							                value="<?= stripcslashes($value); ?>">
							            </div>
			                            @if ($errors->has('customfield_optional'))
			                                <span class="error">{{ $errors->first('customfield_optional') }}</span>
			                            @endif
							        </div>
							    </div>
							<?php endif ?>
						<?php endforeach ?>
						<?php else: ?>
					    <div class="col-md-4 col-sm-12 optional" id="optional">
					        <div class="form-group">
					            <div class="fg-line">
					            	<label>Optional <small>(Optional Fields)</small></label>
					                <input type="text" class="form-control" name="customfield_optional[]" id="" autocomplete="off" value="<?= set_value('customfield_optional'); ?>">
					            </div>
	                            @if ($errors->has('customfield_optional'))
	                                <span class="error">{{ $errors->first('customfield_optional') }}</span>
	                            @endif
					        </div>
					    </div>
						<?php endif ?>
					</div>
					<div class="row">
					    <div class="col-md-4 col-sm-12" style="">
					        <div class="form-group">
			                	<button type="button" onclick="duplicateData('required')" class="btn btn-success btn-xs waves-effect">
			                		Add Required Fields +
			                	</button>

			                	<button type="button" onclick="removeData('required')" class="btn btn-danger btn-xs waves-effect">
			                		Remove Required Fields -
			                	</button>
					        </div>
					    </div>
					    <div class="col-md-4 col-sm-12" style="">
					        <div class="form-group">
			                	<button type="button" onclick="duplicateData('optional')" class="btn btn-success btn-xs waves-effect">
			                		Add Optional Fields +
			                	</button>
			                	<button type="button" onclick="removeData('optional')" class="btn btn-danger btn-xs waves-effect">
			                		Remove Optional Fields -
			                	</button>
					        </div>
					    </div>
					    <div class="col-md-4 col-sm-12">
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
