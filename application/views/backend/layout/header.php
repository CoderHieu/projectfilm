<a href="index.html" class="logo">
    <span class="logo-mini"><b>A</b>LT</span>
    <span class="logo-lg">Admin manager</span>
</a>

<nav class="navbar navbar-static-top" role="navigation">
    <?php if($this->CI_auth->check_logged()=== true){ ?>
    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
    </a>
    <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
            <li class="dropdown messages-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-envelope-o"></i>
                    <span class="label label-success">4</span>
                </a>
                <ul class="dropdown-menu">
                    <li class="header">You have 4 messages</li>
                    <li>
                        <ul class="menu">
                            <li>
                                <a href="#">
                                    <div class="pull-left">
                                    <?php if($data_index['info_user']['avatar_thumb'] != ''){ ?>
                                        <img src="upload/user/thumb/<?php echo $data_index['info_user']['avatar_thumb'];?>" class="img-circle" alt="User Image" />
                                    <?php }else{ ?>
                                        <img src="public/bootstrap/img/user2-160x160.jpg" class="img-circle" alt="User Image" />
                                    <?php } ?>
                                    </div>
                                    <h4>Support Team
                                      <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                    </h4>
                                    <p>Why not buy a new awesome theme?</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="footer"><a href="#">See All Messages</a></li>
                </ul>
            </li>
            <li class="dropdown notifications-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-bell-o"></i>
                    <span class="label label-warning">10</span>
                </a>
                <ul class="dropdown-menu">
                    <li class="header">You have 10 notifications</li>
                    <li>
                        <ul class="menu">
                            <li>
                                <a href="#">
                                    <i class="fa fa-users text-aqua"></i> 5 new members joined today
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="footer"><a href="#">View all</a></li>
                </ul>
            </li>
            <li class="dropdown tasks-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-flag-o"></i>
                    <span class="label label-danger">9</span>
                </a>
                <ul class="dropdown-menu">
                    <li class="header">You have 9 tasks</li>
                    <li>
                        <ul class="menu">
                            <li>
                                <a href="#">
                                    <h3>Design some buttons
                                      <small class="pull-right">20%</small>
                                    </h3>
                                    <div class="progress xs">
                                        <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                            <span class="sr-only">20% Complete</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="footer">
                        <a href="#">View all tasks</a>
                    </li>
                </ul>
            </li>
            <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <?php if($data_index['info_user']['avatar_thumb'] != ''){ ?>
                        <img src="upload/user/thumb/<?php echo $data_index['info_user']['avatar_thumb'];?>" class="img-circle" alt="User Image" />
                    <?php }else{ ?>
                        <img src="public/bootstrap/img/user2-160x160.jpg" class="user-image" alt="User Image" />
                    <?php } ?>
                    <span class="hidden-xs"><?php echo $data_index['info_user']['fullname'];?></span>
                </a>
                <ul class="dropdown-menu">
                    <li class="user-header">
                    <?php if($data_index['info_user']['avatar_thumb'] != ''){ ?>
                        <img src="upload/user/<?php echo $data_index['info_user']['avatar'];?>" class="img-circle" alt="User Image" />
                    <?php }else{ ?>
                        <img src="public/bootstrap/img/user2-160x160.jpg" class="img-circle" alt="User Image" />
                    <?php } ?>
                        <p>
                            Alexander Pierce - Web Developer
                            <small>Member since Nov. 2012</small>
                        </p>
                    </li>
                    <li class="user-body">
                        <div class="col-xs-4 text-center">
                            <a href="#">Followers</a>
                        </div>
                        <div class="col-xs-4 text-center">
                            <a href="#">Sales</a>
                        </div>
                        <div class="col-xs-4 text-center">
                            <a href="#">Friends</a>
                        </div>
                    </li>
                    <li class="user-footer">
                        <div class="pull-left">
                            <a href="admin/user/edit/<?php echo $data_index['info_user']['id']; ?>" class="btn btn-default btn-flat">Profile</a>
                        </div>
                        <div class="pull-right">
                            <a href="admin/dang-xuat.html" class="btn btn-default btn-flat">Sign out</a>
                        </div>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
            </li>
        </ul>
    </div>
    <?php } ?>
</nav>
