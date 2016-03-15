<section class="sidebar">
    <div class="user-panel">
        <?php if($this->CI_auth->check_logged()=== true){ ?>
        <div class="pull-left image">
            <?php if($data_index['info_user']['avatar_thumb'] != ''){ ?>
                <img src="upload/user/<?php echo $data_index['info_user']['avatar'];?>" class="img-circle" alt="User Image" />
            <?php }else{ ?>
                <img src="public/bootstrap/img/user2-160x160.jpg" class="img-circle" alt="User Image" />
            <?php } ?>
        </div>
        <div class="pull-left info">
            <p><?php echo $data_index['info_user']['fullname'];?></p>
            <a href="userInfo.html"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
        <?php } ?>
    </div>
    <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
            <input type="text" name="q" class="form-control" placeholder="Search..." />
            <span class="input-group-btn">
              <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
            </span>
        </div>
    </form>
    <?php if($data_index['act'] != 'login'){ ?>
    <ul class="sidebar-menu">
        <li class="header">CONTROL ADMIN</li>
        <li class="active">
            <a href="index.html">
                <i class="fa fa-dashboard"></i> <span>Dashboard</span> <i class="fa fa-bar-chart pull-right"></i>
            </a>
        </li>
        <li class="treeview">
            <a href="request.html">
                <i class="ion ion-help-buoy"></i> <span>Request Member</span> <i class="fa fa-comment pull-right"></i>
            </a>
        </li>
        
        <?php if(isset($data_index['moduless']) && $data_index['moduless'] != NULL){ ?>
        <?php foreach ($data_index['moduless'] as $key => $val) { 
        if($val['active'] == 1){
			if($key == 0){
				$i = '<i class="fa fa-external-link"></i>';
			}else{
				$i = '<i class="fa fa-windows"></i>';
			}
		?>
        <li class="treeview">
            <a href="<?php if($val['controller'] != ''){ ?> admin/<?php echo $val['controller'];?>/index <?php } ?>"><i class="glyphicon glyphicon-film"></i> <span><?php echo $val['name'];?></span> <?php if($val['child'] != NULL){ ?><i class="fa fa-angle-left pull-right"></i><?php } ?></a>
            <?php if($val['child'] != NULL){ ?>
            <ul class="treeview-menu">
				<?php foreach ($val['child'] as $key_child => $val_child) { ?>
                <?php if($val_child['active'] == 1){ ?>
                <li><a href="admin/<?php echo $val_child['controller'];?>/index"><i class="glyphicon glyphicon-duplicate"></i> <?php echo $val_child['name'];?></a></li>
                <?php } ?>
                <?php } ?>
            </ul>
            <?php } ?>
        </li>
        <?php } ?>
        <?php } ?>
        <?php } ?>  
    </ul>
    <?php } ?>
</section>
