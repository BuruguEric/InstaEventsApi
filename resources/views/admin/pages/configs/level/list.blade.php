            <section id="content">
                <div class="container">
                    <div class="col-md-12">
                        <div class="card">
                            <!-- Notification -->
                            <?= (!is_null($notify) && !empty($notify))? $notify : ''; ?>
                        </div>                        
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h2><?= ucwords($ModuleName); ?> <small>Create / Add new <?= strtolower($ModuleName); ?></small></h2>
                            </div>
                            
                            <div class="card-body card-padding">
                                <form autocomplete="off" id="" role="form" method="post" action="{{ url($form_save) }}">@csrf
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12">
                                            <div class="form-group">
                                                <div class="">
                                                    <label><strong>Default Value</strong></label>
                                                    <label class="radio radio-inline m-r-20">
                                                        <input type="radio" name="level_default" value="yes" checked="">
                                                        <i class="input-helper"></i>
                                                        <?= ucwords('Yes') ?>
                                                    </label>
                                                    <label class="radio radio-inline m-r-20">
                                                        <input type="radio" name="level_default" value="no">
                                                        <i class="input-helper"></i>
                                                        <?= ucwords('No') ?>
                                                    </label>
                                                </div>
                                                @if ($errors->has('level_default'))
                                                    <span class="error">{{ $errors->first('level_default') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-sm-12">
                                            <div class="fg-line">
                                                <label>Select Modules <small>(Modules allowed to access)</small> 
                                                    <i class="fa fa-asterisk"></i>
                                                </label>
                                                <select name="level_module[]" class="selectpicker" multiple="" data-placeholder="Choose Modules...">
                                                    <?php for ($i = 0; $i < count($modulelist); $i++): ?>
                                                        <?php if ($i == 0): ?>
                                                            <option selected="" value="<?= strtolower($modulelist[$i]) ?>"><?= ucwords($modulelist[$i])?></option>
                                                        <?php elseif (strtolower($modulelist[$i]) == 'profile' || strtolower($modulelist[$i]) =='main'): ?>
                                                            <option selected="" value="<?= strtolower($modulelist[$i]) ?>"><?= ucwords($modulelist[$i])?></option>
                                                        <?php else: ?>
                                                            <option value="<?= strtolower($modulelist[$i]) ?>"><?= ucwords($modulelist[$i])?></option>
                                                        <?php endif ?>
                                                    <?php endfor ?>
                                                </select>
                                            </div>
                                            @if ($errors->has('level_module'))
                                                <span class="error">{{ $errors->first('level_module') }}</span>
                                            @endif
                                        </div>

                                        <div class="col-md-12 col-sm-12">
                                            <div class="form-group">
                                                <div class="fg-line">
                                                    <label>Access Name <small>(access / level name)</small> 
                                                        <i class="fa fa-asterisk"></i>
                                                    </label>
                                                    <input type="text" class="form-control" name="level_name" id="" autocomplete="off" value="{{ old('level_name') }}">
                                                </div>
                                                @if ($errors->has('level_name'))
                                                    <span class="error">{{ $errors->first('level_name') }}</span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-12 col-sm-12">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary btn-lg waves-effect flt-right brd-20">Save</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 col-sm-12">                        
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-sm-12 col-md-12">
                                        <h2><?= ucwords($ModuleName); ?> <small>Manage data by edit or delete <?= strtolower($ModuleName); ?></small></h2>
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
                                                <li><a onclick="actionBulk('edit');">Edit</a></li>
                                                <li class="divider"></li>
                                                <li><a onclick="actionBulk('delete');">Delete</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <table id="data-table-command" class="table table-striped table-vmiddle">
                                    <thead>
                                        <tr>                                        
                                            <?php 
                                                $array = get_object_vars($dataList[0]);
                                                $ths = array_keys($array);
                                            ?>
                                            <?php for ($i=0; $i < count($ths); $i++): ?>
                                                <?php if ($i==0): ?>
                                                <th data-column-id="id" data-type="numeric" data-identifier="true">ID</th>
                                                <?php else: ?>
                                                <th data-column-id="<?= $ths[$i]; ?>" data-order="desc">
                                                    <?= ucwords(str_replace("_", " ",$ths[$i]));?>    
                                                </th>
                                                <?php endif ?>
                                            <?php endfor ?>
                                            <th data-column-id="commands" data-formatter="commands" data-sortable="false">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php for ($i=0; $i < count($dataList); $i++): ?>
                                        <tr>
                                            <?php for ($k=0; $k < count($ths); $k++):  $key = $ths[$k];?>
                                                <?php $active_column = strtolower($CoreForm->singularize($Module)).'_'.'flg'; ?>
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
                </div>
            </section>
