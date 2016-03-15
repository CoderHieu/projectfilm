<!DOCTYPE html>
<html>
<head>
    <base href="<?php echo site_url(); ?>" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo isset($title)?$title:''; ?></title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link rel="stylesheet" href="public/admin/css/style.css" type="text/css" />
    <link href="public/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="public/font-awesome-4.3.0/css/font-awesome.min.css" />
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="public/bootstrap/select2/select2.min.css" type="text/css" />
    <link href="public/bootstrap/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <link href="public/bootstrap/css/skin-blue.min.css" rel="stylesheet" type="text/css" />

    <script src="public/bootstrap/js/jQuery-2.1.4.min.js"></script>
    <script src="public/angularjs/angular.min.js"></script>
    <script src="public/angularjs/angular-route.js"></script>
    <script type="text/javascript" language="javascript" src="public/ckeditor/ckeditor.js" ></script>
</head>

<body class="skin-blue sidebar-mini">
    <div class="wrapper">
        <header class="main-header">
            <?php $this->load->view('backend/layout/header'); ?>
        </header>
        <aside class="main-sidebar">
            <?php $this->load->view('backend/layout/sidebar'); ?>
        </aside>
        <div class="content-wrapper">
            <section class="content">
                <?php
                    if(isset($template) && !empty($template)){
                        $this->load->view($template, isset($data)?$data:NULL);
                    }
                ?>
            </section>
        </div>
        <footer class="main-footer">
            <?php $this->load->view('backend/layout/footer'); ?>
        </footer>
        <aside class="control-sidebar control-sidebar-dark">
            <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
                <li class="active"><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
                <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="control-sidebar-home-tab">
                    <h3 class="control-sidebar-heading">Recent Activity</h3>
                    <ul class='control-sidebar-menu'>
                        <li>
                            <a href='javascript::;'>
                                <i class="menu-icon fa fa-birthday-cake bg-red"></i>
                                <div class="menu-info">
                                    <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>
                                    <p>Will be 23 on April 24th</p>
                                </div>
                            </a>
                        </li>
                    </ul>
                    <h3 class="control-sidebar-heading">Tasks Progress</h3>
                    <ul class='control-sidebar-menu'>
                        <li>
                            <a href='javascript::;'>
                                <h4 class="control-sidebar-subheading">
                    Custom Template Design
                    <span class="label label-danger pull-right">70%</span>
                  </h4>
                                <div class="progress progress-xxs">
                                    <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
                <div class="tab-pane" id="control-sidebar-settings-tab">
                    <form method="post">
                        <h3 class="control-sidebar-heading">General Settings</h3>
                        <div class="form-group">
                            <label class="control-sidebar-subheading">
                                Report panel usage
                                <input type="checkbox" class="pull-right" checked />
                            </label>
                            <p>
                                Some information about this general settings option
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </aside>
        <div class='control-sidebar-bg'></div>
    </div>
    

    <link rel="stylesheet" href="public/admin/css/bootstrap-datetimepicker.css" type="text/css" />
    <script type="text/javascript" src="public/admin/js/moment-with-locales.js"></script>
    <script type="text/javascript" src="public/admin/js/bootstrap-datetimepicker.js"></script>
    <script type="text/javascript" src="public/admin/js/filereader.js"></script>
    <script src="public/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="public/bootstrap/js/app.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="public/bootstrap/select2/select2.full.min.js"></script>
    
    <script type="text/javascript" src="public/admin/js/checkform.js"></script>
    <script type="text/javascript" src="public/admin/js/script.js"></script>
</body>

</html>