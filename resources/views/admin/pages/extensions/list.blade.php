            <section id="content">
                <div class="container">

                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <h2><?= ucwords($Module); ?> <small>Manage data by edit or delete <?= strtolower($Module); ?></small></h2>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <a href='<?= site_url($form_new);  ?>' class="btn btn-primary btn-lg waves-effect flt-right brd-5">
                                        Add New <i class="fa fa-plus"></i> 
                                    </a>
                                </div>
                            </div>
                        </div>

                        <?php if (!empty($dataList)): ?>                                
                        <div class="table-responsive">
                            <div class="buld-action">
                                <div class="row mag-0 mag-btm-5">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-warning">Buld Action</button>
                                        <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                            <span class="caret"></span>
                                            <span class="sr-only">Split button dropdowns</span>
                                        </button>
                                        <ul class="dropdown-menu" role="menu">
                                            <li><a onclick="actionBulk('activate');">Activate</a></li>
                                            <li><a onclick="actionBulk('deactivate');">Deactivate</a></li>
                                            <li class="divider"></li>
                                            <li><a onclick="actionBulk('delete');">Delete</a></li>
                                        </ul>
                                    </div>
                                </div>

                                <!-- Notification -->
                                <?= (!is_null($notify) && !empty($notify))? $notify : ''; ?>
                            </div>
                            <table id="data-table-selection" class="table table-striped table-vmiddle">
                                <thead>
                                    <tr>                                        
                                        <?php 
                                            $array = get_object_vars($dataList[0]);
                                            $ths = array_keys($array);
                                        ?>
                                        <?php for ($i=0; $i < count($ths); $i++): ?>
                                            <?php if ($i==0): ?>
                                            <th data-column-id="id" data-type="numeric" data-identifier="true" data-order="desc">ID</th>
                                            <?php else: ?>
                                            <th data-column-id="<?= $ths[$i]; ?>">
                                                <?= ucwords(str_replace("_", " ",$ths[$i]));?>                                                    
                                            </th>
                                            <?php endif ?>
                                        <?php endfor ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php for ($i=0; $i < count((array)$dataList); $i++): ?>
                                    <tr>
                                        <?php for ($k=0; $k < count($ths); $k++):  $key = $ths[$k];?>
                                            <?php $active_column = strtolower($this->plural->singularize($Module)).'_'.'flg'; ?>
                                            <?php if ($key == 'status' || $key == $active_column): ?>
                                                    <?php if ($dataList[$i]->$key == 1): ?>
                                                        <td> Active </td>
                                                    <?php else: ?>
                                                       <td> Deactivated </td>
                                                    <?php endif ?>
                                            <?php else: ?> 
                                                <td><?= $dataList[$i]->$key; ?></td>
                                            <?php endif ?>                                                  
                                        <?php endfor ?>
                                    </tr>
                                    <?php endfor ?>
                                </tbody>
                            </table>

                        </div>
                        <?php else: ?>
                        <div class="table-responsive">
                            <div class="buld-action">
                                <div class="row mag-0">
                                    <hr>
                                        <p class="text-center"><strong>This request current has no data</strong></p>
                                    <hr>
                                </div>
                            </div>
                        </div>
                        <?php endif ?>

                    </div>
                    
                </div>
            </section>
