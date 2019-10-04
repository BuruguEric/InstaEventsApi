<section id="content">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2><?= ucwords('General Settings'); ?> <small>Site customization</small></h2>
            </div>


            <div class="card-body card-padding">
                <!-- Notification -->
                <?= (!is_null($notify) && !empty($notify))? $notify : ''; ?>
                <form autocomplete="off" id="" role="form" method="post" action="{{ url($form_general) }}">@csrf
					<div class="row">


						<?php foreach ($resultList as $row): ?>
							<?php if ($row->setting_title == 'site_status'): ?>
						    <div class="col-md-4 col-sm-12">
						        <div class="form-group">
						            <div class="fg-line">
						            	<label><?= ucwords(str_replace("_", " ",$row->setting_title));?> <i class="fa fa-asterisk"></i></label>
				                        <select class="selectpicker p-l-10" name="<?= $row->setting_title;?>">
				                            <?php if (trim($row->setting_value) == trim('online')): ?>
				                            <option value="online" selected=""><?= ucwords('online') ?></option>
				                            <?php else: ?>
				                            <option value="offline" selected=""><?= ucwords('offline') ?></option>
				                            <?php endif ?>
				                            <option value="<?= (trim($row->setting_value)=='online')? 'offline':'online'; ?>">
				                            	<?= ucwords((trim($row->setting_value)=='online')? 'offline':'online') ?>
				                            </option>
				                        </select>
						            </div>
		                            @if ($errors->has($row->setting_title))
		                                <span class="error">{{ $errors->first($row->setting_title) }}</span>
		                            @endif
						        </div>
						    </div>
	                        <?php elseif ($row->setting_title == 'offline_message'): ?>
						    <div class="col-md-12 col-sm-12">
						        <div class="form-group">
						            <div class="fg-line">
						            	<label><?= ucwords(str_replace("_", " ",$row->setting_title));?> <i class="fa fa-asterisk"></i></label>
				                        <textarea class="form-control" name="<?= $row->setting_title;?>" autocomplete="off"><?= $row->setting_value; ?></textarea>
						            </div>
		                            @if ($errors->has($row->setting_title))
		                                <span class="error">{{ $errors->first($row->setting_title) }}</span>
		                            @endif
						        </div>
						    </div>
	                        <?php else: ?>
						    <div class="col-md-4 col-sm-12">
						        <div class="form-group">
						            <div class="fg-line">
						            	<label><?= ucwords(str_replace("_", " ",$row->setting_title));?> <i class="fa fa-asterisk"></i></label>
						                <input type="text" class="form-control" name="<?= $row->setting_title;?>" id="" autocomplete="off" 
						                value="<?= $row->setting_value; ?>">
						            </div>
		                            @if ($errors->has($row->setting_title))
		                                <span class="error">{{ $errors->first($row->setting_title) }}</span>
		                            @endif
						        </div>
						    </div>
							<?php endif ?>
						<?php endforeach ?>
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
