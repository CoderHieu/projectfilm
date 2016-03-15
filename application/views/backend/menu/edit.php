<div class="row">
    <div class="col-md-6">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"><?php echo isset($title)?$title:'';?></h3>
        </div>
        <form id="frm-admin" method="post" action="">
          <div class="box-body">
            <div class="form-group">
                <label for="exampleInputName">Tên</label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-pencil"></i></div>
                    <input type="text" class="form-control" id="name" name="name" value="<?php if(isset($menu['name']) && $menu['name']!=''){ echo $menu['name']; }?>">
                </div>
            </div>
            <div class="form-group">
                <label>Thuộc danh mục</label>
                <select class="form-control select2" name="parentid" id="parentid">
                    <option value="0">Gốc</option>
                    <?php if(isset($menus) && !is_null($menus)){ ?>
                        <?php foreach ($menus as $key_menu => $val_menu) { ?>
                            <option value="<?php echo $val_menu['id'];?>" <?php if($val_menu['id'] == $menu['parentid']){ ?> selected <?php } ?>><?php echo $val_menu['name'];?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
            </div><!-- /.form-group -->
            <div class="form-group">
                <label for="exampleInputName">Title</label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-pencil"></i></div>
                    <input type="text" class="form-control" id="title" name="title" value="<?php if(isset($menu['title']) && $menu['title']!=''){ echo $menu['title']; }?>">
                </div>
            </div>
            <div class="form-group">
                <div class="radio-inline">
                    <label>
                        <input <?php if($menu['type'] == 0){ ?> checked <?php } ?> type="radio" name="type" id="type" value="0" />
                        Film
                    </label>
                </div>
                <div class="radio-inline">
                    <label>
                        <input <?php if($menu['type'] == 1){ ?> checked <?php } ?> type="radio" name="type" id="type" value="1" />
                        Media
                    </label>
                </div>
                <div class="radio-inline">
                    <label>
                        <input <?php if($menu['type'] == 2){ ?> checked <?php } ?> type="radio" name="type" id="type" value="2" />
                        Bài viết
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label>Meta keyword</label>
                <textarea class="form-control" rows="4" name="meta_keyword" id="meta_keyword"><?php if(isset($menu['meta_keyword']) && $menu['meta_keyword']!=''){ echo $menu['meta_keyword']; }?></textarea>
            </div>
            <div class="form-group">
                <label>Meta description</label>
                <textarea class="form-control" rows="4" name="meta_description" id="meta_description"><?php if(isset($menu['meta_description']) && $menu['meta_description']!=''){ echo $menu['meta_description']; }?></textarea>
            </div>
            <div class="form-group">
                <?php if($menu['publish'] == 0){ ?>
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
            <a href="admin/menu/index" class="btn btn-success btn-flat"><span class="glyphicon glyphicon-share-alt" aria-hidden="true"></span> Trở về</a>
          </div>
        </form>
      </div>
    </div>
</div>