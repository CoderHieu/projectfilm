<div class="row">
    <div class="col-md-6">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"><?php echo isset($title)?$title:'';?></h3>
        </div>
        <form id="frm-admin" method="post" action="">
          <div class="box-body">
            <div class="form-group">
                <label for="name">Tên nhóm</label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-pencil"></i></div>
                    <input type="text" class="form-control" id="name" name="name" value="<?php if(isset($role['name']) && $role['name']!=''){ echo $role['name']; }?>">
                </div>
            </div>
            <div class="form-group">
                <?php if($role['publish'] == 0){ ?>
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
          </div>
          <div class="box-footer">
            <a class="btn btn-success btn-flat add"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Cập nhật</a>
            <a href="admin/role/index" class="btn btn-success btn-flat"><span class="glyphicon glyphicon-share-alt" aria-hidden="true"></span> Hủy</a>
          </div>
        </form>
      </div>
    </div>
</div>