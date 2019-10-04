<section id="content">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2><?= ucwords('General Settings'); ?> <small>Module List | Add/Remove </small></h2>
            </div>


            <div class="card-body card-padding">
                <!-- Notification -->
                <?= (!is_null($notify) && !empty($notify))? $notify : ''; ?>
                <form autocomplete="off" id="" role="form" method="post" action="{{ url($form_module) }}">@csrf
					<div class="row">
						<?php foreach ($resultList as $row): ?>
							<?php if ($row->setting_title == 'module_list'): ?>
						    <div class="col-md-12 col-sm-12">
						        <div class="form-group">
						            <div class="fg-line">
						            	<label><?= ucwords(str_replace("_", " ",$row->setting_title));?></label>
				                        <textarea class="form-control auto-size" name="<?= $row->setting_title;?>" autocomplete="off"><?= $row->setting_value; ?></textarea>
						            </div>
		                            @if ($errors->has($row->setting_title))
		                                <span class="error">{{ $errors->first($row->setting_title) }}</span>
		                            @endif
						        </div>
						    </div>
							<?php endif ?>
						<?php endforeach ?>
					</div>
					<div class="row">
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
