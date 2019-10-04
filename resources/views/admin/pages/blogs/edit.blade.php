<section id="content">
    <div class="container">

        <form class="" role="form" action="#" method="post" accept-charset="utf-8" id="core" enctype="multipart/form-data" autocomplete="off">
            <script>
                function submitForm(action){
                    document.getElementById('core').action = action;
                    document.getElementById('core').submit();
                }
            </script>
            <?php $form_edit_link = site_url($form_edit);?>

        <div class="card card-bg-grey">
            <div class="card-header">
                <h2><?= ucwords(str_replace("_", " ",$ModuleName)); ?> <small>Edit / Update  <?= strtolower('post'); ?></small></h2>
            </div>
			
			<input type="hidden" name="id" value="<?= $resultList[0]->id;?>">

            <div class="card-body card-header container card-padding">
                <!-- Notification -->
                <?= (!is_null($notify) && !empty($notify))? $notify : ''; ?>
                <div id="blogPOST">
                    
                    <?php if (is_null($resultList[0]->url)): ?>
                        <?php $post_url = $this->CoreCrud->postURL($resultList[0]->title) ?>
                    <?php else: ?>
                        <?php $post_url = trim($resultList[0]->url)?>
                    <?php endif ?>

                    <?php $control = json_decode($resultList[0]->control, True); ?>
                    <?php if (!empty($control['thumbnail'])): ?>
                        <?php $thumbnail = json_decode($control['thumbnail'],True); ?>               
                    <?php endif ?>

                    <div class="col-lg-9 col-md-9 col-sm-12">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group fg-float">
                                    <label class="c-black f-500 c-m-tb-2 input-label">Title</label>
                                    <div class="fg-line">
                                        <input type="text" class="form-control fg-input background-input" name="blog_title" 
                                        value="<?= stripcslashes($resultList[0]->title);?>"  autocomplete="off">
                                    </div>
                                    <span class="error"><?= form_error('blog_title') ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="input-label">Link: </label>
                                <a href="<?= site_url($post_url)?>" id="current-link" target="_blank"><?= site_url($post_url)?></a>
                                <label id="current-link-label" class="curr-hide"><?= site_url()?> </label>
                                <input type="text" value="<?= $post_url ?>" class="current-txt-input curr-hide" id="edit-current-link">
                                <label class="end-slash curr-hide"></label>
                                <a class="change-current-link changeLink changeLink" id="change-btn" onclick="changeCUR('change');">
                                    Change
                                </a>

                                <a class="change-current-link curr-hide-btn curr-hide changeLink" onclick="changeCUR('save');">
                                    Save
                                </a>
                                <a class="change-current-cancel curr-hide-btn curr-hide changeLink" onclick="changeCUR('cancel');">
                                    Cancel
                                </a>
                                <p><small>(will be full updated after you save this updates)</small></p>
                                <span class="error"><?= form_error('blog_url') ?></span>
                            </div>                            
                        </div>

                        <!-- Hidden Current Link To Save -->
                        <input type="hidden" value="<?= $post_url?>" name="blog_url" id="set-current-link">
                        <input type="hidden" value="<?= site_url($post_url)?>"  id="old-url-link">
                        <input type="hidden" value="<?= $post_url?>"  id="old-url">

                        <div class="row">
                            <!-- Editor -->
                            <div class="form-group fg-float">
                                <div class="col-md-12">
                                    <div class="form-group fg-float">
                                        <textarea class="html-editor" name="blog_post" autocomplete="off"><?= stripcslashes($resultList[0]->post);?></textarea>
                                        <span class="error"><?= form_error('blog_post') ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-lg-3 col-md-3 col-sm-12 c-m-t-3">

                        <!-- Add Media -->
                        <div class="card card-special">

                            <div class="card-header ch-alt cust-card-header-h2">
                                <h2 class="placed-h2">Category </h2>

                                <div class="fg-line">
                                    <select class="selectpicker p-l-10" id="" name="blog_category"  autocomplete="off">
                                    <?php for ($i = 0; $i < count($categories); $i++): ?>
                                    <?php if (strtolower($categories[$i]->inheritance_title) == strtolower($resultList[0]->category)): ?>
                                        <option value="<?= strtolower($categories[$i]->inheritance_title) ?>" selected>
                                            <?= ucwords($categories[$i]->inheritance_title) ?>
                                        </option>
                                        <?php else: ?>
                                        <option value="<?= strtolower($categories[$i]->inheritance_title) ?>">
                                            <?= ucwords($categories[$i]->inheritance_title) ?>
                                        </option>
                                        <?php endif ?>
                                    <?php endfor ?>
                                    </select>
                                    <span class="error"><?= form_error('blog_category') ?></span>
                                </div>
                            </div>

                        </div>

                        <!-- Add Media -->
                        <div class="card card-special" style="display: none;">

                            <div class="card-header ch-alt cust-card-header-h2">
                                <h2 class="placed-h2">Media Manager </h2>

                                <button type="button" class="btn btn-info m-15" data-toggle="modal" data-target="#exampleModal">
                                    <i class="zmdi zmdi-collection-folder-image text-bold"> Add Image</i>
                                </button>
                            </div>

                        </div>

                        <!-- Quick Control -->
                        <div class="card card-special">

                            <div class="card-header ch-alt cust-card-header-h2">
                                <h2 class="placed-h2">Quick Control </h2>
                            </div>

                            <div class="m-10" style="display: none;">
                                <button class="btn palette-Grey bg waves-effect">Save </button>
                                <button class="btn btn-default  item-float-right">View</button>
                            </div>

                            <div class="card-body card-padding cust-card-padding">

                                <div class="form-group fg-float m-b-20">
                                    <div class="fg-line">
                                        <p class="f-500 m-b-15 c-black input-label"> Visibility: </p>
                                        <select class="selectpicker p-l-10" name="blog_show">
                                        <?php $visible = array('public','protected','private'); ?>
                                        <?php for($i = 0; $i < count($visible); $i++): ?>
                                            <?php if (strtolower($resultList[0]->visibility) == strtolower($visible[$i])): ?>
                                                <option value="<?= strtolower($visible[$i]) ?>" selected>
                                                    <?= ucwords($visible[$i]); ?>
                                                </option>
                                            <?php else: ?>
                                                <option value="<?= strtolower($visible[$i]) ?>">
                                                    <?= ucwords($visible[$i]); ?>
                                                </option>
                                            <?php endif ?>
                                        <?php endfor ?>
                                        </select>
                                        <span class="error"><?= form_error('blog_show') ?></span>
                                    </div>

                                    <div class="input-group form-group m-t-10 m-b-20" style="display: none">
                                        <p class="c-black f-500 input-label">Schedule :</p>

                                        <div class="toggle-switch">
                                            <label for="post-schedule" class="ts-label m-t-10 p-l-10" id="post-time">Publish Now</label>
                                            <label>
                                                <input id="post-schedule" type="checkbox" value="post" hidden="hidden" checked>
                                                <label for="post-schedule" class="ts-helper m-t-10"></label>
                                            </label>
                                        </div>

                                        <div class="dtp-container p-l-10 curr-hide" id="post-date">
                                            <input type='text' id="" class="form-control date-time-picker " placeholder="Choose Date">
                                        </div>
                                    </div>

                                </div>

                                <div class="clearfix"></div>

                                <div class="m-t-20 text-center">
                                    <button class="btn btn-success" onclick="submitForm('<?= $form_edit_link ;?>')" type="submit">Update</button>
                                    <button class="btn btn-danger">Cancel</button>
                                </div>

                            </div>

                        </div>

                        <div class="card card-special">
                            <div class="card-header ch-alt cust-card-header-h2">
                                <h2 class="placed-h2">Format <?= $resultList[0]->format ?> </h2>
                                <div class="radio m-b-15">
                                    <label>
                                        <input type="radio" name="blog_format" value="default"
                                        <?= (strtolower($resultList[0]->format == 'default')? 'checked=""':'') ?>>
                                        <i class="input-helper"></i>
                                        Default 
                                    </label>
                                </div>

                                <div class="radio m-b-15">
                                    <label>
                                        <input type="radio" name="blog_format" value="image"
                                        <?= (strtolower($resultList[0]->format == 'image')? 'checked=""':'') ?>>
                                        <i class="input-helper"></i>
                                        Image
                                    </label>
                                </div>
                                <span class="error"><?= form_error('blog_format') ?></span>
                            </div>
                        </div>
                        <!-- Add Media -->
                        <div class="card card-special">
                            <div class="card-header ch-alt cust-card-header-h2">
                                <h2 class="placed-h2">Featured Image </h2>
                                <div class="form-group fg-float">
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="fileinput-preview thumbnail" data-trigger="fileinput"></div>
                                        <div>
                                            <span class="btn btn-info btn-file">
                                                <span class="fileinput-new">Select image</span>
                                                <span class="fileinput-exists">Change</span>
                                                <input type="file" name="thumbnail[]">
                                            </span>
                                            <a href="#" class="btn btn-danger fileinput-exists" data-dismiss="fileinput">Remove</a>
                                        </div>
                                        <span class="error"><?= form_error('thumbnail') ?></span>
                                    </div>
                                </div>

                                <?php if (!empty($thumbnail)): ?>
                                    <h5><strong>Current Featured </h5>
                                    <div class="fg-line">
                                        <img src="<?= base_url($thumbnail) ?>" alt="" style="width: 100%; border-radius: 5px;">
                                    </div>
                                <?php endif ?>
                            </div>
                        </div>

                    </div>

                </div>

            </div>
        </div>


        <div class="card">
            <div class="card-header">
                <h2>Controls <small>Control you post section and appearance.</small></h2>
            </div>

            <div class="card-body card-padding">
                <div class="row">
                    <div class="col-sm-12 col-lg-12">
                        <h5><strong>Tags</strong> <small>(Separate item with comma E.g breaking,sports)</small></h5>
                        <div class="fg-line">
                            <?php $blog_tags = explode(',', $resultList[0]->tag) ?>
                            <select class="chosen" multiple data-placeholder="Choose Tag..." name="blog_tag[]" autocomplete="off">
                                <?php for ($i = 0; $i < count($tags); $i++): ?>
                                    <?php if (in_array(strtolower($tags[$i]->inheritance_title), $blog_tags)): ?>
                                    <option value="<?= strtolower($tags[$i]->inheritance_title) ?>" selected="">
                                        <?= ucwords($tags[$i]->inheritance_title) ?>
                                    </option>
                                    <?php else: ?>
                                    <option value="<?= strtolower($tags[$i]->inheritance_title) ?>">
                                        <?= ucwords($tags[$i]->inheritance_title) ?>
                                    </option>
                                    <?php endif ?>                                    
                                <?php endfor ?>
                            </select>
                        </div>
                        <span class="error"><?= form_error('blog_tag') ?></span>
                    </div>
                </div>

            </div>
        </div>

        </form>
    </div>
</section>

<!-- Includes -->
<?php $this->load->view("$extRoute/includes/modalMedia"); ?>
<!-- Includes -->
