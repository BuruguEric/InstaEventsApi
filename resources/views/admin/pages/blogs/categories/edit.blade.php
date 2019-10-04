<section id="content">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2><?= ucwords($ModuleName); ?> <small>Edit / Update <?= strtolower($ModuleName); ?></small></h2>
            </div>
			

            <div class="card-body card-padding">
                <!-- Notification -->
                <?= (!is_null($notify) && !empty($notify))? $notify : ''; ?>
				<?= form_open($form_edit, '', ' autocomplete="off" '); ?>
					<div class="row">
						<input type="hidden" name="id" value="<?= $resultList[0]->id;?>">
                        <input type="hidden" name="inheritance_type" value="category">
					    <div class="col-md-4 col-sm-12">
				            <div class="fg-line">
				            	<label>Select Parent <small>(Parent Category)</small> <i class="fa fa-asterisk"></i></label>
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
				            <span class="error"><?= form_error('inheritance_parent') ?></span>
					    </div>
					    <div class="col-md-8 col-sm-12">
					        <div class="form-group">
					            <div class="fg-line">
					            	<label>Category Title/Name <i class="fa fa-asterisk"></i></label>
					                <input type="text" class="form-control" name="inheritance_title" id="" autocomplete="off" value="<?= $resultList[0]->title; ?>">
					            </div>
					            <span class="error"><?= form_error('inheritance_title') ?></span>
					        </div>
					    </div>

					    <div class="col-md-12 col-sm-12">
			                <div class="form-group">
			                    <button type="submit" class="btn btn-primary btn-lg waves-effect flt-right brd-20">Update</button>
			                </div>
					    </div>
					</div>
				<?= form_close(); ?>
			</div>
		</div>
	</div>
</section>
