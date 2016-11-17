<?= $this->Html->script(array('../assets/widgets/wizard/wizard', '../assets/widgets/wizard/wizard-demo', '../assets/widgets/tabs/tabs')) ?>
<div class="center-vertical">
    <div class="center-content">
	    <div class="col-md-5 center-margin">
	    	<form method="post" action="#">
			    <div class="content-box wow bounceInDown modal-content">
				    <h3 class="content-box-header content-box-header-alt bg-default">
					    <span class="icon-separator"><i class="glyph-icon icon-cog"></i></span> 
					    <span class="header-wrapper">Admin <small>Register here.</small></span> 
					    <span class="header-buttons"><a href="<?= $this->Url->build(array("action" => "login"));?>" class="btn btn-sm btn-primary" title="">Sign In</a></span>
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
					    	<div class="input-group">
					    		<input type="text" class="form-control" name="email"  placeholder="Email"> 
					    		<span class="input-group-addon bg-blue"><i class="glyph-icon icon-envelope-o"></i></span>
					    	</div>
					    </div>
					    <div class="form-group">
					    	<div class="input-group">
					    		<input type="text" class="form-control" name="mobile" placeholder="Mobile"> 
					    		<span class="input-group-addon bg-blue"><i class="glyph-icon icon-phone"></i></span>
					    	</div>
					    </div>
					    <div class="form-group">
					    	<a href="#" title="Recover password">Forgot Your Password?</a>
					    </div>
					    <button class="btn btn-success btn-block">Sign Up</button>
					</div>
			    </div>
		    </form>
	    </div>
    </div>
</div>