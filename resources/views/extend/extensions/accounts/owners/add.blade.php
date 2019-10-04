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
					        <div class="form-group">
					            <div class="fg-line">
					            	<label>User Name <small>(Your Full Name)</small> <i class="fa fa-asterisk"></i></label>
					                <input type="text" class="form-control" name="user_name" id="" autocomplete="off" value="{{ old('user_name') }}">
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
					                <input type="text" class="form-control" name="user_email" id="" autocomplete="off" value="{{ old('user_email') }}">
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
	                                    	<?php foreach ($level as $row): ?>
	                                        	<option value="<?= strtolower($row->level_name); ?>"><?= ucwords($row->level_name); ?></option>
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
					                <input type="text" class="form-control" name="user_logname" id="" autocomplete="off" value="{{ old('user_logname') }}">
					            </div>
	                            @if ($errors->has('user_logname'))
	                                <span class="error">{{ $errors->first('user_logname') }}</span>
	                            @endif
					        </div>
					    </div>

					    <div class="col-md-6 col-sm-12">
					        <div class="form-group">
					            <div class="fg-line">
					            	<label>User Password <i class="fa fa-asterisk"></i></label>
					                <input type="password" class="form-control" name="user_password" id="" autocomplete="new-password"
					                value="{{ old('user_password') }}">
					            </div>
	                            @if ($errors->has('user_password'))
	                                <span class="error">{{ $errors->first('user_password') }}</span>
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
