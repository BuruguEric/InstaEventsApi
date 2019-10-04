<section id="content">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2><?= ucwords($ModuleName); ?> <small>Create / Add new <?= strtolower($ModuleName); ?></small></h2>
            </div>
            

            <div class="card-body card-padding">
                <!-- Notification -->
                <?= (!is_null($notify) && !empty($notify))? $notify : ''; ?>
                <form autocomplete="off" id="" role="form" method="post" action="{{ url($form_save) }}">@csrf
					<div class="row">
					    <div class="col-md-4 col-sm-12">
					        <div class="fg-line">
					            <label>Inheritance Type <small>(Select One)</small> <i class="fa fa-asterisk"></i></label>
	                            <select name="inheritance_type" class="chosen" data-placeholder="Choose Type...">	                            	
	                            	<?php for ($i = 0; $i < count($inheritance_type); $i++): ?>
	                            		<?php if ($i == 0): ?>
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
                                	<option value="0" selected="">Self</option>
	                            	<?php for ($i = 0; $i < count($inheritance_parent); $i++): ?>
	                                <option value="<?= strtolower($inheritance_parent[$i]->inheritance_id) ?>"><?= ucwords($inheritance_parent[$i]->inheritance_title) ?></option>
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
					                <input type="text" class="form-control" name="inheritance_title" id="" autocomplete="off" value="{{ old('inheritance_title') }}">
					            </div>
	                            @if ($errors->has('inheritance_title'))
	                                <span class="error">{{ $errors->first('inheritance_title') }}</span>
	                            @endif
					        </div>
					    </div>

					    <div class="col-md-12 col-sm-12">
			                <div class="form-group">
			                    <button type="submit" class="btn btn-primary btn-lg waves-effect flt-right brd-20">Save</button>
			                </div>
					    </div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>
