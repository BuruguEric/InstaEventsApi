<section id="content">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2><?= ucwords('General Settings'); ?> <small>Default Current Link customization</small></h2>
            </div>


            <div class="card-body card-padding">
                <!-- Notification -->
                <?= (!is_null($notify) && !empty($notify))? $notify : ''; ?>
                <form autocomplete="off" id="" role="form" method="post" action="{{ url($form_link) }}">@csrf
					<div class="row">

						<div class="col-md-12 col-sm-12">
							<p>Set up default link format. Core CMS uses Post ID number as a default URL format, URL change depends mostly with the use of the platform. Use Post ID if you are developing a system which will enable you to get the matched item ID.</p>
						</div>

						<?php $value = $resultList[0]->setting_value; ?>
					    
					    <div class="col-md-12 col-sm-12">
					        <div class="form-group">
					            <div class="radio m-b-15">
					            	<label>
                                    	<input type="radio" name="current_url" value="id" <?= ($value == 'id')? 'checked' : ''; ?>>
	                                    <i class="input-helper"></i>
	                                    <div class="col-md-4 col-sm-12">
	                                    	<p>POST ID</p>
	                                    </div>
	                                    <div class="col-md-8 col-sm-12">
	                                    	<p>Use POST_ID <span style="color: red">{{url('/1')}}</span></p>
	                                    </div>
					            	</label>
					            </div>
					        </div>
					    </div>

					    <div class="col-md-12 col-sm-12">
					        <div class="form-group">
					            <div class="radio m-b-15">
					            	<label>
                                    	<input type="radio" name="current_url" value="title" <?= ($value == 'title')? 'checked' : ''; ?>>
	                                    <i class="input-helper"></i>
	                                    <div class="col-md-4 col-sm-12">
	                                    	<p>POST TITLE</p>
	                                    </div>
	                                    <div class="col-md-8 col-sm-12">
	                                    	<p>Use POST_TITLE <span style="color: red">{{url('/post-title')}}</span></p>
	                                    </div>
					            	</label>
					            </div>
					        </div>
					    </div>

					    <div class="col-md-12 col-sm-12">
					        <div class="form-group">
					            <div class="radio m-b-15">
					            	<label>
                                    	<input type="radio" name="current_url" value="get" <?= ($value == 'get')? 'checked' : ''; ?>>
	                                    <i class="input-helper"></i>
	                                    <div class="col-md-4 col-sm-12">
	                                    	<p>POST GET</p>
	                                    </div>
	                                    <div class="col-md-8 col-sm-12">
	                                    	<p>Use Request <span style="color: red">{{url('/?c=category&p=post-title')}}</span></p>
											<p><small>Kindly note this option works well with blog...</small></p>
	                                    </div>
					            	</label>
					            </div>
					        </div>
					    </div>
						
						<div class="col-md-12 col-sm-12">
							<div class="form-group">
								<div class="fg-line">
		                            @if ($errors->has('current_url'))
		                                <span class="error">{{ $errors->first('current_url') }}</span>
		                            @endif
								</div>
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
