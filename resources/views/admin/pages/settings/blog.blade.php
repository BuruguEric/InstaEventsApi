<section id="content">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2><?= ucwords('General Settings'); ?> <small>Site page read format | Switch between blog and pages </small></h2>
            </div>


            <div class="card-body card-padding">
                <!-- Notification -->
                <?= (!is_null($notify) && !empty($notify))? $notify : ''; ?>
                <form autocomplete="off" id="" role="form" method="post" action="{{ url($form_blog) }}">@csrf

					<div class="row">
						<?php foreach ($resultList as $row): ?>
							<?php $show = array('home_display','home_post','home_page'); ?>
							<?php if (in_array($row->setting_title, $show)): ?>
					            <?php if ($row->setting_title == 'home_display'): ?>
							    <div class="col-md-4 col-sm-12">
							        <div class="form-group">
							            <div class="">
							            	<p><strong><?= ucwords(str_replace("_", " ",$row->setting_title));?></strong></p>
				                            <label class="radio radio-inline m-r-20">
				                                <input type="radio" name="home_display" value="blog"
				                                <?= ($row->setting_value == 'blog')? 'checked' : ''; ?>>
				                                <i class="input-helper"></i>
				                                <?= ucwords('Blog') ?>
				                            </label>
				                            <label class="radio radio-inline m-r-20">
				                                <input type="radio" name="home_display" value="page" 
				                                <?= ($row->setting_value == 'page')? 'checked' : ''; ?>>
				                                <i class="input-helper"></i>
				                                <?= ucwords('Static Page') ?>
				                            </label>
							            </div>
			                            @if ($errors->has($row->setting_title))
			                                <span class="error">{{ $errors->first($row->setting_title) }}</span>
			                            @endif
							        </div>
							    </div>
							    <?php elseif ($row->setting_title == 'home_post'): ?>
							    <div class="col-md-4 col-sm-12">
							        <div class="form-group">
							            <div class="">
							            	<p><strong><?= ucwords(str_replace("_", " ",$row->setting_title));?></strong></p>
			                                <div class="select">
			                                    <select class="selectpicker bs-select-hidden" data-live-search="true" name="home_post" autocomplete="off">
			                                    <?php $home_post = array('latest_post','old_post','popular_post'); ?>
			                                    <?php for ($i = 0; $i < count($home_post); $i++): ?>
				                                    <?php if (trim($row->setting_value) == $home_post[$i]): ?>
			                                    	<option selected="" value="<?= $home_post[$i] ?>"><?= ucwords(str_replace("_", " ",$home_post[$i]));?> </option>
			                                    	<?php else: ?>
			                                    	<option value="<?= $home_post[$i] ?>"><?= ucwords(str_replace("_", " ",$home_post[$i]));?> </option>
				                                    <?php endif ?>
			                                    <?php endfor ?>
			                                    </select>
			                                </div>
							            </div>
			                            @if ($errors->has($row->setting_title))
			                                <span class="error">{{ $errors->first($row->setting_title) }}</span>
			                            @endif
							        </div>
							    </div>
							    <?php elseif ($row->setting_title == 'home_page'): ?>
							    <div class="col-md-4 col-sm-12">
							        <div class="form-group">
							            <div class="">
							            	<p><strong><?= ucwords(str_replace("_", " ",$row->setting_title));?></strong></p>
			                                <div class="select">
			                                    <select class="selectpicker bs-select-hidden" data-live-search="true" name="home_page" autocomplete="off">
												<?php if (!empty($row->setting_value) && !is_null($row->setting_value)) {
													$ck_id = trim($row->setting_value);
													$page_title = $CoreCrud->selectSingleValue('pages','title',array('flg'=>1,'id'=>$ck_id));}else{ $page_title = '';}
												?>
			                                    	<option selected="" value="<?= $row->setting_value; ?>"><?= ucwords($page_title); ?></option>
			                                    	<?php foreach ($posts as $rwpost): ?>
	                                    				<?php if (trim($rwpost->page_id) != trim($row->setting_value)): ?>
			                                        	<option value="<?= strtolower($rwpost->page_id); ?>"><?= ucwords($rwpost->page_title); ?></option>
			                                    		<?php endif ?>
			                                    	<?php endforeach ?>
			                                    </select>
			                                </div>
							            </div>
			                            @if ($errors->has($row->setting_title))
			                                <span class="error">{{ $errors->first($row->setting_title) }}</span>
			                            @endif
							        </div>
							    </div>
								<?php endif ?>
							<?php endif ?>
						<?php endforeach ?>
					</div>

					<div class="row">
						<?php foreach ($resultList as $row): ?>
							<?php $show = array('post_show','post_per_page'); ?>
							<?php if (in_array($row->setting_title, $show)): ?>
					            <?php if ($row->setting_title == 'post_show'): ?>
							    <div class="col-md-4 col-sm-12">
							        <div class="form-group">
							            <div class="">
							            	<p><strong><?= ucwords(str_replace("_", " ",$row->setting_title));?></strong></p>
				                            <label class="radio radio-inline m-r-20">
				                                <input type="radio" name="post_show" value="summary"
				                                <?= ($row->setting_value == 'summary')? 'checked' : ''; ?>>
				                                <i class="input-helper"></i>
				                                <?= ucwords('summary') ?>
				                            </label>
				                            <label class="radio radio-inline m-r-20">
				                                <input type="radio" name="post_show" value="fulltext" 
				                                <?= ($row->setting_value == 'fulltext')? 'checked' : ''; ?>>
				                                <i class="input-helper"></i>
				                                <?= ucwords('fulltext') ?>
				                            </label>
							            </div>
			                            @if ($errors->has($row->setting_title))
			                                <span class="error">{{ $errors->first($row->setting_title) }}</span>
			                            @endif
							        </div>
							    </div>
							    <?php elseif ($row->setting_title == 'post_per_page'): ?>
							    <div class="col-md-4 col-sm-12">
							        <div class="form-group">
							            <div class="fg-line">
							            	<label><?= ucwords(str_replace("_", " ",$row->setting_title));?></label>
							                <input type="text" class="form-control" name="<?= $row->setting_title;?>" id="" autocomplete="off" 
							                value="<?= $row->setting_value; ?>">
							            </div>
			                            @if ($errors->has($row->setting_title))
			                                <span class="error">{{ $errors->first($row->setting_title) }}</span>
			                            @endif
							        </div>
							    </div>
								<?php endif ?>
							<?php endif ?>
						<?php endforeach ?>
					</div>

					<div class="row">
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
