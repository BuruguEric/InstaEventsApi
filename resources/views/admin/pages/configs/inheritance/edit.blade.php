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
					            <label>Inheritance Type <small>(Select One)</small> <i class="fa fa-asterisk"></i></label>
	                            <select name="inheritance_type" class="chosen" data-placeholder="Choose Type...">
	                            	<?php for ($i = 0; $i < count($inheritance_type); $i++): ?>
	                            		<?php if (strtolower($inheritance_type[$i]) == $resultList[0]->type): ?>
			                                <option value="<?= strtolower(str_replace(" ", "_",$inheritance_type[$i])) ?>" selected=""><?= ucwords(str_replace("_", " ",$inheritance_type[$i])) ?></option>
	                            		<?php else: ?>
			                                <option value="<?= strtolower(str_replace(" ", "_",$inheritance_type[$i])) ?>"><?= ucwords(str_replace("_", " ",$inheritance_type[$i])) ?></option>
	                            		<?php endif ?>
	                            	<?php endfor ?>
	                            </select>
                        	</div>
                            @if ($errors->has('inheritance_type'))
                                <span class="error">{{ $errors->first('inheritance_type') }}</span>
                            @endif
                        </div>
					    <div class="col-md-4 col-sm-12">
				            <div class="fg-line">
				            	<label>Inheritance Parent <small>(Parent Name)</small> <i class="fa fa-asterisk"></i></label>
	                            <select name="inheritance_parent" class="chosen" data-placeholder="Choose Parent...">
	                            	<?php $default = 0; ?>
	                            	<?php for ($i = 0; $i < count($inheritance_parent); $i++): ?>
	                            		<?php if (strtolower($inheritance_parent[$i]->inheritance_id) == $resultList[0]->parent): ?>
			                                <option value="<?= strtolower($inheritance_parent[$i]->inheritance_id) ?>" selected=""><?= ucwords($inheritance_parent[$i]->inheritance_title) ?></option>
			                            <?php elseif($resultList[0]->parent == $default): ?>
                                			<option value="0" selected="">Self</option>
                                			<?php $default = 1; ?>
	                            		<?php else: ?>
			                                <option value="<?= strtolower($inheritance_parent[$i]->inheritance_id) ?>"><?= ucwords($inheritance_parent[$i]->inheritance_title) ?></option>
	                            		<?php endif ?>
	                            	<?php endfor ?>
	                            </select>
				            </div>
                            @if ($errors->has('inheritance_parent'))
                                <span class="error">{{ $errors->first('inheritance_parent') }}</span>
                            @endif
					    </div>
					    <div class="col-md-4 col-sm-12">
					        <div class="form-group">
					            <div class="fg-line">
					            	<label>Title <i class="fa fa-asterisk"></i></label>
					                <input type="text" class="form-control" name="inheritance_title" id="" autocomplete="off" value="<?= $resultList[0]->title; ?>">
					            </div>
	                            @if ($errors->has('inheritance_title'))
	                                <span class="error">{{ $errors->first('inheritance_title') }}</span>
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
