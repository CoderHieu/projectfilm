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
                      <input type="text" class="form-control" id="search" name="search" control="menu">
                      <div class="input-group-addon"><i class="fa fa-search"></i></div>
                  </div>
                </div>
                </div>
                <div class="col-md-6 div_float_right">
                <div class="row">
                    <a href="admin/menu/add" type="button" class="btn btn-success btn-flat"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Thêm mới</a>
                    <a control="menu" id="del-all" type="button" class="btn btn-success btn-flat del"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Xóa tất cả</a>
                    <a control="menu" id="show-all" type="button" class="btn btn-success btn-flat shows"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Hiển thị</a>
                </div>
                </div>
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="div_center"><input type="checkbox" class="check-all"></th>
                            <th class="div_center">Tên</th>
                            <th class="div_center">Danh mục</th> 
                            <th class="div_center">Ngày cập nhật</th>
                            <th class="div_center">Sắp xếp</th>
                            <th class="div_center">Hiển thị</th> 
                            <th class="div_center">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody id="div_load">
                        <?php if(isset($menu) && $menu!=NULL){ ?>
                        <?php foreach($menu as $key => $val){ ?>
                        <tr> 
                          <td class="div_center"><input type="checkbox" name="chon" class="checkbox-menu" value="<?php echo $val['id']?>"></td>
                          <td><a href="admin/menu/edit/<?php echo $val['id']?>"><?php echo $val['name'];?></a></td>
                          <td>
                              <div class="col-xs-12">
                              <div></div>
                              <div class="form-group" style="margin-bottom:0px;">
                                  <select class="form-control select2 select-search parentid" control="menu" seq="<?php echo $val['id']?>" name="parentid" id="parentid" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                    <option value="0">Gốc</option>
                                    <?php if(isset($menu) && !is_null($menu)){ ?>
                                    <?php foreach ($menu as $key_menu => $val_menu) { ?>
                                          <option value="<?php echo $val_menu['id'];?>" <?php if($val_menu['id'] == $val['parentid']){ ?> selected <?php } ?>><?php echo $val_menu['name'];?></option>
                                    <?php } ?>
                                    <?php } ?>
                                  </select>
                              </div></div>
                          </td>
                          <td><?php echo $val['created'];?></td>
                          <td class="div_center"><input class="sort div_center" name="sort" control="menu" value="<?php echo isset($val['sort'])?$val['sort']:'';?>" id="sort" size="5" seq="<?php echo $val['id']?>"></td>
                          <td class="div_center publish"><a control="menu" title="Hiển thị" class="div_hienthi<?php echo $val['id']?> div_hienthi" divid="div_hienthi<?php echo $val['id']?>" seq="<?php echo $val['id']?>">
                            <?php if($val['publish'] == 0){ ?>
                              <i class="fa fa-check-circle"></i>
                            <?php }else{ ?>
                              <i class="fa fa-circle"></i>
                            <?php } ?></a>
                          </td>
                          <td class="div_center tool">
                            <a href="admin/menu/edit/<?php echo $val['id']?>"><i class="fa fa-edit"></i></a>
                            <a class="delete" seq="<?php echo $val['id']?>" control="menu"><i class="fa fa-trash"></i></a>
                            
                          </td>
                        </tr>
                            <?php if(isset($val['menu_child']) && !is_null($val['menu_child'])){ ?>
                                <?php foreach ($val['menu_child'] as $key_child => $val_child) { ?>
                                    <tr>
                                      <td class="div_center"><input type="checkbox" name="chon" class="checkbox-menu" value="<?php echo $val_child['id']?>"></td>
                                      <td><a href="admin/menu/edit/<?php echo $val_child['id']?>"><i class="fa fa-mail-forward"></i> <?php echo $val_child['name'];?></a></td>
                                      <td><div class="col-xs-12">
                                          <div class="form-group" style="margin-bottom:0px;">
                                              <select class="form-control select2 select-search parentid" name="parentid" id="parentid" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                                <option value="0">Gốc</option>
                                                <?php if(isset($menu) && !is_null($menu)){ ?>
                                                <?php foreach ($menu as $key_menu => $val_menu) { ?>
                                                      <option value="<?php echo $val_menu['id'];?>" <?php if($val_menu['id'] == $val_child['parentid']){ ?> selected <?php } ?>><?php echo $val_menu['name'];?></option>
                                                <?php } ?>
                                                <?php } ?>
                                              </select>
                                          </div></div>
                                      </td>
                                      <td><?php echo $val_child['created'];?></td>
                                      <td class="div_center"><input class="sort div_center" name="sort" control="menu" value="<?php echo isset($val_child['sort'])?$val_child['sort']:'';?>" id="sort" size="5" seq="<?php echo $val_child['id']?>"></td>
                                      <td class="div_center publish"><a control="menu" title="Hiển thị" class="div_hienthi<?php echo $val_child['id']?> div_hienthi" divid="div_hienthi<?php echo $val_child['id']?>" seq="<?php echo $val_child['id']?>">
                                        <?php if($val_child['publish'] == 0){ ?>
                                          <i class="fa fa-check-circle"></i>
                                        <?php }else{ ?>
                                          <i class="fa fa-circle"></i>
                                        <?php } ?></a>
                                      </td>
                                      <td class="div_center tool">
                                        <a href="admin/menu/edit/<?php echo $val_child['id']?>"><i class="fa fa-edit"></i></a>
                                        <a class="delete" seq="<?php echo $val_child['id']?>" control="menu"><i class="fa fa-trash"></i></a>
                                        
                                      </td>
                                    </tr>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>
                        <?php } ?>
                    </tbody>
                </table>
                <?php echo isset($list_pagination)?$list_pagination:''; ?>
                <div class="col-md-6 div_float_right">
                <div class="row">
                    <a href="admin/menu/add" type="button" class="btn btn-success btn-flat"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Thêm mới</a>
                    <a control="menu" id="del-all" type="button" class="btn btn-success btn-flat del"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Xóa tất cả</a>
                    <a control="menu" id="show-all" type="button" class="btn btn-success btn-flat shows"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Hiển thị</a>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
