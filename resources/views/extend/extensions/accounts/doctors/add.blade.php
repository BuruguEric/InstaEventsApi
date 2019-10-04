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
					            	<label>Doctor Name <small>(Your Full Name)</small> <i class="fa fa-asterisk"></i></label>
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
					            	<label>Doctor Email <i class="fa fa-asterisk"></i></label>
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
					            	<label>Doctor Phone Number <small>(07xxxxxxxx)</small> <i class="fa fa-asterisk"></i></label>
					                <input type="text" class="form-control" name="user_mobile" id="" autocomplete="off" value="{{ old('user_mobile') }}">
					            </div>
	                            @if ($errors->has('user_mobile'))
	                                <span class="error">{{ $errors->first('user_mobile') }}</span>
	                            @endif
					        </div>
					    </div>
					</div>
					<div class="row">
					    <div class="col-md-4 col-sm-12">
					        <div class="form-group">
					            <div class="fg-line">
					            	<label>Doctor Password <i class="fa fa-asterisk"></i></label>
					                <input type="password" class="form-control" name="user_password" id="" autocomplete="new-password"
					                value="{{ old('user_password') }}">
					            </div>
	                            @if ($errors->has('user_password'))
	                                <span class="error">{{ $errors->first('user_password') }}</span>
	                            @endif
					        </div>
					    </div>


					    <div class="col-md-4 col-sm-12">
					        <div class="form-group">
					            <div class="fg-line">
					            	<label>Doctor Licence No<i class="fa fa-asterisk"></i></label>
					                <input type="text" class="form-control" name="doctor_licence" id="" value="{{ old('doctor_licence') }}">
					            </div>
	                            @if ($errors->has('doctor_licence'))
	                                <span class="error">{{ $errors->first('doctor_licence') }}</span>
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
