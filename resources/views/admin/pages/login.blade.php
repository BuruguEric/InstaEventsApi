

        <div class="login" data-lbg="teal">
            <!-- Login -->
            <div class="l-block toggled" id="l-login">
                <div class="lb-header palette-Teal bg">
                    <i class="zmdi zmdi-account-circle"></i>
                    {{'Hi there! Please Sign in'}}
                </div>

                <div class="lb-body">
                    <!-- Notification -->
                    
                    <?= (!is_null($notify) && !empty($notify))? $notify : ''; ?>
                    <form autocomplete="off" id="" role="form" method="post" action="{{ url($form_new) }}">@csrf
	                    <div class="form-group fg-float">
	                        <div class="fg-line">
	                            <input type="text" class="input-sm form-control fg-input" autocomplete="new-username" name="user_logname" 
	                            value="{{ old('user_logname') }}">
	                            <label class="fg-label">Logname</label>
	                        </div>
                            @if ($errors->has('user_logname'))
                                <span class="error">{{ $errors->first('user_logname') }}</span>
                            @endif
	                    </div>

	                    <div class="form-group fg-float">
	                        <div class="fg-line">
	                            <input type="password" class="input-sm form-control fg-input" autocomplete="new-password" name="user_password"
	                            value="{{ old('user_password') }}">
	                            <label class="fg-label">Password</label>
	                        </div>
                            @if ($errors->has('user_password'))
                                <span class="error">{{ $errors->first('user_password') }}</span>
                            @endif
	                    </div>
	                    <button type="submit" class="btn palette-Teal bg">Sign in</button>
					</form>
                    <div class="m-t-20">
                        <a data-block="#l-forget-password" data-bg="purple" href="#" class="palette-Purple text">Forgot password?</a>
                        <a class="palette-Teal text d-block m-b-5" href="{{ url('/') }}">Get me back to home page ...</a>
                    </div>
                </div>
            </div>

            <!-- Forgot Password -->
            <div class="l-block" id="l-forget-password">
                <div class="lb-header palette-Purple bg">
                    <i class="zmdi zmdi-account-circle"></i>
                    Forgot Password?
                </div>

                <div class="lb-body">
                    <p class="m-b-30">Lorem ipsum dolor fringilla enim feugiat commodo sed ac lacus.</p>

                    <div class="form-group fg-float">
                        <div class="fg-line">
                            <input type="text" class="input-sm form-control fg-input">
                            <label class="fg-label">Email Address</label>
                        </div>
                    </div>

                    <button class="btn palette-Purple bg">Create Account</button>

                    <div class="m-t-30">
                        <a data-block="#l-login" data-bg="teal" class="palette-Purple text" href="#">Already have an account?</a>
                        <a class="palette-Teal text d-block m-b-5" href="{{ url('/') }}">Get me back to home page ...</a>
                    </div>
                </div>
            </div>
        </div>
