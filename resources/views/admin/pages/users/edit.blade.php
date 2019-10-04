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
						<input type="hidden" name="id" value="<?= $resultList[0]->id; ?>">
					    <div class="col-md-4 col-sm-12">
					        <div class="form-group">
					            <div class="fg-line">
					            	<label>User Name <small>(Your Full Name)</small> <i class="fa fa-asterisk"></i></label>
					                <input type="text" class="form-control" name="user_name" id="" autocomplete="off" value="<?= $resultList[0]->name; ?>">
					            </div>
	                            @if ($errors->has('user_name'))
	                                <span class="error">{{ $errors->first('user_name') }}</span>
	                            @endif
					        </div>
					    </div>

					    <div class="col-md-4 col-sm-12">
					        <div class="form-group">
					            <div class="fg-line">
					            	<label>User Email <i class="fa fa-asterisk"></i></label>
					                <input type="email" class="form-control" name="user_email" id="" autocomplete="off" value="<?= $resultList[0]->email; ?>">
					            </div>
	                            @if ($errors->has('user_email'))
	                                <span class="error">{{ $errors->first('user_email') }}</span>
	                            @endif
					        </div>
					    </div>

					    <div class="col-md-4 col-sm-12">
					        <div class="form-group">
					            <div class="fg-line">
					            	<label>User Level <i class="fa fa-asterisk"></i></label>
	                                <div class="select">
	                                    <select class="form-control chosen" name="user_level" autocomplete="off">
	                                    	<option selected="" value="<?= strtolower($resultList[0]->level); ?>"><?= ucwords($resultList[0]->level); ?></option>
	                                    	<?php foreach ($level as $row): ?>
	                                    		<?php if (strtolower($resultList[0]->level) != strtolower($row->level_name)): ?>
	                                        	<option value="<?= strtolower($row->level_name); ?>"><?= ucwords($row->level_name); ?></option>
	                                    		<?php endif ?>
	                                    	<?php endforeach ?>
	                                    </select>
	                                </div>
					            </div>
	                            @if ($errors->has('user_level'))
	                                <span class="error">{{ $errors->first('user_level') }}</span>
	                            @endif
					        </div>
					    </div>
					</div>
					<div class="row">
					    <div class="col-md-6 col-sm-12">
					        <div class="form-group">
					            <div class="fg-line">
					            	<label>User Logname <small>(login/user name)</small> <i class="fa fa-asterisk"></i></label>
					                <input type="text" class="form-control" name="user_logname" autocomplete="off" value="<?= $resultList[0]->logname; ?>">
					            </div>
	                            @if ($errors->has('user_logname'))
	                                <span class="error">{{ $errors->first('user_logname') }}</span>
	                            @endif
					        </div>
					    </div>

					    <div class="col-md-6 col-sm-12">
					        <div class="form-group">
					            <div class="fg-line">
					            	<label>New Password </label>
					                <input type="text" class="form-control" name="user_password" autocomplete="off" value="">
					            </div>
	                            @if ($errors->has('user_password'))
	                                <span class="error">{{ $errors->first('user_password') }}</span>
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
