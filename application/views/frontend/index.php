<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" itemtype="http://schema.org/WebPage">
<html>
<head>
    <base href="<?php echo site_url(); ?>" />
    <meta http-equiv="content-language" content="vi"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="robots" content="index,follow,snippet,archive" />
    <meta name="title" content="<?php echo isset($title)?$title:''; ?>" />
    <meta name="description" content="<?php echo isset($description)?$description:''; ?>" />
    <meta name="keywords" content="<?php echo isset($keyword)?$keyword:''; ?>" />
    <meta name="author" content="www.<?php echo site_url(); ?>"/>
    <meta property="og:title" content="<?php echo isset($title)?$title:''; ?>"/>
    <meta property="og:url" content="<?php echo site_url(); ?>" />
    <meta property="og:image" content="<?php echo isset($image)?$image:''; ?>" />
    <link rel="alternate" href="<?php echo site_url(); ?>" hreflang="vi-vn" />
    <meta http-equiv="REFRESH" content="1800" />
    <meta name="geo.region" content="VN" />
    <meta name="geo.placename" content="Hồ Ch&iacute; Minh" />
    <meta name="geo.position" content="10.776435;106.601245" />
    <meta name="ICBM" content="10.776435, 106.601245" />
    <meta name="msvalidate.01" content="4A122E1D7BE2BEA01E640C985860E165" />

    <!-- Dublin Core-->
     <link rel="schema.DC" href="http://purl.org/dc/elements/1.1/">
     <meta name="DC.title" content="<?php echo isset($title)?$title:''; ?>">
     <meta name="DC.identifier" content="<?php echo site_url(); ?>">
     <meta name="DC.description" content="<?php echo isset($description)?$description:''; ?>">
     <meta name="DC.subject" content="<?php echo isset($keyword)?$keyword:''; ?>">
     <meta name="DC.language" scheme="UTF-8" content="vi">

    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="google-site-verification" content="U9ELRVzg8OYjIa5Xsas3MC_WQ-nsnggZ0mpKlgcIphM" />
    <title><?php echo isset($title)?$title:''; ?></title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link rel="stylesheet" href="public/css/style.css" type="text/css" />
    <link href="public/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="public/font-awesome-4.3.0/css/font-awesome.min.css" />
    <link href="public/bxslider/jquery.bxslider.css" rel="stylesheet" />
    
    <script src="public/bootstrap/js/jQuery-2.1.4.min.js"></script>
</head>

<body class="skin-blue sidebar-mini">
    <div class="wrapper">
        <header class="clearfix">
            <?php $this->load->view('frontend/layout/header'); ?>
        </header>
        <div class="clear"></div>
        <?php $this->load->view('frontend/layout/slider'); ?>
        <div id="content-wrapper" class="clearfix">
            <div class="col-md-8 content">
                <div class="row">
                <?php
                    if(isset($template) && !empty($template)){
                        $this->load->view($template, isset($data)?$data:NULL);
                    }
                ?>
                </div>
            </div>
            <div class="col-md-4 sidebar">
                <?php $this->load->view('frontend/layout/sidebar'); ?>
            </div>
        </div>
        <div class="clear"></div>
        <footer class="clearfix">
            <?php $this->load->view('frontend/layout/footer'); ?>
        </footer>
    </div>
    <script type="text/javascript" src="public/admin/js/moment-with-locales.js"></script>
    <script type="text/javascript" src="public/admin/js/bootstrap-datetimepicker.js"></script>
    <script type="text/javascript" src="public/admin/js/filereader.js"></script>
    <script src="public/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="public/bootstrap/js/app.min.js" type="text/javascript"></script>
    <script src="public/bxslider/jquery.bxslider.min.js"></script>
    
    <script src="public/js/script.js" type="text/javascript"></script>
</body>

</html>