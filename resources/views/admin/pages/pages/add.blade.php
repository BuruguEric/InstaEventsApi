<section id="content">
    <div class="container">

        <form class="" role="form" action="#" method="post" accept-charset="utf-8" id="core" enctype="multipart/form-data" autocomplete="off">
            <script>
                function submitForm(action){
                    document.getElementById('core').action = action;
                    document.getElementById('core').submit();
                }
            </script>
            <?php $form_save_link = url($form_save);?>

        <div class="card card-bg-grey">
            <div class="card-header">
                <h2><?= ucwords(str_replace("_", " ",$ModuleName)); ?> <small>Create / Add new <?= strtolower('post'); ?></small></h2>
            </div>

            <div class="card-body card-header container card-padding">
                <!-- Notification -->
                <?= (!is_null($notify) && !empty($notify))? $notify : ''; ?>
                <div id="blogPOST">

                    <div class="col-lg-9 col-md-9 col-sm-12">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group fg-float">
                                    <label class="c-black f-500 c-m-tb-2 input-label">Add Title</label>
                                    <div class="fg-line">
                                        <input type="text" class="form-control fg-input background-input" name="page_title" 
                                        value="{{ old('page_title') }}"  autocomplete="off">
                                    </div>
                                    @if ($errors->has('page_title'))
                                        <span class="error">{{ $errors->first('page_title') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!-- Editor -->
                            <div class="form-group fg-float">
                                <div class="col-md-12">
                                    <div class="form-group fg-float">
                                        <textarea class="html-editor" name="page_post"  autocomplete="off">{{ old('page_post') }}</textarea>
                                        @if ($errors->has('page_post'))
                                            <span class="error">{{ $errors->first('page_post') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-12 c-m-t-3">

                        <!-- Add Media -->
                        <div class="card card-special" style="display: none">

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
                                <button type="button" class="btn palette-Grey bg waves-effect">Save Post</button>
                                <button type="button" class="btn btn-default  item-float-right">View Post</button>
                            </div>

                            <div class="card-body card-padding cust-card-padding">

                                <div class="form-group fg-float m-b-20">
                                    <div class="fg-line">
                                        <p class="f-500 m-b-15 c-black input-label"> Visibility: </p>
                                        <select class="selectpicker p-l-10" name="page_show">
                                            <option value="public" selected>Public</option>
                                            <option value="protected">Protected</option>
                                            <option value="private">Private</option>                                        
                                        </select>
                                        @if ($errors->has('page_show'))
                                            <span class="error">{{ $errors->first('page_show') }}</span>
                                        @endif
                                    </div>

                                    <div class="input-group form-group m-t-10 m-b-20">
                                        <p class="c-black f-500 input-label">Publish Schedule :</p>

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
                                    <button class="btn btn-success" onclick="submitForm('<?= $form_save_link ;?>')" type="submit">Publish Post</button>
                                    <button class="btn btn-danger">Cancel</button>
                                </div>

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
                                                <span class="fileinput-new">Choose Image</span>
                                                <span class="fileinput-exists">Change</span>
                                                <input type="file" name="thumbnail[]">
                                            </span>
                                            <a href="#" class="btn btn-danger fileinput-exists" data-dismiss="fileinput">Remove</a>
                                        </div>
                                        @if ($errors->has('thumbnail'))
                                            <span class="error">{{ $errors->first('thumbnail') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>
        </div>


        <div class="card">
            <div class="card-header">
                <h2>Page Controls <small>Control your page section and appearance.</small></h2>
            </div>

        </div>

        </form>
    </div>
</section>

<!-- Includes -->
@include("$extRoute/includes/modalMedia")
<!-- Includes -->
