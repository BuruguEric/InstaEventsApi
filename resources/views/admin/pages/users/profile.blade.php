<section id="content">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2><?= ucwords('Profile'); ?> <small> Update </small></h2>
            </div>


            <div class="card-body card-padding">
                <!-- Notification -->
                <?= (!is_null($notify) && !empty($notify))? $notify : ''; ?>
				<?= form_open($form_edit, '', ' autocomplete="off" '); ?>
					<div class="row">
						<input type="hidden" name="id" value="<?= $resultList[0]->id;?>">
					    <div class="col-md-4 col-sm-12">
					        <div class="form-group">
					            <div class="fg-line">
					            	<label>User Name <small>(Your Full Name)</small> <i class="fa fa-asterisk"></i></label>
					                <input type="text" class="form-control" name="user_name" id="" autocomplete="off" value="<?= stripcslashes($resultList[0]->name); ?>">
					            </div>
					            <span class="error"><?= form_error('user_name') ?></span>
					        </div>
					    </div>

					    <div class="col-md-4 col-sm-12">
					        <div class="form-group">
					            <div class="fg-line">
					            	<label>User Email <i class="fa fa-asterisk"></i></label>
					                <input type="email" class="form-control" name="user_email" id="" autocomplete="off" value="<?= $resultList[0]->email; ?>">
					            </div>
					            <span class="error"><?= form_error('user_email') ?></span>
					        </div>
					    </div>

					    <div class="col-md-4 col-sm-12">
					        <div class="form-group">
					            <div class="fg-line">
					            	<label>User Level <i class="fa fa-asterisk"></i></label>
					                <input type="text" class="form-control" value="<?= ucwords($resultList[0]->level); ?>" disabled="">
					            </div>
					        </div>
					    </div>

					    <div class="col-md-4 col-sm-12">
					        <div class="form-group">
					            <div class="fg-line">
					            	<label>User Logname <small>(login/user name)</small> <i class="fa fa-asterisk"></i></label>
					                <input type="text" class="form-control" name="user_logname" autocomplete="off" value="<?= stripcslashes($resultList[0]->logname); ?>">
					            </div>
					            <span class="error"><?= form_error('user_logname') ?></span>
					        </div>
					    </div>

					    <div class="col-md-4 col-sm-12">
					        <div class="form-group">
					            <div class="fg-line">
					            	<label>New Password </label>
					                <input type="text" class="form-control" name="user_password" id="" autocomplete="off" value="">
					            </div>
					            <span class="error"><?= form_error('user_password') ?></span>
					        </div>
					    </div>

					    <div class="col-md-4 col-sm-12">
					        <div class="form-group">
					            <div class="fg-line">
					            	<label>Confirm Changes <small>Put your current password</small></label>
					                <input type="password" class="form-control" name="conf_password" id="" autocomplete="off"  value="">
					            </div>
					            <span class="error"><?= form_error('conf_password') ?></span>
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
