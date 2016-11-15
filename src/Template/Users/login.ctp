<div class="center-vertical">
<div class="center-content">
<div class="col-md-6 center-margin">
<h3 class="text-center pad15B font-gray text-transform-upr font-size-23">Zensilo</h3>
<div class="content-box border-top border-red clearfix">
<div class="content-box-wrapper">
<form action="#" id="login-validation" class="col-md-7" method="POST">
<div id="login-form"><div class="pad20A">
<div class="form-group">
<label for="exampleInputEmail1">Username:</label>
<div class="input-group input-group-lg">
<span class="input-group-addon addon-inside bg-white font-primary"><i class="glyph-icon icon-envelope-o"></i></span> 
<input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter Username" name="username"></div>
</div>
<div class="form-group"><label for="exampleInputPassword1">Password:</label>
<div class="input-group input-group-lg"><span class="input-group-addon addon-inside bg-white font-primary"><i class="glyph-icon icon-unlock-alt"></i></span> 
<input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="password"></div>
</div>
<div class="row mrg15B">
<div class="checkbox-primary col-md-10" style="height: 20px"><label><input type="checkbox" id="loginCheckbox1" class="custom-checkbox"> Remember me</label></div></div><div class="form-group">
<button type="submit" class="btn btn-success btn-block btn-blue-alt">Login</button>
</div></div></div></form><div class="col-md-4 float-right" style="height: 287px"><div class="center-vertical"><div class="center-content"><a href="#" class="btn btn-block btn-md bg-facebook"><span class="glyph-icon icon-separator"><i class="glyph-icon icon-facebook"></i></span> <span class="button-content">Connect with Facebook</span></a><div class="mrg10A"></div><a href="#" class="btn btn-block btn-md bg-twitter"><span class="glyph-icon icon-separator"><i class="glyph-icon icon-twitter"></i></span> <span class="button-content">Connect with Twitter</span></a><div class="mrg10A"></div><a href="#" class="btn btn-block btn-md bg-google"><span class="glyph-icon icon-separator"><i class="glyph-icon icon-google-plus"></i></span> <span class="button-content">Connect with Google+</span></a></div></div></div></div></div></div></div></div>

<div class="center-vertical">
    <div class="center-content">
	    <div class="col-md-3 center-margin">
	    	<form method="post" action="#">
			    <div class="content-box wow bounceInDown modal-content">
				    <h3 class="content-box-header content-box-header-alt bg-default">
					    <span class="icon-separator"><i class="glyph-icon icon-cog"></i></span> 
					    <span class="header-wrapper">Admin <small>Login to your account.</small></span> 
					    <span class="header-buttons"><a href="<?= $this->Url->build(array("action" => "add"));?>" class="btn btn-sm btn-primary" title="">Sign Up</a></span>
				    </h3>
				    <div class="content-box-wrapper">
				    <div class="form-group">
				    <div class="input-group">
				    <input type="text" class="form-control" name="username" placeholder="Username"> 
				    <span class="input-group-addon bg-blue"><i class="glyph-icon icon-user"></i></span>
				    </div>
				    </div>
				    <div class="form-group">
				    <div class="input-group">
				    <input type="password" class="form-control" name="password" placeholder="Password"> 
				    <span class="input-group-addon bg-blue"><i class="glyph-icon icon-unlock-alt"></i></span>
				    </div>
				    </div>
				    <div class="form-group">
				    <a href="#" title="Recover password">Forgot Your Password?</a></div>
				    <button class="btn btn-success btn-block">Sign In</button>
				    </div>
			    </div>
		    </form>
	    </div>
    </div>
</div>