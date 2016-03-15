<div class="row">
    <div class="col-md-6">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"><?php echo isset($title)?$title:'';?></h3>
        </div>
        <form id="frm-admin" method="post" action="">
          <div class="box-body">
            <div class="form-group">
                <label for="exampleInputName">Tên module</label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-pencil"></i></div>
                    <input type="text" class="form-control" id="name" name="name" value="<?php if(isset($module['name']) && $module['name']!=''){ echo $module['name']; }?>">
                </div>
            </div>
            <div class="form-group">
                <label>Thuộc danh mục</label>
                <select class="form-control select2" name="parentid" id="parentid">
                    <option value="0">Gốc</option>
                    <?php if(isset($modules) && !is_null($modules)){ ?>
                        <?php foreach ($modules as $key_module => $val_module) { ?>
                            <option value="<?php echo $val_module['id'];?>" <?php if($val_module['id'] == $module['parentid']){ ?> selected <?php } ?>><?php echo $val_module['name'];?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
            </div><!-- /.form-group -->
            <div class="form-group">
                <label for="exampleInputName">Controller</label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-pencil"></i></div>
                    <input type="text" class="form-control" id="controller" name="controller" value="<?php if(isset($module['controller']) && $module['controller']!=''){ echo $module['controller']; }?>">
                </div>
            </div>
            <div class="form-group">
                <?php if($module['publish'] == 0){ ?>
                <div class="radio-inline">
                    <label>
                        <input type="radio" name="publish" id="publish" value="0" checked />
                        Hiển thị
                    </label>
                </div>
                <div class="radio-inline">
                    <label>
                        <input type="radio" name="publish" id="publish" value="1" />
                        Ẩn
                    </label>
                </div>
                <?php }else{ ?>
                <div class="radio-inline">
                    <label>
                        <input type="radio" name="publish" id="publish" value="0" />
                        Hiển thị
                    </label>
                </div>
                <div class="radio-inline">
                    <label>
                        <input type="radio" name="publish" id="publish" value="1" checked />
                        Ẩn
                    </label>
                </div>
                <?php } ?>
            </div>
          </div><!-- /.box-body -->

          <div class="box-footer">
            <a class="btn btn-success btn-flat add"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Lưu</a>
            <a class="btn btn-success btn-flat reset"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span> Hủy</a>
            <a href="admin/module/index" class="btn btn-success btn-flat"><span class="glyphicon glyphicon-share-alt" aria-hidden="true"></span> Trở về</a>
          </div>
        </form>
      </div>
    </div>
</div>