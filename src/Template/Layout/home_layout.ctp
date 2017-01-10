<!DOCTYPE html>
<html lang="en-us" ng-app="postApp" ><head>
<meta charset="utf-8">
<!--<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">-->

<title><?= 'Zensilo'; ?>: <?= $this->fetch('title').' | '. $this->request->params['action']; ?></title>
<meta name="description" content="">
<meta name="author" content="">
<meta charset="UTF-8" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

<!-- CSS -->
<?= $this->Html->css(array('bootstrap', 'style', '../assets/helpers/utils', '../assets/icons/fontawesome/fontawesome', '../assets/helpers/colors', '../assets/elements/response-messages'));?>

<!-- FAVICONS -->
<link rel="shortcut icon" href="img/favicon/favicon.png" type="image/png">
<link rel="icon" href="img/favicon/favicon.png" type="image/png">

<?= $this->Html->script(array('jquery-1.10.2.min', 'bootstrap'));?>
<?= $this->fetch('meta') ?>
<?= $this->fetch('css') ?>
<?= $this->fetch('script') ?>

<script>
  javascript:window.history.forward(1);
  $(window).load(function(){
    $("#email,#pwd,#company_name").val("");
  });
  $(document).ready(function(){
    $(".getting_started").click(function(e){
      $("body").toggleClass('show_company_creation_container');
    });

    $(".login_started").click(function(e){
      $("body").toggleClass('show_company_login_container');
    });
    
    $(".toggle_link").click(function(){
      $(".reset_pwd").slideToggle();
      $(".l_pwd").slideToggle();
    });
    $(".hide_text").hide();
    $("#less").hide();
    
      $("#more").click(function(){
      $(".hide_text").toggle();
      $("#more").hide();
      $("#less").show();
      });
    $("#less").click(function(){
      $(".hide_text").toggle();
      $("#less").hide();
      $("#more").show();
    
      });
    $(".get_zen").hide();
    $("#get_zen_less").hide();
      $("#get_zen_more").click(function(){
      $(".get_zen").toggle();
      $("#get_zen_more").hide();
      $("#get_zen_less").show();
      });
    $("#get_zen_less").click(function(){
      $(".get_zen").toggle();
      $("#get_zen_less").hide();
      $("#get_zen_more").show();
    });

    function validateEmail(email) {
        var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
    }

    function validate()
    {
      $(".company_registration .form-control").each(function(){
        if($(this).val() && !$(this).hasClass("error_unique"))
          $(this).removeClass("error");
        else if(!$(this).val())
          $(this).addClass("error").removeClass("invalid_email").removeClass("error_unique");
        else
          $(this).addClass("error")
      });

      if($(".company_registration .form-control.error").length)
      {  
        $(".company_registration .btn-default").removeClass("all_data_filled");
        $(".company_registration").attr('onsubmit', 'return false;');
      }
      else
      {  
        $(".company_registration .btn-default").addClass("all_data_filled");
        $(".company_registration").attr('onsubmit', '');
      }
    }

    $(".company_registration .form-control").bind('keyup change', function(e){
      validate();
    });

    $(".company_login .form-control").bind('keyup change', function(e){
      $(".company_login .form-control").each(function(){
        if($(this).val())
          $(this).removeClass("error");
        else
          $(this).addClass("error")
      });

      if($(".company_login .form-control.error").length)
      {  
        $(".company_login .btn-default").removeClass("all_data_filled");
        $(".company_login").attr('onsubmit', 'return false;');
      }
      else
      {  
        $(".company_login .btn-default").addClass("all_data_filled");
        $(".company_login").attr('onsubmit', '');
      }
    });

    $("#company_name").keyup(function(){
      $this = $(this); 
      $this.addClass("error");
      $.get("<?= $this->Url->build(["controller" => "ajax", "action" => "checkUniqueData"]); ?>/username/"+$(this).val(), function(res){
          if(res == "0")
            $this.removeClass("error_unique");
          else
            $this.addClass("error_unique");
          validate();
      });
    });

    $("#email").keyup(function(){
      $this = $(this); 
      $this.addClass("error").addClass("invalid_email");

      if(!validateEmail($(this).val()))
      {
        validate();
        return;
      } 

      $this.removeClass("invalid_email");

      $.get("<?= $this->Url->build(["controller" => "ajax", "action" => "checkUniqueData"]); ?>/email/"+$(this).val(), function(res){
        console.log(res);
          if(res == "0")
            $this.removeClass("error_unique");
          else
            $this.addClass("error_unique");
          validate();
      });
    });
  });
</script>

