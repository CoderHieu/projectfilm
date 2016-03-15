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
                    <input type="text" class="form-control" id="name" name="name" value="<?php if(isset($country['name']) && $country['name']!=''){ echo $country['name']; }?>">
                </div>
            </div>
            <div class="form-group">
                <label for="exampleInputName">Title</label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-pencil"></i></div>
                    <input type="text" class="form-control" id="title" name="title" value="<?php if(isset($country['title']) && $country['title']!=''){ echo $country['title']; }?>">
                </div>
            </div>
            <div class="form-group">
                <label>Meta keyword</label>
                <textarea class="form-control" rows="4" name="meta_keyword" id="meta_keyword"><?php if(isset($country['meta_keyword']) && $country['meta_keyword']!=''){ echo $country['meta_keyword']; }?></textarea>
            </div>
            <div class="form-group">
                <label>Meta description</label>
                <textarea class="form-control" rows="4" name="meta_description" id="meta_description"><?php if(isset($country['meta_description']) && $country['meta_description']!=''){ echo $country['meta_description']; }?></textarea>
            </div>
            <div class="form-group">
                <?php if($country['publish'] == 0){ ?>
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
            <a href="admin/country/index" class="btn btn-success btn-flat"><span class="glyphicon glyphicon-share-alt" aria-hidden="true"></span> Trở về</a>
          </div>
        </form>
      </div>
    </div>
</div>