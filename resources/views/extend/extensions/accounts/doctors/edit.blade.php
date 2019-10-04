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
					            	<label>Doctor Name <small>(Your Full Name)</small> <i class="fa fa-asterisk"></i></label>
					                <input type="text" class="form-control" name="user_name" id="" autocomplete="off" value="<?= $resultList[0]->name; ?>">
					            </div>
	                            @if ($errors->has('user_name'))
	                                <span class="error">{{ $errors->first('user_name') }}</span>
	                            @endif
					        </div>
					    </div>

						<?php $detail = json_decode($resultList[0]->details, True); ?>

					    <div class="col-md-4 col-sm-12">
					        <div class="form-group">
					            <div class="fg-line">
					            	<label>Doctor Email <i class="fa fa-asterisk"></i></label>
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
					            	<label>Doctor Logname <small>(login/user name)</small> <i class="fa fa-asterisk"></i></label>
					                <input type="text" class="form-control" name="user_mobile" autocomplete="off" value="<?= $resultList[0]->logname; ?>">
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
					            	<label>New Password </label>
					                <input type="password" class="form-control" name="user_password" autocomplete="off" value="">
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
					            	<?php $doctor_licence = (array_key_exists('doctor_licence', $detail)) ? $detail['doctor_licence'] : ''; ?>
					                <input type="text" class="form-control" name="doctor_licence" id="" value="<?= $doctor_licence; ?>">
					            </div>
	                            @if ($errors->has('doctor_licence'))
	                                <span class="error">{{ $errors->first('doctor_licence') }}</span>
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