</head>
<body class="<?= strtolower($this->request->params['controller']).'_'.strtolower($this->request->params['action']); ?>">
<header>
  <div class="container" id="container">
    <div class="row">
      <div class="header_top">
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
          <div class="header_logo"> <img src="<?= $this->Url->build("/"); ?>img/logo.png" alt="Image" /> </div>
        </div>
        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
          <div class="mainmenu">
            <nav class="navbar">
              <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
              </div>
              <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                  <li><a href="<?= $this->Url->build(array("controller" => "home")); ?>">Home</a></li>
                  <li><a href="https://sway.com/ZJ89kOSbMDBL3cXC">Features</a></li>
                  <li><a href="<?= $this->Url->build(array("controller" => "home", "action" => "contact-us")); ?>">Contact Us</a></li>
                </ul>
              </div>
            </nav>
          </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 text-right">
          <div class="login">
            <ul class="list-inline">
              <!-- <li><select ng-model="selectedItem" ng-change="langauge_update()">
                 <option value="">Select language</option>
                  <option value="lang_english_text" selected="selected">English</option>
                  <option value="lang_tamil_text">தமிழ்</option>
                </select></li> -->
              <li><a href="#" class="login_started">login</a></li>
            </ul>
            <?php if($this->request->params['action'] == 'index'){?>
            <div class="login_form  text-left">
              <div class="l_pwd getting_started_signup">
                <img class="close_container getting_started" src="<?= $this->Url->build("/"); ?>img/icons/delete.png" alt="Image" />
                <h3>Enter your details</h3>
                <form onsubmit="return false;" autocomplete="off" role="form" method="post" class="company_registration" novalidate="">
                  <div class="form-group" >
                    <label for="email">Company name:</label>
                    <input autocomplete="off" type="text" class="form-control" id="company_name" name="name">
                    <p class="error_text">Company name Already exist</p>
                  </div>
                  <div class="form-group" >
                    <label for="email">Email address:</label>
                    <input autocomplete="off" type="email" class="form-control" id="email" name="email">
                    <p class="error_text">Email Already exist</p>
                    <p class="error_text_email">Invalid Email</p>
                  </div>
                  <div class="form-group">
                    <label for="pwd">Password:</label>
                    <input autocomplete="off" type="password" class="form-control" id="pwd" name="password">
                  </div>
                  <div class="form-group">
                    <label for="pwd">By clicking 'Create account', you agree to the <a href="<?= $this->Url->build(array("controller" => "home", "action" => "tnc")); ?>">Terms of Service</a> and <a href="<?= $this->Url->build(array("controller" => "home", "action" => "privacy")); ?>">Privacy Policy</a>.</label>
                    </div>
                  <button type="submit" class="btn btn-default">Create Account</button>
                </form>
              </div>

              <div class="l_pwd getting_started_signin">
                <img class="close_container login_started" src="<?= $this->Url->build("/"); ?>img/icons/delete.png" alt="Image" />
                <h3>Enter your details</h3>
                <form onsubmit="return false;" action="<?= $this->Url->build(["controller" => "users", "action" => "index"]);?>" autocomplete="off" role="form" method="post" class="company_login" novalidate="">
                  <div class="form-group" >
                    <label for="email">User id:</label>
                    <input autocomplete="off" type="email" class="form-control" name="username">
                  </div>
                  <div class="form-group">
                    <label for="pwd">Password:</label>
                    <input autocomplete="off" type="password" class="form-control" name="password">
                  </div>
                  <style>
                  .forgot a{ font-style:italic; color:#E7505A !important;}
                  </style>
                  <div class="form-group">
                    <label for="pwd" class="forgot"><a href="<?= $this->Url->build(array("controller"=> "users", "action" => "forgotPassword"));?>">Forgot Password</a></label>
                  </div>
                  <button type="submit" class="btn btn-default">Login</button>
                </form>
              </div>
            </div>
            <?php }?>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
  </div>
</header>
<?= $this->Flash->render() ?>
<?= $this->fetch('content') ?>
<footer>
  <div class="container">
    <div class="footer_content">
      <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <div class="footer_content1"> <a href="#">© 2016,<span>Zenstill Analytics Pvt.Ltd</span> All Rights Reserved.</a> </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <div class="footer_content2">
            <ul class="list-inline">
              <li><a href="#"><img src="<?= $this->Url->build("/"); ?>img/icons/facebook.png" /></a></li>
              <li><a href="#"><img src="<?= $this->Url->build("/"); ?>img/icons/twitter.png" /></a></li>
              <li><a href="#"><img src="<?= $this->Url->build("/"); ?>img/icons/google_plus.png" /></a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</footer>

</body>
</html>