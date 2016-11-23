<!DOCTYPE html><html lang="en">
<head><style>#loading .svg-icon-loader {position: absolute;top: 50%;left: 50%;margin: -50px 0 0 -50px;}</style>
<meta charset="UTF-8">
<!--[if IE]><meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->
<title><?= 'Zensilo'; ?>: <?= $this->fetch('title').' | '. $this->request->params['action']; ?></title>
<meta name="description" content="">
<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?= $this->Url->build("/"); ?>assets/images/icons/apple-touch-icon-144-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?= $this->Url->build("/"); ?>assets/images/icons/apple-touch-icon-114-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?= $this->Url->build("/"); ?>assets/images/icons/apple-touch-icon-72-precomposed.png">
<link rel="apple-touch-icon-precomposed" href="<?= $this->Url->build("/"); ?>assets/images/icons/apple-touch-icon-57-precomposed.png">
<link rel="shortcut icon" href="<?= $this->Url->build("/"); ?>assets/images/icons/favicon.png">

<?= $this->Html->css(array('../assets/helpers/animate', '../assets/helpers/boilerplate', '../assets/helpers/border-radius', '../assets/helpers/grid', '../assets/helpers/page-transitions', '../assets/helpers/spacing', '../assets/helpers/typography', '../assets/helpers/utils', '../assets/helpers/colors', '../assets/material/ripple', '../assets/elements/badges', '../assets/elements/buttons', '../assets/elements/content-box', '../assets/elements/dashboard-box', '../assets/elements/forms', '../assets/elements/images', '../assets/elements/info-box', '../assets/elements/invoice', '../assets/elements/loading-indicators', '../assets/elements/menus', '../assets/elements/panel-box', '../assets/elements/response-messages', '../assets/elements/responsive-tables', '../assets/elements/ribbon', '../assets/elements/social-box', '../assets/elements/tables', '../assets/elements/tile-box', '../assets/elements/timeline', '../assets/icons/fontawesome/fontawesome', '../assets/icons/linecons/linecons', '../assets/icons/spinnericon/spinnericon', '../assets/widgets/accordion-ui/accordion', '../assets/widgets/calendar/calendar', '../assets/widgets/carousel/carousel', '../assets/widgets/charts/justgage/justgage', '../assets/widgets/charts/justgage/justgage', '../assets/widgets/charts/morris/morris', '../assets/widgets/charts/piegage/piegage', '../assets/widgets/charts/xcharts/xcharts', '../assets/widgets/chosen/chosen', '../assets/widgets/colorpicker/colorpicker', '../assets/widgets/datatable/datatable', '../assets/widgets/datepicker/datepicker', '../assets/widgets/datepicker-ui/datepicker', '../assets/widgets/daterangepicker/daterangepicker' ,'../assets/widgets/dialog/dialog', '../assets/widgets/dropdown/dropdown', '../assets/widgets/dropzone/dropzone', '../assets/widgets/file-input/fileinput', '../assets/widgets/input-switch/inputswitch', '../assets/widgets/input-switch/inputswitch-alt', '../assets/widgets/ionrangeslider/ionrangeslider', '../assets/widgets/jcrop/jcrop', '../assets/widgets/jgrowl-notifications/jgrowl', '../assets/widgets/loading-bar/loadingbar', '../assets/widgets/maps/vector-maps/vectormaps', '../assets/widgets/markdown/markdown', '../assets/widgets/modal/modal', '../assets/widgets/multi-select/multiselect', '../assets/widgets/multi-upload/fileupload', '../assets/widgets/nestable/nestable', '../assets/widgets/noty-notifications/noty', '../assets/widgets/popover/popover', '../assets/widgets/pretty-photo/prettyphoto', '../assets/widgets/progressbar/progressbar', '../assets/widgets/range-slider/rangeslider', '../assets/widgets/slidebars/slidebars', '../assets/widgets/slider-ui/slider', '../assets/widgets/summernote-wysiwyg/summernote-wysiwyg', '../assets/widgets/tabs-ui/tabs', '../assets/widgets/timepicker/timepicker', '../assets/widgets/tocify/tocify', '../assets/widgets/tooltip/tooltip', '../assets/widgets/touchspin/touchspin', '../assets/widgets/uniform/uniform', '../assets/widgets/wizard/wizard', '../assets/widgets/xeditable/xeditable', '../assets/snippets/chat', '../assets/snippets/files-box', '../assets/snippets/login-box', '../assets/snippets/notification-box', '../assets/snippets/progress-box', '../assets/snippets/todo', '../assets/snippets/user-profile', '../assets/snippets/mobile-navigation', '../assets/applications/mailbox', '../assets/themes/admin/layout', '../assets/themes/admin/color-schemes/default', '../assets/themes/components/default', '../assets/themes/components/border-radius', '../assets/helpers/responsive-elements', '../assets/helpers/admin-responsive','../assets/icons/elusive/elusive', 'update', 'opentok-whiteboard'));?>

