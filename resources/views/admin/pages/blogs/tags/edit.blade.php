<section id="content">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2><?= ucwords($ModuleName); ?> <small>Edit / Update <?= strtolower($ModuleName); ?></small></h2>
            </div>
            

            <div class="card-body card-padding">
                <!-- Notification -->
                <?= (!is_null($notify) && !empty($notify))? $notify : ''; ?>
                <?= form_open($form_edit, '', ' autocomplete="off" '); ?>
                    <div class="row">
                        <input type="hidden" name="id" value="<?= $resultList[0]->id;?>">
                        <input type="hidden" name="inheritance_type" value="tag">
                        <input type="hidden" name="inheritance_parent" value="0">
                        <div class="col-md-12 col-sm-12">
                            <div class="form-group">
                                <div class="fg-line">
                                    <label>Title <i class="fa fa-asterisk"></i></label>
                                    <input type="text" class="form-control" name="inheritance_title" id="" autocomplete="off" value="<?= $resultList[0]->title; ?>">
                                </div>
                                <span class="error"><?= form_error('inheritance_title') ?></span>
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
