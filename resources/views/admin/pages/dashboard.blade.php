



            <section id="content">
                <div class="container">

                    <div class="c-analytics row hidden-xs">
                        <div class="btn-group btn-group-justified" role="group" aria-label="...">
                            <div class="btn-group" role="group">
                                <a type="button" class="btn btn-default" href="{{ url('/') }}">New Page</a>
                            </div>
                            <div class="btn-group" role="group">
                                <a type="button" class="btn btn-info">Customization</a>
                            </div>
                            <div class="btn-group" role="group">
                                <a type="button" class="btn btn-warning" href="{{ url('/') }}" target="_blank">View Website</a>
                            </div>
                        </div>
                    </div>

                    <div class="row dash-margin">
                        <div class="col-md-3">
                            <div class="core-text">
                                <h1>Dashboard  |</h1>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="" style="display: none;">
                                <div class="alert alert-info dash-notify" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    Heads up! This alert needs your attention, but it's not super important.
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <!-- Notification -->
                        <?= (!is_null($notify) && !empty($notify))? $notify : ''; ?>
                    </div>

                    <div id="c-grid" class="clearfix" data-columns>
                        <div class="card c-dark palette-Blue-Grey bg">
                            <div class="card-header pad-btm-0">
                                <h2>Overview <small>Jump to manager on click</small></h2>
                            </div>
                            <hr>
                            <div class="row card-body card-padding core-overview">
                                <div class="col-md-6">
                                    <span>
                                        <i class="zmdi zmdi-format-color-text"></i> 
                                        <a href="{{ url('/') }}"> 
                                            Post
                                        </a>
                                    </span>
                                </div>
                                <div class="col-md-6">
                                    <span>
                                        <i class="zmdi zmdi-comment-list"></i> <a href=""> 1 Comment</a>
                                    </span>
                                </div>
                                <div class="col-md-6">
                                    <span>
                                        <i class="zmdi zmdi-file-plus"></i> 
                                        <a href="{{ url('/') }}"> 
                                            Page
                                        </a>
                                    </span>
                                </div>
                                <div class="col-md-6">
                                    <span>
                                        <i class="zmdi zmdi-plus-circle-o-duplicate"></i> <a href=""> 2 Content</a>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="card ">
                            <div class="card-header ch-alt">
                                <h2>Blog Draft <small>Draft a post</small></h2>
                            </div>

                            <div class="card-body card-padding">

                                <form enctype="">

                                    <div class="form-group fg-float m-b-30">
                                        <div class="fg-line">
                                            <input type="text" placeholder="Post Title" class="form-control input-sm">
                                        </div>
                                    </div>

                                    <div class="form-group fg-float">
                                        <div class="fg-line">
                                            <textarea class="form-control" placeholder="Write a quick blog post draft/memo" rows="6"></textarea>
                                        </div>
                                    </div>

                                    <div class="m-t-20">
                                        <button type="button" class="btn btn-info">Save as Draft</button>
                                    </div>

                                </form>

                                <div class="clearfix"></div>

                                <div class="pad-top-5">
                                    <p> <a href=""> <i class="zmdi zmdi-more-vert"></i> 2 Draft Post ... </a></p>
                                    <p>All Drafted post wont be published directely, you have to <a href="">open draft</a> and publish them. </p>
                                </div>

                            </div>
                        </div>

                        <div class="card c-dark palette-Blue-Only bg">
                            <div class="card-header pad-btm-0">
                                <h2>Controls <small>Theme &amp; Layout Settings</small></h2>
                            </div>
                            <hr>
                            <div class="row card-body card-padding core-overview core-overview-two">
                                <div class="col-md-4">
                                    <span>
                                        <i class="zmdi zmdi-money"></i> <a href=""> Visit Store</a>
                                    </span>
                                </div>
                                <div class="col-md-4">
                                    <span>
                                        <i class="zmdi zmdi-star-half"></i> <a href=""> Widgets</a>
                                    </span>
                                </div>
                                <div class="col-md-4">
                                    <span>
                                        <i class="zmdi zmdi-puzzle-piece"></i> <a href=""> Extensions</a>
                                    </span>
                                </div>
                                <div class="col-md-6">
                                    <span>
                                        <i class="zmdi zmdi-menu"></i> <a href=""> Menu Manager</a>
                                    </span>
                                </div>
                                <div class="col-md-6">
                                    <span>
                                        <i class="zmdi zmdi-flower"></i> <a href=""> Customize</a>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