<?= $this->Html->script(array('../assets/js-core/jquery-core', '../assets/js-core/jquery-ui-core', '../assets/js-core/jquery-ui-widget', '../assets/js-core/jquery-ui-mouse', '../assets/js-core/jquery-ui-position', '../assets/js-core/transition', '../assets/js-core/modernizr', '../assets/js-core/jquery-cookie', '../assets/widgets/wizard/wizard', '../assets/widgets/wizard/wizard-demo', '../assets/widgets/tabs/tabs', '../assets/widgets/modal/modal', '../assets/widgets/chosen/chosen', '../assets/widgets/chosen/chosen-demo')) ?>
<?= $this->fetch('meta') ?>
<?= $this->fetch('css') ?>
<?= $this->fetch('script') ?>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.8/angular.min.js"></script>
<script src='https://cdn.firebase.com/js/client/2.2.1/firebase.js'></script>
<script type="text/javascript">
$(window).load(function(){
            setTimeout(function() {
                $('#loading').fadeOut( 400, "linear" );
            }, 300);
        });
</script>
</head>
<body class="closed-sidebar" ng-app="zensilo">
<div id="sb-site">

  <?= $this->element('slidebar_left');?>
  <?= $this->element('slidebar_right');?>
  
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
          <li><a href="<?= $this->Url->build(array("controller"=> "users","action" => "company"));?>" title="Company"><i class="glyph-icon icon-linecons-tv"></i> <span>Company</span></a></li>
          <li><a href="<?= $this->Url->build(array("controller"=> "users","action" => "projects"));?>" title="Projects Menu"><i class="glyph-icon icon-linecons-diamond"></i> <span>Projects</span></a>
              <div class="sidebar-submenu" style="display: block;">
              <ul>
              <li><a href="<?= $this->Url->build(array("controller"=> "users","action" => "projects"));?>" title="Projects"><span>Projects</span></a></li>
              <li><a href="<?= $this->Url->build(array("controller"=> "users","action" => "clients"));?>" title="Clients"><span>Clients</span></a></li>
              <li><a href="<?= $this->Url->build(array("controller"=> "users","action" => "teams"));?>" title="Teams"><span>Teams</span></a></li>
              <li><a href="icons.html" title="Icons"><span>Icons</span></a></li>
              <li><a href="nav-menus.html" title="Navigation menus"><span>Navigation menus</span></a></li>
              <li><a href="response-messages.html" title="Response messages"><span>Response messages</span></a></li>
              <li><a href="images.html" title="Images"><span>Images</span></a></li>
              </ul></div>
          </li>
          <li><a href="<?= $this->Url->build(array("controller"=> "tasks","action" => "tasks"));?>" title="Add Tasks"><i class="glyph-icon icon-elusive-group"></i> <span>Tasks</span></a></li>

          <li><a href="<?= $this->Url->build(array("controller"=> "users","action" => "users"));?>" title="Add Users"><i class="glyph-icon icon-elusive-group"></i> <span>Users</span></a></li>

          <!-- elango menus -->
          <li><a href="<?= $this->Url->build(array("action" => "response"));?>" title="Leave Requests">
          <i class="glyph-icon icon-linecons-tv">
          <i class="bs-badge badge-warning"><?=  $this->Custom->get_leave_equest_count();?></i></i> 
          <span>Leave Requests</span></a></li>

          <li><a href="<?= $this->Url->build(array("action" => "request"));?>" title="Leave Requests">
          <i class="glyph-icon icon-linecons-tv"></i> <span>My Leave Requests</span></a></li>

          <!-- elango menus end -->

          <li><a href="#" title="Projects Menu"><i class="glyph-icon icon-linecons-diamond"></i> <span>Setting</span></a>
              <div class="sidebar-submenu" style="display: block;">
              <ul>
              <li><a href="<?= $this->Url->build(array("controller"=> "company", "action" => "designation"));?>" title="Projects"><span>Designation</span></a></li>
              <li><a href="<?= $this->Url->build(array("controller"=> "company","action" => "leavetypes"));?>" title="Clients"><span>Leave Types</span></a></li>
              <li><a href="<?= $this->Url->build(array("action" => "teams"));?>" title="Teams"><span>Teams</span></a></li>
              </ul>
              </div>
          </li>
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
            <a id="chatbox-btn" class="hdr-btn sb-toggle-left" href="#" title="Chat sidebar">
              <i class="glyph-icon icon-linecons-paper-plane"></i>
            </a>
          </div>
        </div>
        
        <?= $this->Flash->render() ?>
        <?= $this->fetch('content') ?>
      </div>
    </div>
  </div>
  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/paper.js/0.9.25/paper-core.min.js" type="text/javascript" charset="utf-8"></script>
  <script src="//static.opentok.com/v2/js/opentok.js" type="text/javascript" charset="utf-8"></script>

  <?= $this->Html->script(array('../assets/widgets/dropdown/dropdown', '../assets/widgets/tooltip/tooltip', '../assets/widgets/popover/popover', '../assets/widgets/progressbar/progressbar', '../assets/widgets/button/button', '../assets/widgets/collapse/collapse', '../assets/widgets/superclick/superclick', '../assets/widgets/input-switch/inputswitch-alt', '../assets/widgets/slimscroll/slimscroll', '../assets/widgets/slimscroll/slimscroll', '../assets/widgets/slidebars/slidebars', '../assets/widgets/slidebars/slidebars-demo', '../assets/widgets/charts/piegage/piegage', '../assets/widgets/charts/piegage/piegage-demo', '../assets/widgets/screenfull/screenfull', '../assets/widgets/content-box/contentbox', '../assets/widgets/material/material', '../assets/widgets/material/ripples', '../assets/widgets/overlay/overlay', '../assets/js-init/widgets-init', '../assets/themes/admin/layout','../assets/widgets/datatable/datatable','../assets/widgets/datatable/datatable-bootstrap','../assets/widgets/datatable/datatable-tabletools','../assets/widgets/parsley/parsley','../assets/widgets/multi-select/multiselect', '../assets/widgets/wizard/wizard', '../assets/widgets/wizard/wizard-demo', '../assets/widgets/tabs/tabs', '../assets/widgets/chosen/chosen', '../assets/widgets/chosen/chosen-demo','../assets/widgets/parsley/parsley','../assets/widgets/datepicker/datepicker','../assets/widgets/datepicker-ui/datepicker','../assets/widgets/interactions-ui/resizable','../assets/widgets/interactions-ui/draggable','../assets/widgets/interactions-ui/sortable', 'opentok-layout', 'opentok-angular', 'opentok-whiteboard')) ?>
  
  <script type="text/javascript">
    <?= $this->element('text_video_chat_script');?>
  </script>
     
  <script>
     $(document).ready(function() {
        $('#datatable-example').dataTable();

        $('.bootstrap-datepicker').bsdatepicker({
            format: 'yyyy-mm-dd'
        });
        $('.bootstrap-datepicker1').bsdatepicker({
            format: 'yyyy-mm-dd'
        });

        $('.bootstrap-datepicker2').bsdatepicker({
            format: 'yyyy-mm-dd'
        });

        $(".multi-select").multiSelect();
        $(".ms-container").append('<i class="glyph-icon icon-exchange"></i>');

         $(".todo-sort").sortable({
            handle: ".sort-handle"
        });
    });

  </script>
  </div>
</body>
<!-- Mirrored from agileui.com/demo/delight/demo/admin-template/forms-wizard.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 22 Oct 2016 11:08:31 GMT -->
</html>