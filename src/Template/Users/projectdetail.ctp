<?= $this->Html->script(array('../assets/widgets/wizard/wizard', '../assets/widgets/wizard/wizard-demo', '../assets/widgets/tabs/tabs', '../assets/widgets/chosen/chosen', '../assets/widgets/chosen/chosen-demo','../assets/widgets/parsley/parsley','../assets/widgets/datepicker/datepicker','../assets/widgets/datepicker-ui/datepicker')) ?>

  
<div id="page-title" style="padding: 25px 35px;"><h2><?= $project->project_name ?>&nbsp;&nbsp; <span class="bs-label label-success"><?= $project->status ?></span></h2><p><br/><?= $project->description ?></p></div>
            
       <div class="panel">
       <div class="panel-body">
       <h3 class="title-hero">Project Summary</h3>
       <div class="example-box-wrapper">
       <div class="row">

        <div class="col-md-4"><a href="#" title="Example box" class="tile-box btn btn-default"><div class="tile-header">Estimated Start Date<div class="float-right"><i class="glyph-icon icon-caret-up"></i> </div></div><div class="tile-content-wrapper"><i class="glyph-icon icon-tachometer"></i><div class="tile-content"><?= $project->estimated_start_date ?></div><small><i class="glyph-icon icon-caret-up"></i> </small></div><div class="ripple-wrapper"></div></a></div>

        <div class="col-md-4"><a href="#" title="Example box" class="tile-box btn btn-default"><div class="tile-header">Estimated End Date<div class="float-right"><i class="glyph-icon icon-caret-up"></i> </div></div><div class="tile-content-wrapper"><i class="glyph-icon icon-tachometer"></i><div class="tile-content"><?= $project->estimated_end_date ?></div><small><i class="glyph-icon icon-caret-up"></i> </small></div><div class="ripple-wrapper"></div></a></div>

        <div class="col-md-4"><a href="#" title="Example box" class="tile-box btn btn-default"><div class="tile-header">Estimated Hours<div class="float-right"><i class="glyph-icon icon-caret-up"></i> </div></div><div class="tile-content-wrapper"><i class="glyph-icon icon-tachometer"></i><div class="tile-content"><?= $project->estimated_time ?></div><small><i class="glyph-icon icon-caret-up"></i> </small></div><div class="ripple-wrapper"></div></a></div>


        <br/>
        <div class="col-md-2"></div>
       <div class="col-md-2"><a href="#" title="Example tile shortcut" class="tile-box tile-box-alt btn-primary"><div class="tile-header">Tasks</div><div class="tile-content-wrapper"><div class="chart-alt-10 easyPieChart" data-percent="<?= $tasks; ?>" style="width: 100px; height: 100px; line-height: 100px;"><span><?= $tasks; ?></span><canvas width="100" height="100"></canvas></div></div></a></div>
       

       <div class="col-md-2"><a href="#" title="Example tile shortcut" class="tile-box tile-box-alt btn-black"><div class="tile-header">Team Members</div><div class="tile-content-wrapper"><div class="chart-alt-10 easyPieChart" data-percent="<?= $teams ?>" style="width: 100px; height: 100px; line-height: 100px;"><span><?php echo $teams; ?><?= $teams; ?></span><canvas width="100" height="100"></canvas></div></div></a></div>

       <div class="col-md-2"><a href="#" title="Example tile shortcut" class="tile-box tile-box-alt btn-danger"><div class="tile-header">Conversations</div><div class="tile-content-wrapper"><div class="chart-alt-10 easyPieChart" data-percent="55" style="width: 100px; height: 100px; line-height: 100px;"><span>54</span>%<canvas width="100" height="100"></canvas></div></div></a></div>

       <div class="col-md-2"><a href="#" title="Example tile shortcut" class="tile-box tile-box-alt btn-success"><div class="tile-header">Progress</div><div class="tile-content-wrapper"><div class="chart-alt-10 easyPieChart" data-percent="43" style="width: 100px; height: 100px; line-height: 100px;"><span>42</span>%<canvas width="100" height="100"></canvas></div></div></a></div>
       <div class="col-md-2"></div>
       
       </div>
       </div>
       </div>
       </div>

       <div class="panel">
       <div class="panel-body">
       <h3 class="title-hero">Project Timeline</h3>
       <div class="example-box-wrapper">
       <div class="row">
          <div class="example-box-wrapper">
          <div class="timeline-box">
          <?php foreach($project_timeline as $key=>$timeline) { ?>
          <div class="tl-row">
          <div class="tl-item <?php if($key % 2 != 0) { ?>float-right<?php } ?>">
          <div class="tl-icon <?php if($key % 2 != 0) { ?>bg-green<?php } else { ?>bg-black <?php } ?>"><i class="glyph-icon icon-cog"></i></div>
          <div class="tl-panel"><?= $timeline->timeline_date_time ?></div>
          <div class="popover <?php if($key % 2 != 0) { ?>right<?php } else { ?>left <?php } ?>">
          <div class="arrow"></div>
          <div class="popover-content">
          <div class="tl-label bs-label label-success"><?= $timeline->timeline_text ?></div>
          <p class="tl-content"><?= $timeline->timeline_description ?></p>
          <div class="tl-time"><i class="glyph-icon icon-clock-o"></i> a few seconds ago</div>
          </div>
          </div>
          </div>
          </div>
          <?php } ?>
          
          </div>
          </div>
       </div>
       </div>
       </div>
       </div>

       <div class="panel">
       <div class="panel-body">
       <h3 class="title-hero">Project Documents</h3>
       <div class="example-box-wrapper">
       <div class="row">
          <?php foreach($documents as $docs) { 
            if($docs->type == "png" || $docs->type == "jpg" || $docs->type == "jpeg" || $docs->type == "gif") {?>
          <div class="col-lg-2 col-md-4 col-sm-6">
          <div class="thumbnail-box">
          <div class="thumb-content">
          <div class="center-vertical">
          <div class="center-content">
          <div class="thumb-btn animated bounceInDown">
          <a href="#" class="btn btn-md btn-round btn-success" title="">
          <i class="glyph-icon icon-check"></i>
          </a> 
          <a href="#" class="btn btn-md btn-round btn-danger" title="">
          <i class="glyph-icon icon-remove"></i>
          </a>
          </div>
          </div>
          </div>
          </div>
          <div class="thumb-overlay bg-primary"></div>
          <img src="<?= $this->Url->build('/upload/project/'.$docs->document_name); ?>" alt="" class="thumb-doc"/>
          </div>
          </div>
          <?php } else { ?>
            <div class="col-lg-2 col-md-4 col-sm-6">
          <div class="thumbnail-box">
          <div class="thumb-content">
          <div class="center-vertical">
          <div class="center-content">
          <div class="thumb-btn animated rotateIn">
          <a href="<?= $this->Url->build('/upload/project/'.$docs->document_name); ?>" class="btn btn-lg btn-round btn-primary" title="<?= $docs->document_name ?>"><i class="glyph-icon icon-plus"></i></a>
          </div>
          </div>
          </div>
          </div>
          <div class="thumb-overlay bg-black"></div>
          <?php if($docs->type == "xls" || $docs->type == "xlsx") {?>
          <img src="../../assets/images/excel.png" alt="" class="thumb-doc"/>
          <?php }  else { ?>
            <img src="../../assets/images/doc.png" alt="" class="thumb-doc"/>
          <?php } ?>
          </div>
          </div>
           <?php  } } ?>
        


       </div>
       </div>
       </div>
       </div>

        

