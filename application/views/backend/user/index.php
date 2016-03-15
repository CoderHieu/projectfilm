<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo isset($title)?$title:'';?></h3> 
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="col-md-12">
                    <?php
                        $message_flashdata = $this->session->flashdata('message_flashdata');
                        if(isset($message_flashdata) && count($message_flashdata)){
                          if($message_flashdata['type'] == 'sucess'){
                          ?>
                            <div class="success"><i class="fa fa-check"></i> <?php echo $message_flashdata['message']; ?></div>
                          <?php
                          }else if($message_flashdata['type'] == 'error'){
                          ?>
                            <div class="error"><i class="fa fa-close"></i> <?php echo $message_flashdata['message']; ?></div> 
                          <?php
                          }
                        }
                    ?>
                </div>
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
                    <a href="admin/user/add" type="button" class="btn btn-success btn-flat"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Thêm mới</a>
                    <a control="user" id="del-all" type="button" class="btn btn-success btn-flat del"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Xóa tất cả</a>
                    <a control="user" id="show-all" type="button" class="btn btn-success btn-flat shows"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Hiển thị</a>
                </div>
                </div>
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="div_center"><input type="checkbox" class="check-all"></th>
                            <th class="div_center">Họ & Tên</th>
                            <th class="div_center">Tài khoản</th>
                            <th class="div_center">Thuộc nhóm</th>
                            <th class="div_center">Ảnh</th> 
                            <th class="div_center">Ngày cập nhật</th>
                            <th class="div_center">Kích hoạt</th> 
                            <th class="div_center">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody id="div_load">
                        <?php if(isset($user) && $user!=NULL){ ?>
                            <?php foreach($user as $key => $val){ ?>
                            <tr> 
                              <td class="div_center"><input type="checkbox" name="chon" class="checkbox-menu" value="<?php echo $val['id']?>"></td>
                              <td><a href="admin/user/edit/<?php echo $val['id']?>"><?php echo $val['fullname'];?></a></td>
                              <td><?php echo $val['username'];?></td>
                              <td><?php echo $val['role_name'];?></td>
                              <td class="div_center"><?php if($val['avatar_thumb']!=''){ ?> <img src="upload/user/thumb/<?php echo $val['avatar_thumb'];?>" alt="" class="img_admin">
                              <?php }?></td>
                              <td><?php echo $val['created'];?></td>
                              <td class="div_center publish"><a control="user" title="Hiển thị" class="div_active<?php echo $val['id']?> div_active" divid="div_active<?php echo $val['id']?>" seq="<?php echo $val['id']?>">
                                <?php if($val['active'] == 0){ ?>
                                  <i class="fa fa-check-circle"></i>
                                <?php }else{ ?>
                                  <i class="fa fa-circle"></i>
                                <?php } ?></a>
                              </td>
                              <td class="div_center tool">
                                <a href="admin/user/edit/<?php echo $val['id']?>"><i class="fa fa-edit"></i></a>
                                <a class="delete" seq="<?php echo $val['id']?>" control="user"><i class="fa fa-trash"></i></a>
                              </td>
                            </tr>
                            <?php } ?>
                        <?php } ?>
                    </tbody>
                </table>
                <?php echo isset($list_pagination)?$list_pagination:''; ?>
                <div class="col-md-6 div_float_right">
                <div class="row">
                    <a href="admin/user/add" type="button" class="btn btn-success btn-flat"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Thêm mới</a>
                    <a control="user" id="del-all" type="button" class="btn btn-success btn-flat del"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Xóa tất cả</a>
                    <a control="user" id="show-all" type="button" class="btn btn-success btn-flat shows"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Hiển thị</a>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
