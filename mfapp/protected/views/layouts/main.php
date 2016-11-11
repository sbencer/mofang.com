<!DOCTYPE html>
<!-- 
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.1.1
Version: 2.0.2
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <meta charset="utf-8"/>
    <title>後台工具</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta content="" name="description"/>
    <meta content="" name="author"/>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>
    <link href="<?php echo PLUGINS_PATH; ?>font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo PLUGINS_PATH; ?>bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo PLUGINS_PATH; ?>uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link href="<?php echo PLUGINS_PATH; ?>bootstrap-wysihtml5/bootstrap-wysihtml5.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo PLUGINS_PATH; ?>fancybox/source/jquery.fancybox.css" rel="stylesheet"/>
    <!-- BEGIN:File Upload Plugin CSS files-->
    <link href="<?php echo PLUGINS_PATH; ?>jquery-file-upload/blueimp-gallery/blueimp-gallery.min.css" rel="stylesheet"/>
    <link href="<?php echo PLUGINS_PATH; ?>jquery-file-upload/css/jquery.fileupload.css" rel="stylesheet"/>
    <link href="<?php echo PLUGINS_PATH; ?>jquery-file-upload/css/jquery.fileupload-ui.css" rel="stylesheet"/>
    <!-- END:File Upload Plugin CSS files-->
    <!-- END PAGE LEVEL STYLES -->
    <!-- BEGIN THEME STYLES -->
    <link href="<?php echo CSS_PATH; ?>style-metronic.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo CSS_PATH; ?>style.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo CSS_PATH; ?>style-responsive.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo CSS_PATH; ?>plugins.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo CSS_PATH; ?>themes/default.css" rel="stylesheet" type="text/css" id="style_color"/>
    <link href="<?php echo CSS_PATH; ?>pages/inbox.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo CSS_PATH; ?>custom.css" rel="stylesheet" type="text/css"/>
    <!-- END THEME STYLES -->
    <link rel="shortcut icon" href="favicon.ico"/>
</head>

<!-- END HEAD -->

