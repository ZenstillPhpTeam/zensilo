<!DOCTYPE html><html lang="en">
<head><style>#loading .svg-icon-loader {position: absolute;top: 50%;left: 50%;margin: -50px 0 0 -50px;}</style>
<meta charset="UTF-8">
<!--[if IE]><meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->
<title><?= 'Zensilo'; ?>: <?= $this->fetch('title') ?></title>
<meta name="description" content=""> 
<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?= $this->Url->build("/"); ?>assets/images/icons/apple-touch-icon-144-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?= $this->Url->build("/"); ?>assets/images/icons/apple-touch-icon-114-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?= $this->Url->build("/"); ?>assets/images/icons/apple-touch-icon-72-precomposed.png">
<link rel="apple-touch-icon-precomposed" href="<?= $this->Url->build("/"); ?>assets/images/icons/apple-touch-icon-57-precomposed.png">
<link rel="shortcut icon" href="<?= $this->Url->build("/"); ?>assets/images/icons/favicon.png">

<?= $this->Html->css(array('../assets/helpers/animate', '../assets/helpers/boilerplate', '../assets/helpers/border-radius', '../assets/helpers/grid', '../assets/helpers/page-transitions', '../assets/helpers/spacing', '../assets/helpers/typography', '../assets/helpers/utils', '../assets/helpers/colors', '../assets/material/ripple', '../assets/elements/badges', '../assets/elements/buttons', '../assets/elements/content-box', '../assets/elements/dashboard-box', '../assets/elements/forms', '../assets/elements/images', '../assets/elements/info-box', '../assets/elements/invoice', '../assets/elements/loading-indicators', '../assets/elements/menus', '../assets/elements/panel-box', '../assets/elements/response-messages', '../assets/elements/responsive-tables', '../assets/elements/ribbon', '../assets/elements/social-box', '../assets/elements/tables', '../assets/elements/tile-box', '../assets/elements/timeline', '../assets/icons/fontawesome/fontawesome', '../assets/icons/linecons/linecons', '../assets/icons/spinnericon/spinnericon', '../assets/widgets/accordion-ui/accordion', '../assets/widgets/calendar/calendar', '../assets/widgets/carousel/carousel', '../assets/widgets/charts/justgage/justgage', '../assets/widgets/charts/justgage/justgage', '../assets/widgets/charts/morris/morris', '../assets/widgets/charts/piegage/piegage', '../assets/widgets/charts/xcharts/xcharts', '../assets/widgets/chosen/chosen', '../assets/widgets/colorpicker/colorpicker', '../assets/widgets/datatable/datatable', '../assets/widgets/datepicker/datepicker', '../assets/widgets/datepicker-ui/datepicker', '../assets/widgets/daterangepicker/daterangepicker' ,'../assets/widgets/dialog/dialog', '../assets/widgets/dropdown/dropdown', '../assets/widgets/dropzone/dropzone', '../assets/widgets/file-input/fileinput', '../assets/widgets/input-switch/inputswitch', '../assets/widgets/input-switch/inputswitch-alt', '../assets/widgets/ionrangeslider/ionrangeslider', '../assets/widgets/jcrop/jcrop', '../assets/widgets/jgrowl-notifications/jgrowl', '../assets/widgets/loading-bar/loadingbar', '../assets/widgets/maps/vector-maps/vectormaps', '../assets/widgets/markdown/markdown', '../assets/widgets/modal/modal', '../assets/widgets/multi-select/multiselect', '../assets/widgets/multi-upload/fileupload', '../assets/widgets/nestable/nestable', '../assets/widgets/noty-notifications/noty', '../assets/widgets/popover/popover', '../assets/widgets/pretty-photo/prettyphoto', '../assets/widgets/progressbar/progressbar', '../assets/widgets/range-slider/rangeslider', '../assets/widgets/slidebars/slidebars', '../assets/widgets/slider-ui/slider', '../assets/widgets/summernote-wysiwyg/summernote-wysiwyg', '../assets/widgets/tabs-ui/tabs', '../assets/widgets/timepicker/timepicker', '../assets/widgets/tocify/tocify', '../assets/widgets/tooltip/tooltip', '../assets/widgets/touchspin/touchspin', '../assets/widgets/uniform/uniform', '../assets/widgets/wizard/wizard', '../assets/widgets/xeditable/xeditable', '../assets/snippets/chat', '../assets/snippets/files-box', '../assets/snippets/login-box', '../assets/snippets/notification-box', '../assets/snippets/progress-box', '../assets/snippets/todo', '../assets/snippets/user-profile', '../assets/snippets/mobile-navigation', '../assets/applications/mailbox', '../assets/themes/admin/layout', '../assets/themes/admin/color-schemes/default', '../assets/themes/components/default', '../assets/themes/components/border-radius', '../assets/helpers/responsive-elements', '../assets/helpers/admin-responsive','../assets/icons/elusive/elusive'));?>

