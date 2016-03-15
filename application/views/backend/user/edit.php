<div class="row">
    <div class="col-md-6">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"><?php echo isset($title)?$title:'';?></h3>
        </div>
        <form ng-app="myApp" id="frm-admin" method="post" action="" enctype="multipart/form-data">
          <div class="box-body">
            <div class="form-group">
                <label class="control-label">Thuộc nhóm</label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-users"></i></div>
                    <select class="form-control select2" name="id_role" id="id_role">
                      <option value="">Chọn nhóm</option>
                      <?php if(isset($role) && !is_null($role)){ ?>
                      <?php foreach ($role as $key_role => $val_role) { ?>
                            <option value="<?php echo $val_role['id'];?>" <?php if($val_role['id'] == $user['id_role']){ ?> selected <?php } ?>><?php echo $val_role['name'];?></option>
                      <?php } ?>
                      <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label">Tài khoản</label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-unlock-alt"></i></div>
                    <input type="text" class="form-control" name="username" id="username" value="<?php if(isset($user['username']) && $user['username']!=''){ echo $user['username']; }?>" disabled="">
                </div>
            </div>
            <div class="form-group">
                <div class="checkbox">
                    <label>
                      <input type="checkbox" ng-model="changePass">
                      Đổi mật khẩu
                    </label>
                </div>
            </div>
            <div ng-show="changePass">
            <div class="form-group">
                <label class="control-label">Mật khẩu</label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-key"></i></div>
                    <input type="password" class="form-control" name="password" id="password">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label">Nhập lại mật khẩu</label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-key"></i></div>
                    <input type="password" class="form-control" name="repassword" id="repassword">
                </div>
            </div>
            </div>
            <div class="form-group">
                <?php if($user['sex'] == 0){ ?>
                    <label class="radio-inline">
                      <input checked="" type="radio" name="sex" id="sex" value="0"> Nam
                    </label>
                    <label class="radio-inline">
                      <input type="radio" name="sex" id="sex" value="1"> Nữ
                    </label>
                <?php }else{ ?>
                    <label class="radio-inline">
                      <input type="radio" name="sex" id="sex" value="0"> Nam
                    </label>
                    <label class="radio-inline">
                      <input checked="" type="radio" name="sex" id="sex" value="1"> Nữ
                    </label>
                <?php } ?>
            </div>
            <div class="form-group">
                <label class="control-label">Họ & tên</label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-user"></i></div>
                    <input type="text" class="form-control" name="fullname" id="fullname" value="<?php if(isset($user['fullname']) && $user['fullname']!=''){ echo $user['fullname']; }?>">
                </div>
            </div>
            <div class="form-group">
                <label for="name">Hình ảnh đại diện</label>
                <span class="btn btn-primary btn-file btn-sm">
                    Browse <input type="file" name="avatar" id="image">
                </span>
            </div>
            <div class="col-xs-12">
            <div class="row">
                <div class="col-xs-12 col-sm-9 col-md-10 col-lg-10">
                    <div id="box_img" class="div_avatar">
                        <?php if($user['avatar_thumb']!=''){ ?>
                            <img src="upload/user/thumb/<?php echo $user['avatar_thumb'];?>" alt="" class="image_admin">
                        <?php } ?>
                    </div>
                </div>
            </div>
            </div>
            <div class="form-group">
                <label class="control-label">Email</label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-envelope-o"></i></div>
                    <input type="text" class="form-control" name="email" id="email" value="<?php if(isset($user['email']) && $user['email']!=''){ echo $user['email']; }?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label">Ngày sinh</label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-birthday-cake"></i></div>
                    <input type="text" class="form-control" name="birthday" id="birthday" value="<?php if(isset($user['birthday']) && $user['birthday']!=''){ echo $user['birthday']; }?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label">Số điện thoại</label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-phone"></i></div>
                    <input type="text" class="form-control" name="phone" id="phone" value="<?php if(isset($user['phone']) && $user['phone']!=''){ echo $user['phone']; }?>">
                </div>
            </div>
            <div class="form-group">
                <?php if($user['active'] == 0){ ?>
                    <label class="radio-inline">
                      <input checked="" type="radio" name="active" id="active" value="0"> Kích hoạt
                    </label>
                    <label class="radio-inline">
                      <input type="radio" name="active" id="active" value="1"> Không kích hoạt
                    </label>
                <?php }else{ ?>
                    <label class="radio-inline">
                      <input type="radio" name="active" id="active" value="0"> Kích hoạt
                    </label>
                    <label class="radio-inline">
                      <input checked="" type="radio" name="active" id="active" value="1"> Không kích hoạt
                    </label>
                <?php } ?> 
            </div>
          </div><!-- /.box-body -->

          <div class="box-footer">
            <a class="btn btn-success btn-flat add"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Cập nhật</a>
            <a href="admin/user/index" class="btn btn-success btn-flat"><span class="glyphicon glyphicon-share-alt" aria-hidden="true"></span> Hủy</a>
          </div>
        </form>
      </div>
    </div>
</div>