

<?php /* Modal Path */ include 'asset.php'; ?>

<!-- Modal -->
<div class="modal fade" id="exampleModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-body">
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2" id="media-menu">
                    <div class="media-menu">
                        <div>
                            <ul class="media-left-menu">
                                <li><a onclick="mediaManager('upload-new');">Upload Image</a></li>
                                <li><a onclick="mediaManager('media-new');">Look Inside Media</a></li>
                                <hr>
                                <li><a onclick="mediaManager('url-new');">Add URL</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">

                    <div id="upload-new">                        
                        <div class="modal-header">
                            <button type="button" class="close btn-close" data-dismiss="modal">&times;</button>
                            <h2 class="modal-title media-header">Upload New Image</h2>
                        </div>

                        <div class="upload-zone">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="upload-area">
                                    <div class="row">
                                        <div class="upload-box">
                                            <img src="<?= $pathModal; ?>includes/img/upload1.jpg">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="center drop-upload">
                                            <h2>Drag and Drop To Upload</h2>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="upload-btn">
                                            <button class="btn btn-default btn-lg">Select To Upload</button>
                                        </div>
                                        <p class="upload-txt"> Maximum File Size 2 MB</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="media-new">
                        <div class="modal-header">
                            <button type="button" class="close btn-close" data-dismiss="modal">&times;</button>
                            <h2 class="modal-title media-header">Add New Image</h2>
                        </div>

                        <div class="media-zone">
                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9" id="media-edit">
                                <div class="row">

                                    <div class="input-group">
                                        <div class="fg-line">
                                            <input type="text" class="form-control" placeholder="Search Image">
                                        </div>
                                        <span class="input-group-addon last"><i class="zmdi zmdi-search zmdi-hc-fw"></i></span>
                                    </div>

                                </div>
                            </div>                            
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                <div class="row">
                                    
                                    <div class="insert-setting">
                                        <h4 class="center">Image Details</h4>
                                    </div>

                                </div>                                
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>