<?= $this->Html->script(array('../assets/js-core/jquery-core', '../assets/js-core/jquery-ui-core', '../assets/js-core/jquery-ui-widget', '../assets/js-core/jquery-ui-mouse', '../assets/js-core/jquery-ui-position', '../assets/js-core/transition', '../assets/js-core/modernizr', '../assets/js-core/jquery-cookie', '../assets/widgets/wizard/wizard', '../assets/widgets/wizard/wizard-demo', '../assets/widgets/tabs/tabs', '../assets/widgets/modal/modal', '../assets/widgets/chosen/chosen', '../assets/widgets/chosen/chosen-demo')) ?>
<?= $this->fetch('meta') ?>
<?= $this->fetch('css') ?>
<?= $this->fetch('script') ?>
<script type="text/javascript">
$(window).load(function(){
            setTimeout(function() {
                $('#loading').fadeOut( 400, "linear" );
            }, 300);
        });
</script>
</head>
<body class="closed-sidebar">
<div id="sb-site">
  <div id="loading">
    <div class="svg-icon-loader"><img src="https://agileui.com/demo/delight/assets/images/svg-loaders/bars.svg" width="40" alt=""></div>
  </div>
  <div id="page-wrapper">
    <div id="mobile-navigation">
      <button id="nav-toggle" class="collapsed" data-toggle="collapse" data-target="#page-sidebar"><span></span></button>
    </div>
    <div id="page-sidebar">
      <div id="header-logo" class="logo-bg">
      <a style="background: none;text-indent: 0;" class="logo-content-big" href="<?= $this->Url->build(array("action" => "dashboard"));?>" title="DelightUI">
      <h4>Zensilo</h4>
      <span>Admin panel</span></a> 
      <!--<a class="logo-content-small" href="<?= $this->Url->build(array("action" => "dashboard"));?>" title="DelightUI">
      <h2>Door & handle</h2>
      <span>Admin panel</span></a>--> 
      <a id="close-sidebar" href="#" title="Close sidebar"><i class="glyph-icon icon-outdent"></i></a></div>
      <div class="scroll-sidebar">
        <ul id="sidebar-menu">
          <li class="header"><span>Overview</span></li>
          <li><a href="<?= $this->Url->build(array("action" => "company"));?>" title="Admin Dashboard"><i class="glyph-icon icon-linecons-tv"></i> <span>Company</span></a></li>
          <li><a href="<?= $this->Url->build(array("action" => "projects"));?>" title="Admin Dashboard"><i class="glyph-icon icon-linecons-diamond"></i> <span>Projects</span></a></li>
          <li><a href="<?= $this->Url->build(array("action" => "users"));?>" title="Add Users"><i class="glyph-icon icon-elusive-group"></i> <span>Users</span></a></li>
          <li><a href="<?= $this->Url->build(array("action" => "handles"));?>" title="Admin Dashboard"><i class="glyph-icon icon-linecons-tv"></i> <span>Handles</span></a></li>
          <li><a href="<?= $this->Url->build(array("action" => "category"));?>" title="Admin Dashboard"><i class="glyph-icon icon-linecons-tv"></i> <span>Category</span></a></li>
          <li><a href="<?= $this->Url->build(array("action" => "color"));?>" title="Admin Dashboard"><i class="glyph-icon icon-linecons-tv"></i> <span>Color</span></a></li>
          <li><a href="<?= $this->Url->build(array("action" => "tickets"));?>" title="Admin Dashboard"><i class="glyph-icon icon-linecons-tv"></i> <span>Tickets</span><span class="bs-badge badge-danger"><?=  $this->Custom->get_ticket_count();?></span></a></li>


          <!-- elango menus -->
          <li><a href="<?= $this->Url->build(array("action" => "response"));?>" title="Leave Requests">
          <i class="glyph-icon icon-linecons-tv">
          <i class="bs-badge badge-warning"><?=  $this->Custom->get_leave_equest_count();?></i></i> 
          <span>Leave Requests</span></a></li>

          <li><a href="<?= $this->Url->build(array("action" => "request"));?>" title="Leave Requests">
          <i class="glyph-icon icon-linecons-tv"></i> <span>My Leave Requests</span></a></li>

          <!-- elango menus end -->

        </ul>
      </div>
    </div>
    <div id="page-content-wrapper">
      <div id="page-content">
        <div id="page-header">
          <div id="header-nav-left">
            <div class="user-account-btn dropdown"><a href="#" title="My Account" class="user-profile clearfix" data-toggle="dropdown"><img width="28" src="<?= $this->Url->build("/"); ?>assets/image-resources/gravatar.jpg" alt="Profile image"> <span><?= $loggedInUser['username'];?></span> <i class="glyph-icon icon-angle-down"></i></a>
              <div class="dropdown-menu float-right">
                <div class="box-sm">
                  <div class="login-box clearfix">
                    <div class="user-img"><a href="#" title="" class="change-img">Change photo</a> <img src="<?= $this->Url->build("/"); ?>assets/image-resources/gravatar.jpg" alt=""></div>
                    <div class="user-info"><span>Michael Lee <i>UX/UI developer</i></span> <a href="#" title="Edit profile">Edit profile</a> <a href="#" title="View notifications">View notifications</a></div>
                  </div>
                  <div class="divider"></div>
                  
                  <div class="button-pane button-pane-alt pad5L pad5R text-center"><a href="<?= $this->Url->build(array("action" => "logout"));?>" class="btn btn-flat display-block font-normal btn-danger"><i class="glyph-icon icon-power-off"></i> Logout</a></div>
                </div>
              </div>
            </div>
          </div>
          <div id="header-nav-right"><a href="#" class="hdr-btn popover-button" title="Search" data-placement="bottom" data-id="#popover-search"><i class="glyph-icon icon-search"></i></a>
            <div class="hide" id="popover-search">
              <div class="pad5A box-md">
                <div class="input-group">
                  <input type="text" class="form-control" placeholder="Search terms here ...">
                  <span class="input-group-btn"><a class="btn btn-primary" href="#">Search</a></span></div>
              </div>
            </div>
            <a href="#" class="hdr-btn" id="fullscreen-btn" title="Fullscreen"><i class="glyph-icon icon-arrows-alt"></i></a>
            
          </div>
        </div>
        
        <?= $this->Flash->render() ?>
        <?= $this->fetch('content') ?>
      </div>
    </div>
  </div>
  
  <?= $this->Html->script(array('../assets/widgets/dropdown/dropdown', '../assets/widgets/tooltip/tooltip', '../assets/widgets/popover/popover', '../assets/widgets/progressbar/progressbar', '../assets/widgets/button/button', '../assets/widgets/collapse/collapse', '../assets/widgets/superclick/superclick', '../assets/widgets/input-switch/inputswitch-alt', '../assets/widgets/slimscroll/slimscroll', '../assets/widgets/slimscroll/slimscroll', '../assets/widgets/slidebars/slidebars', '../assets/widgets/slidebars/slidebars-demo', '../assets/widgets/charts/piegage/piegage', '../assets/widgets/charts/piegage/piegage-demo', '../assets/widgets/screenfull/screenfull', '../assets/widgets/content-box/contentbox', '../assets/widgets/material/material', '../assets/widgets/material/ripples', '../assets/widgets/overlay/overlay', '../assets/js-init/widgets-init', '../assets/themes/admin/layout','../assets/widgets/datatable/datatable','../assets/widgets/datatable/datatable-bootstrap','../assets/widgets/datatable/datatable-tabletools','../assets/widgets/parsley/parsley')) ?>

        
  <script>
   $(document).ready(function() {
        $('#datatable-example').dataTable();

        $('.bootstrap-datepicker').bsdatepicker({
            format: 'yyyy-mm-dd'
        });
        $('.bootstrap-datepicker1').bsdatepicker({
            format: 'yyyy-mm-dd'
        });
    });

  </script>
  </div>
</body>
<!-- Mirrored from agileui.com/demo/delight/demo/admin-template/forms-wizard.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 22 Oct 2016 11:08:31 GMT -->
</html>