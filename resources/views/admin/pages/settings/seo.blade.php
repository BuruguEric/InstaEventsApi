<section id="content">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2><?= ucwords('General Settings'); ?> <small>Site default Search Engine Optinization Global Configurations  </small></h2>
            </div>


            <div class="card-body card-padding">
                <!-- Notification -->
                <?= (!is_null($notify) && !empty($notify))? $notify : ''; ?>
                <form autocomplete="off" id="" role="form" method="post" action="{{ url($form_seo) }}">@csrf
					<div class="row">

						<?php foreach ($resultList as $row): ?>
							<?php if ($row->setting_title == 'seo_visibility'): ?>
						    <div class="col-md-4 col-sm-12">
						        <div class="form-group">
						            <div class="">
						            	<p><strong><?= ucwords(str_replace("_", " ",$row->setting_title));?></strong></p>
			                            <label class="radio radio-inline m-r-20">
			                                <input type="radio" name="seo_visibility" value="noindex, nofollow"
			                                <?= ($row->setting_value == 'noindex, nofollow')? 'checked' : ''; ?>>
			                                <i class="input-helper"></i>
			                                <?= ucwords('Hide my site') ?>
			                            </label>
			                            <label class="radio radio-inline m-r-20">
			                                <input type="radio" name="seo_visibility" value="index, follow" 
			                                <?= ($row->setting_value == 'index, follow')? 'checked' : ''; ?>>
			                                <i class="input-helper"></i>
			                                <?= ucwords('Show my site') ?>
			                            </label>
						            </div>
		                            @if ($errors->has($row->setting_title))
		                                <span class="error">{{ $errors->first($row->setting_title) }}</span>
		                            @endif
						        </div>
						    </div>
	                        <?php elseif ($row->setting_title == 'seo_global'): ?>
						    <div class="col-md-4 col-sm-12">
						        <div class="form-group">
						            <div class="">
						            	<p><strong><?= ucwords(str_replace("_", " ",$row->setting_title));?></strong></p>
			                            <label class="radio radio-inline m-r-20">
			                                <input type="radio" name="seo_global" value="any"
			                                <?= ($row->setting_value == 'any')? 'checked' : ''; ?>>
			                                <i class="input-helper"></i>
			                                <?= ucwords('to all Pages') ?>
			                            </label>
			                            <label class="radio radio-inline m-r-20">
			                                <input type="radio" name="seo_global" value="home" 
			                                <?= ($row->setting_value == 'home')? 'checked' : ''; ?>>
			                                <i class="input-helper"></i>
			                                <?= ucwords('Only Home Page') ?>
			                            </label>
						            </div>
		                            @if ($errors->has($row->setting_title))
		                                <span class="error">{{ $errors->first($row->setting_title) }}</span>
		                            @endif
						        </div>
						    </div>
	                        <?php else: ?>
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