<!-- BEGIN BODY -->
<body class="page-header-fixed <?php if (false) {echo 'page-sidebar-closed';} ?>">
    <!-- BEGIN HEADER -->
    <div class="header navbar navbar-fixed-top">
        <!-- BEGIN TOP NAVIGATION BAR -->
        <div class="header-inner">
            <!-- BEGIN LOGO -->
            <a class="navbar-brand" href="index.html">
                <img src="<?php echo IMG_PATH; ?>logo.png" alt="logo" class="img-responsive"/>
            </a>
            <!-- END LOGO -->
            <!-- BEGIN RESPONSIVE MENU TOGGLER -->
            <a href="javascript:;" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <img src="<?php echo IMG_PATH; ?>menu-toggler.png" alt=""/>
            </a>
            <!-- END RESPONSIVE MENU TOGGLER -->
            <!-- BEGIN TOP NAVIGATION MENU -->
            <ul class="nav navbar-nav pull-right">
                <!-- BEGIN USER LOGIN DROPDOWN -->
                <li class="dropdown user">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                        <img alt="" src="<?php echo IMG_PATH; ?>avatar1_small.jpg"/>
                        <span class="username">
                            Bob Nilson
                        </span>
                        <i class="fa fa-angle-down"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- <li> -->
                        <!--     <a href="extra_profile.html"> -->
                        <!--         <i class="fa fa&#45;user"></i> My Profile -->
                        <!--     </a> -->
                        <!-- </li> -->
                        <!-- <li> -->
                        <!--     <a href="page_calendar.html"> -->
                        <!--         <i class="fa fa&#45;calendar"></i> My Calendar -->
                        <!--     </a> -->
                        <!-- </li> -->
                        <!-- <li> -->
                        <!--     <a href="inbox.html"> -->
                        <!--         <i class="fa fa&#45;envelope"></i> My Inbox -->
                        <!--         <span class="badge badge&#45;danger"> -->
                        <!--              3 -->
                        <!--         </span> -->
                        <!--     </a> -->
                        <!-- </li> -->
                        <!-- <li> -->
                        <!--     <a href="#"> -->
                        <!--         <i class="fa fa&#45;tasks"></i> My Tasks -->
                        <!--         <span class="badge badge&#45;success"> -->
                        <!--              7 -->
                        <!--         </span> -->
                        <!--     </a> -->
                        <!-- </li> -->
                        <!-- <li class="divider"> -->
                        <!-- </li> -->
                        <li>
                            <a href="javascript:;" id="trigger_fullscreen">
                                <i class="fa fa-arrows"></i> Full Screen
                            </a>
                        </li>
                        <li>
                            <a href="extra_lock.html">
                                <i class="fa fa-lock"></i> Lock Screen
                            </a>
                        </li>
                        <li>
                            <a href="login.html">
                                <i class="fa fa-key"></i> Log Out
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- END USER LOGIN DROPDOWN -->
            </ul>
            <!-- END TOP NAVIGATION MENU -->
        </div>
        <!-- END TOP NAVIGATION BAR -->
    </div>
    <!-- END HEADER -->
    <div class="clearfix">
    </div>
    <div class="page-container">
        <!-- BEGIN SIDEBAR -->
        <div class="page-sidebar-wrapper">
            <div class="page-sidebar navbar-collapse collapse">
                <!-- BEGIN SIDEBAR MENU -->
                <ul class="page-sidebar-menu" data-auto-scroll="true" data-slide-speed="200">
                    <li class="sidebar-toggler-wrapper">
                        <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                        <div class="sidebar-toggler hidden-phone">
                        </div>
                        <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                    </li>
                    <li class="sidebar-search-wrapper">
                        <!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
                        <form class="sidebar-search" action="extra_search.html" method="POST">
                            <div class="form-container">
                                <div class="input-box">
                                    <a href="javascript:;" class="remove">
                                    </a>
                                    <input type="text" placeholder="Search..."/>
                                    <input type="button" class="submit" value=" "/>
                                </div>
                            </div>
                        </form>
                        <!-- END RESPONSIVE QUICK SEARCH FORM -->
                    </li>
                    <li class="start active ">
                        <a href="<?php echo SITE_URL; ?>index.php?r=houtai/tools/index">
                            <i class="fa fa-home"></i>
                            <span class="title">
                                遊戲助手管理
                            </span>
                            <span class="selected">
                            </span>
                        </a>
                    </li>
                    <li class="last ">
                        <a href="javascript:;">
                            <i class="fa fa-shopping-cart"></i>
                            <span class="title">
                                手機平台管理
                            </span>
                            <span class="arrow ">
                            </span>
                        </a>
                        <ul class="sub-menu">
                            <li>
                                <a href="<?php echo SITE_URL; ?>index.php?r=houtai/platform/index">
                                    <i class="fa fa-bullhorn"></i>
                                    蘋果
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo SITE_URL; ?>index.php?r=houtai/platform/index">
                                    <i class="fa fa-shopping-cart"></i>
                                    安卓
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <!-- END SIDEBAR MENU -->
            </div>
        </div>
        <!-- END SIDEBAR -->
        <!-- BEGIN CONTENT -->
        <div class="page-content-wrapper">
            <div class="page-content">
                <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
                <div class="modal fade" id="portlet-config" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <h4 class="modal-title">Modal title</h4>
                            </div>
                            <div class="modal-body">
                                 Widget settings form goes here
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn blue">Save changes</button>
                                <button type="button" class="btn default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <!-- /.modal -->
                <!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
                <!-- BEGIN STYLE CUSTOMIZER -->
                <div class="theme-panel hidden-xs hidden-sm">
                    <div class="toggler">
                    </div>
                    <div class="toggler-close">
                    </div>
                    <div class="theme-options">
                        <div class="theme-option theme-colors clearfix">
                            <span>
                                 THEME COLOR
                            </span>
                            <ul>
                                <li class="color-black current color-default" data-style="default">
                                </li>
                                <li class="color-blue" data-style="blue">
                                </li>
                                <li class="color-brown" data-style="brown">
                                </li>
                                <li class="color-purple" data-style="purple">
                                </li>
                                <li class="color-grey" data-style="grey">
                                </li>
                                <li class="color-white color-light" data-style="light">
                                </li>
                            </ul>
                        </div>
                        <div class="theme-option">
                            <span>
                                 Layout
                            </span>
                            <select class="layout-option form-control input-small">
                                <option value="fluid" selected="selected">Fluid</option>
                                <option value="boxed">Boxed</option>
                            </select>
                        </div>
                        <div class="theme-option">
                            <span>
                                 Header
                            </span>
                            <select class="header-option form-control input-small">
                                <option value="fixed" selected="selected">Fixed</option>
                                <option value="default">Default</option>
                            </select>
                        </div>
                        <div class="theme-option">
                            <span>
                                 Sidebar
                            </span>
                            <select class="sidebar-option form-control input-small">
                                <option value="fixed">Fixed</option>
                                <option value="default" selected="selected">Default</option>
                            </select>
                        </div>
                        <div class="theme-option">
                            <span>
                                 Sidebar Position
                            </span>
                            <select class="sidebar-pos-option form-control input-small">
                                <option value="left" selected="selected">Left</option>
                                <option value="right">Right</option>
                            </select>
                        </div>
                        <div class="theme-option">
                            <span>
                                 Footer
                            </span>
                            <select class="footer-option form-control input-small">
                                <option value="fixed">Fixed</option>
                                <option value="default" selected="selected">Default</option>
                            </select>
                        </div>
                    </div>
                </div>
                <!-- END STYLE CUSTOMIZER -->
                <!-- BEGIN CONTENT -->
                <?php echo $content; ?>
                <!-- END CONTENT -->
            </div>
        </div>
        <!-- END CONTENT -->
    </div>
    <!-- END CONTAINER -->
    <!-- END CONTENT -->
    <!-- BEGIN FOOTER -->
    <div class="footer">
        <div class="footer-inner">
             2014 &copy; Metronic by keenthemes.
        </div>
        <div class="footer-tools">
            <span class="go-top">
                <i class="fa fa-angle-up"></i>
            </span>
        </div>
    </div>
    <!-- END FOOTER -->
    <!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
    <!-- BEGIN CORE PLUGINS -->
    <!--[if lt IE 9]>
    <script src="<?php echo PLUGINS_PATH; ?>respond.min.js"></script>
    <script src="<?php echo PLUGINS_PATH; ?>excanvas.min.js"></script> 
    <![endif]-->
    <script src="<?php echo PLUGINS_PATH; ?>jquery-1.10.2.min.js" type="text/javascript"></script>
    <script src="<?php echo PLUGINS_PATH; ?>jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
    <script src="<?php echo PLUGINS_PATH; ?>bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="<?php echo PLUGINS_PATH; ?>bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
    <script src="<?php echo PLUGINS_PATH; ?>jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <script src="<?php echo PLUGINS_PATH; ?>jquery.blockui.min.js" type="text/javascript"></script>
    <script src="<?php echo PLUGINS_PATH; ?>jquery.cokie.min.js" type="text/javascript"></script>
    <script src="<?php echo PLUGINS_PATH; ?>uniform/jquery.uniform.min.js" type="text/javascript"></script>
    <!-- END CORE PLUGINS -->
    <!-- BEGIN: Page level plugins -->
    <script src="<?php echo PLUGINS_PATH; ?>fancybox/source/jquery.fancybox.pack.js" type="text/javascript"></script>
    <script src="<?php echo PLUGINS_PATH; ?>bootstrap-wysihtml5/wysihtml5-0.3.0.js" type="text/javascript"></script>
    <script src="<?php echo PLUGINS_PATH; ?>bootstrap-wysihtml5/bootstrap-wysihtml5.js" type="text/javascript"></script>
    <!-- BEGIN:File Upload Plugin JS files-->
    <!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
    <script src="<?php echo PLUGINS_PATH; ?>jquery-file-upload/js/vendor/jquery.ui.widget.js"></script>
    <!-- The Templates plugin is included to render the upload/download listings -->
    <script src="<?php echo PLUGINS_PATH; ?>jquery-file-upload/js/vendor/tmpl.min.js"></script>
    <!-- The Load Image plugin is included for the preview images and image resizing functionality -->
    <script src="<?php echo PLUGINS_PATH; ?>jquery-file-upload/js/vendor/load-image.min.js"></script>
    <!-- The Canvas to Blob plugin is included for image resizing functionality -->
    <script src="<?php echo PLUGINS_PATH; ?>jquery-file-upload/js/vendor/canvas-to-blob.min.js"></script>
    <!-- blueimp Gallery script -->
    <script src="<?php echo PLUGINS_PATH; ?>jquery-file-upload/blueimp-gallery/jquery.blueimp-gallery.min.js"></script>
    <!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
    <script src="<?php echo PLUGINS_PATH; ?>jquery-file-upload/js/jquery.iframe-transport.js"></script>
    <!-- The basic File Upload plugin -->
    <script src="<?php echo PLUGINS_PATH; ?>jquery-file-upload/js/jquery.fileupload.js"></script>
    <!-- The File Upload processing plugin -->
    <script src="<?php echo PLUGINS_PATH; ?>jquery-file-upload/js/jquery.fileupload-process.js"></script>
    <!-- The File Upload image preview & resize plugin -->
    <script src="<?php echo PLUGINS_PATH; ?>jquery-file-upload/js/jquery.fileupload-image.js"></script>
    <!-- The File Upload audio preview plugin -->
    <script src="<?php echo PLUGINS_PATH; ?>jquery-file-upload/js/jquery.fileupload-audio.js"></script>
    <!-- The File Upload video preview plugin -->
    <script src="<?php echo PLUGINS_PATH; ?>jquery-file-upload/js/jquery.fileupload-video.js"></script>
    <!-- The File Upload validation plugin -->
    <script src="<?php echo PLUGINS_PATH; ?>jquery-file-upload/js/jquery.fileupload-validate.js"></script>
    <!-- The File Upload user interface plugin -->
    <script src="<?php echo PLUGINS_PATH; ?>jquery-file-upload/js/jquery.fileupload-ui.js"></script>
    <!-- The main application script -->
    <!-- The XDomainRequest Transport is included for cross-domain file deletion for IE 8 and IE 9 -->
    <!--[if (gte IE 8)&(lt IE 10)]>
        <script src="<?php echo PLUGINS_PATH; ?>jquery-file-upload/js/cors/jquery.xdr-transport.js"></script>
        <![endif]-->
    <!-- END:File Upload Plugin JS files-->
    <!-- END: Page level plugins -->
    <script src="<?php echo JS_PATH; ?>core/app.js"></script>
    <script src="<?php echo JS_PATH; ?>custom/inbox.js"></script>
    <script>
    jQuery(document).ready(function() {       
       // initiate layout and plugins
       App.init();
       Inbox.init();
    });
    </script>
    <!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>
