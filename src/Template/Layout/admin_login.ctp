<!DOCTYPE html><html lang="en">
<head><style>#loading .svg-icon-loader {position: absolute;top: 50%;left: 50%;margin: -50px 0 0 -50px;}</style>
<meta charset="UTF-8">
<!--[if IE]><meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->
<title><?= 'Zensilo'; ?>: <?= $this->fetch('title').' | '. $this->request->params['action']; ?></title>
<meta name="description" content="">
<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="../../assets/images/icons/apple-touch-icon-144-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="../../assets/images/icons/apple-touch-icon-114-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="../../assets/images/icons/apple-touch-icon-72-precomposed.png">
<link rel="apple-touch-icon-precomposed" href="../../assets/images/icons/apple-touch-icon-57-precomposed.png">
<link rel="shortcut icon" href="../../assets/images/icons/favicon.png">

<?= $this->Html->css(array('../assets/helpers/animate', '../assets/helpers/boilerplate', '../assets/helpers/border-radius', '../assets/helpers/grid', '../assets/helpers/page-transitions', '../assets/helpers/spacing', '../assets/helpers/typography', '../assets/helpers/utils', '../assets/helpers/colors', '../assets/material/ripple', '../assets/elements/badges', '../assets/elements/buttons', '../assets/elements/content-box', '../assets/elements/dashboard-box', '../assets/elements/forms', '../assets/elements/images', '../assets/elements/info-box', '../assets/elements/invoice', '../assets/elements/loading-indicators', '../assets/elements/menus', '../assets/elements/panel-box', '../assets/elements/response-messages', '../assets/elements/responsive-tables', '../assets/elements/ribbon', '../assets/elements/social-box', '../assets/elements/tables', '../assets/elements/tile-box', '../assets/elements/timeline', '../assets/icons/fontawesome/fontawesome', '../assets/icons/linecons/linecons', '../assets/icons/spinnericon/spinnericon', '../assets/widgets/accordion-ui/accordion', '../assets/widgets/calendar/calendar', '../assets/widgets/carousel/carousel', '../assets/widgets/charts/justgage/justgage', '../assets/widgets/charts/justgage/justgage', '../assets/widgets/charts/morris/morris', '../assets/widgets/charts/piegage/piegage', '../assets/widgets/charts/xcharts/xcharts', '../assets/widgets/chosen/chosen', '../assets/widgets/colorpicker/colorpicker', '../assets/widgets/datatable/datatable', '../assets/widgets/datepicker/datepicker', '../assets/widgets/datepicker-ui/datepicker', '../assets/widgets/daterangepicker/daterangepicker' ,' ../assets/widgets/dialog/dialog', '../assets/widgets/dropdown/dropdown', '../assets/widgets/dropzone/dropzone', '../assets/widgets/file-input/fileinput', '../assets/widgets/input-switch/inputswitch', '../assets/widgets/input-switch/inputswitch-alt', '../assets/widgets/ionrangeslider/ionrangeslider', '../assets/widgets/jcrop/jcrop', '../assets/widgets/jgrowl-notifications/jgrowl', '../assets/widgets/loading-bar/loadingbar', '../assets/widgets/maps/vector-maps/vectormaps', '../assets/widgets/markdown/markdown', '../assets/widgets/modal/modal', '../assets/widgets/multi-select/multiselect', '../assets/widgets/multi-upload/fileupload', '../assets/widgets/nestable/nestable', '../assets/widgets/noty-notifications/noty', '../assets/widgets/popover/popover', '../assets/widgets/pretty-photo/prettyphoto', '../assets/widgets/progressbar/progressbar', '../assets/widgets/range-slider/rangeslider', '../assets/widgets/slidebars/slidebars', '../assets/widgets/slider-ui/slider', '../assets/widgets/summernote-wysiwyg/summernote-wysiwyg', '../assets/widgets/tabs-ui/tabs', '../assets/widgets/timepicker/timepicker', '../assets/widgets/tocify/tocify', '../assets/widgets/tooltip/tooltip', '../assets/widgets/touchspin/touchspin', '../assets/widgets/uniform/uniform', '../assets/widgets/wizard/wizard', '../assets/widgets/xeditable/xeditable', '../assets/snippets/chat', '../assets/snippets/files-box', '../assets/snippets/login-box', '../assets/snippets/notification-box', '../assets/snippets/progress-box', '../assets/snippets/todo', '../assets/snippets/user-profile', '../assets/snippets/mobile-navigation', '../assets/applications/mailbox', '../assets/themes/admin/layout', '../assets/themes/admin/color-schemes/default', '../assets/themes/components/default', '../assets/themes/components/border-radius', '../assets/helpers/responsive-elements', '../assets/helpers/admin-responsive'));?>

<?= $this->Html->script(array('../assets/js-core/jquery-core', '../assets/js-core/jquery-ui-core', '../assets/js-core/jquery-ui-widget', '../assets/js-core/jquery-ui-mouse', '../assets/js-core/jquery-ui-position', '../assets/js-core/transition', '../assets/js-core/modernizr', '../assets/js-core/jquery-cookie')) ?>
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
<body>
<div id="loading">
<div class="svg-icon-loader">
<img src="<?= $this->Url->build("/"); ?>img/bars.svg" width="40" alt="">
</div>
</div>
<style type="text/css">html,body {
        height: 100%;
        background: #fff;
        overflow: hidden;
    }
    </style>
    <script type="text/javascript" src="<?= $this->Url->build("/"); ?>assets/widgets/wow/wow.js"></script><script type="text/javascript">/* WOW animations */

    wow = new WOW({
        animateClass: 'animated',
        offset: 100
    });
    wow.init();
    </script>
    <img src="<?= $this->Url->build("/"); ?>assets/image-resources/blurred-bg/blurred-bg-3.jpg" class="login-img wow fadeIn" alt="">
    
    <?= $this->Flash->render() ?>
    <?= $this->fetch('content') ?>

    <?= $this->Html->script(array('../assets/widgets/dropdown/dropdown', '../assets/widgets/tooltip/tooltip', '../assets/widgets/popover/popover', '../assets/widgets/progressbar/progressbar', '../assets/widgets/button/button', '../assets/widgets/collapse/collapse', '../assets/widgets/superclick/superclick', '../assets/widgets/input-switch/inputswitch-alt', '../assets/widgets/slimscroll/slimscroll', '../assets/widgets/slimscroll/slimscroll', '../assets/widgets/slidebars/slidebars', '../assets/widgets/slidebars/slidebars-demo', '../assets/widgets/charts/piegage/piegage', '../assets/widgets/charts/piegage/piegage-demo', '../assets/widgets/screenfull/screenfull', '../assets/widgets/content-box/contentbox', '../assets/widgets/material/material', '../assets/widgets/material/ripples', '../assets/widgets/overlay/overlay', '../assets/js-init/widgets-init', '../assets/themes/admin/layout')) ?>
    
    </body>
<!-- Mirrored from agileui.com/demo/delight/demo/admin-template/login-4.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 22 Oct 2016 11:08:55 GMT -->
</html>