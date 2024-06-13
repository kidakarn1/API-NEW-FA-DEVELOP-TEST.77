<!doctype html>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title><?php echo $page_title; ?></title>
        <meta name="description" content="">
        <meta name="keywords" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <link rel="icon" href="favicon.ico" type="image/x-icon" />

        <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:300,400,600,700,800" rel="stylesheet">
        
        <link rel="stylesheet" href="<?php echo base_url() . $asset_url; ?>plugins/bootstrap/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo base_url() . $asset_url; ?>plugins/fontawesome-free/css/all.min.css">
        <link rel="stylesheet" href="<?php echo base_url() . $asset_url; ?>plugins/icon-kit/dist/css/iconkit.min.css">
        <link rel="stylesheet" href="<?php echo base_url() . $asset_url; ?>plugins/ionicons/dist/css/ionicons.min.css">
        <link rel="stylesheet" href="<?php echo base_url() . $asset_url; ?>plugins/perfect-scrollbar/css/perfect-scrollbar.css">
        <link rel="stylesheet" href="<?php echo base_url() . $asset_url; ?>plugins/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
                <link rel="stylesheet" href="<?php echo base_url() . $asset_url; ?>dist/css/theme.min.css">
        <!-- <link rel="stylesheet" href="<?php echo base_url() . $asset_url; ?>plugins/jvectormap/jquery-jvectormap.css"> -->
        <link rel="stylesheet" href="<?php echo base_url() . $asset_url; ?>plugins/tempusdominus-bootstrap-4/build/css/tempusdominus-bootstrap-4.min.css">
        <link rel="stylesheet" href="<?php echo base_url() . $asset_url; ?>plugins/weather-icons/css/weather-icons.min.css">
        <link rel="stylesheet" href="<?php echo base_url() . $asset_url; ?>plugins/c3/c3.min.css">
        <link rel="stylesheet" href="<?php echo base_url() . $asset_url; ?>plugins/owl.carousel/dist/assets/owl.carousel.min.css">
        <link rel="stylesheet" href="<?php echo base_url() . $asset_url; ?>plugins/owl.carousel/dist/assets/owl.theme.default.min.css">


        <script src="<?php echo base_url() . $asset_url; ?>src/js/vendor/modernizr-2.8.3.min.js"></script>
    </head>

    <body>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
     <div class="wrapper">   
        <?php echo $page_header;?>
        <?php echo $page_menu; ?>
        <div class="page-wrap">
            <div class="main-content">
                
                <?php echo $page_content; ?>
            </div>
        </div>
    </div>


        <script>window.jQuery || document.write('<script src="<?php echo base_url() . $asset_url; ?>src/js/vendor/jquery-3.3.1.min.js"><\/script>')</script>
        <script src="<?php echo base_url() . $asset_url; ?>plugins/popper.js/dist/umd/popper.min.js"></script>
        <script src="<?php echo base_url() . $asset_url; ?>plugins/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url() . $asset_url; ?>plugins/perfect-scrollbar/dist/perfect-scrollbar.min.js"></script>
        <script src="<?php echo base_url() . $asset_url; ?>plugins/screenfull/dist/screenfull.js"></script>
        <!-- <script src="<?php echo base_url() . $asset_url; ?>plugins/datatables.net/js/jquery.dataTables.min.js"></script> -->
        <!-- <script src="<?php echo base_url() . $asset_url; ?>plugins/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script> -->
        <!-- <script src="<?php echo base_url() . $asset_url; ?>plugins/datatables.net-responsive/js/dataTables.responsive.min.js"></script> -->
        <!-- <script src="<?php echo base_url() . $asset_url; ?>plugins/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script> -->
        <!-- <script src="<?php echo base_url() . $asset_url; ?>plugins/jvectormap/jquery-jvectormap.min.js"></script> -->
        <!-- <script src="<?php echo base_url() . $asset_url; ?>plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script> -->
        <script src="<?php echo base_url() . $asset_url; ?>plugins/moment/moment.js"></script>
        <script src="<?php echo base_url() . $asset_url; ?>plugins/tempusdominus-bootstrap-4/build/js/tempusdominus-bootstrap-4.min.js"></script>
        <script src="<?php echo base_url() . $asset_url; ?>plugins/d3/dist/d3.min.js"></script>
        <script src="<?php echo base_url() . $asset_url; ?>plugins/c3/c3.min.js"></script>
        <script src="<?php echo base_url() . $js_url; ?>tables.js"></script>
        <!-- <script src="<?php echo base_url() . $js_url; ?>widgets.js"></script> -->
        <script src="<?php echo base_url() . $js_url; ?>charts.js"></script>
        <script src="<?php echo base_url() . $asset_url; ?>plugins/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="<?php echo base_url() . $asset_url; ?>plugins/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
            <script src="<?php echo base_url() . $asset_url; ?>dist/js/theme.min.js"></script>
        <!-- <script src="<?php echo base_url() . $js_url; ?>form-advanced.js"></script> -->
        
        <!-- <script src="<?php echo base_url() . $js_url; ?>datatables.js"></script> -->

        <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
        <script>
            (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
            function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
            e=o.createElement(i);r=o.getElementsByTagName(i)[0];
            e.src='https://www.google-analytics.com/analytics.js';
            r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
            ga('create','UA-XXXXX-X','auto');ga('send','pageview');
        </script>
    </body>
    </html>