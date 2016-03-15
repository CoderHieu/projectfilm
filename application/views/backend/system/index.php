<div class="row" ng-app="myApp">
    <form id="frm-admin" method="post" action="" enctype="multipart/form-data">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Cấu hình site</h3>
        </div>
        <div class="col-md-6">
          <div class="box-body">
            <div class="form-group">
                <label class="control-label">Title</label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-pencil"></i></div>
                    <input type="text" class="form-control" name="title" id="title" value="<?php if(isset($system['title']) && $system['title']!=''){ echo $system['title']; }?>">
                </div>
            </div>
            <div class="form-group">
                <label>Meta keyword</label>
                <textarea class="form-control" rows="4" name="meta_keyword" id="meta_keyword"><?php if(isset($system['meta_keyword']) && $system['meta_keyword']!=''){ echo $system['meta_keyword']; }?></textarea>
            </div>
            <div class="form-group">
                <label>Meta description</label>
                <textarea class="form-control" rows="4" name="meta_description" id="meta_description"><?php if(isset($system['meta_description']) && $system['meta_description']!=''){ echo $system['meta_description']; }?></textarea>
            </div>
            <div class="form-group">
                <label for="name">Favicon</label>
                <span class="btn btn-primary btn-file btn-sm">
                    Browse <input type="file" name="favicon" id="favicon">
                </span>
            </div>
            <div class="col-xs-12">
            <div class="row">
                <div class="col-xs-12 col-sm-9 col-md-10 col-lg-10">
                    <div id="box_img_fv" class="div_avatar">
                        <?php if($system['favicon']!=''){ ?>
                            <img src="upload/system/<?php echo $system['favicon'];?>" alt="">
                        <?php } ?>
                    </div>
                </div>
            </div>
            </div>
            
          </div><!-- /.box-body -->
        </div>
        <div class="col-md-6">
            <div class="box-body">
                <div class="form-group">
                    <label class="control-label">Google analytics</label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-pencil"></i></div>
                        <input class="form-control" name="analytics" id="analytics" value="<?php if(isset($system['analytics']) && $system['analytics']!=''){ echo $system['analytics']; }?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label">Google webmaster</label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-pencil"></i></div>
                        <input class="form-control" name="webmaster" id="webmaster" value="<?php if(isset($system['webmaster']) && $system['webmaster']!=''){ echo $system['webmaster']; }?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="checkbox">
                        <label>
                          <input <?php if(isset($system['status']) && $system['status'] == 1){ ?> checked <?php } ?> type="checkbox" name="status" id="status" value="1">
                          Đóng website
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label">Nội dung</label>
                    <textarea class="form-control" rows="4" name="content" id="content"><?php if(isset($system['content']) && $system['content']!=''){ echo $system['content']; }?></textarea>
                </div>
            </div>
        </div>
        <div class="clear"></div>
          <div class="box-footer">
            <a class="btn btn-success btn-flat add"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Cập nhật</a>
            <a href="admin/system/index" class="btn btn-success btn-flat"><span class="glyphicon glyphicon-share-alt" aria-hidden="true"></span> Hủy</a>
          </div>
      </div>
    </div>
    </form>
</div>