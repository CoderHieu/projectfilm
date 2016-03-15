<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo isset($title)?$title:'';?></h3> 
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="col-md-4">
                <div class="row">
                  <div class="input-group">
                      <input type="text" class="form-control" id="search" name="search" control="user">
                      <div class="input-group-addon"><i class="fa fa-search"></i></div>
                  </div>
                </div>
                </div>
                <div class="col-md-6 div_float_right">
                <div class="row">
                    <a control="user" id="permission" type="button" class="btn btn-success btn-flat del"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Cập nhật</a>
                    <a href="admin/role/index" class="btn btn-success btn-flat del"><span class="glyphicon glyphicon-share-alt" aria-hidden="true"></span> Trở về</a>
                </div>
                </div>
                <table class="table table-bordered">
                    <thead> 
                      <tr>
                        <th class="div_center">Tên module</th>
                        <th class="div_center"><input type="checkbox" class="check-all">
                        <input type="hidden" name="id_role" id="id_role" value="<?php echo $id_role;?>">
                        </th> 
                      </tr> 
                    </thead> 
                    <tbody> 
                      <?php if(isset($module) && $module!=NULL){ ?>
                      <?php foreach($module as $key => $val){ ?>
                      <tr> 
                        <td><?php echo $val['name'];?></td>
                        <td class="div_center"><input <?php if($val['active'] == 1){ ?> checked <?php } ?> type="checkbox" name="chon" class="checkbox-menu" value="<?php echo $val['id']?>"></a>
                      </tr>
                          <?php if(isset($val['module_child']) && $val['module_child']!=NULL){ ?>
                          <?php foreach($val['module_child'] as $key_child => $val_child){ ?>
                                <tr> 
                                    <td><i class="fa fa-long-arrow-right"></i> <?php echo $val_child['name'];?></td>
                                    <td class="div_center"><input <?php if($val_child['active'] == 1){ ?> checked <?php } ?> type="checkbox" name="chon" class="checkbox-menu" value="<?php echo $val_child['id']?>"></a>
                                </tr>
                          <?php } ?>
                          <?php } ?>
                      <?php } ?>
                      <?php } ?>
                    </tbody> 
                </table>
                <div class="col-md-6 div_float_right">
                <div class="row">
                    <a control="user" id="permission" type="button" class="btn btn-success btn-flat del"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Cập nhật</a>
                    <a href="admin/role/index" class="btn btn-success btn-flat del"><span class="glyphicon glyphicon-share-alt" aria-hidden="true"></span> Trở về</a>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
