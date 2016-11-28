<?php ?>
  <div class="panel">
    <div class="panel-body content-box">
      <h3 class="title-hero bg-primary">Time Sheet</h3>
      <div class="example-box-wrapper">
        <div class="panel" >
          <div class="panel-body">

            <h3 class="title-hero"> Time Sheet view  

              <span style=" margin-left: 33%;padding: 10px;" class="bs-label label-info"> 
      <?php echo date("d M Y", strtotime($result['weekdays'][0])); ?> to <?php echo date("d M Y", strtotime($result['weekdays'][6])); ?>
              </span>
              
              <div class="float-right" >

                <a class="btn btn-hover btn-primary" href="<?= $this->Url->build(array("action" => "lists"));?>"> Cancel</a>
                <?php if($result['status'] == 1) { ?>
                
                <a class="btn btn-hover btn-success" href="<?= $this->Url->build(array("action" => "view", $result['id'],'accept'));?>">Accept</a>
                
                <a class="btn btn-hover btn-danger" data-toggle="modal" data-target=".rejectModal" href="javascript;">Reject</a>
                <?php } elseif($result['status'] == 2) { ?>
                
                <a class="btn btn-hover btn-danger" data-toggle="modal" data-target=".rejectModal" href="javascript;">Reject</a>
                <?php } elseif($result['status'] == 3) { ?>
                
                <a class="btn btn-hover btn-success" href="<?= $this->Url->build(array("action" => "view", $result['id'] ,'accept'));?>">Accept</a>
                <?php } ?>
      
              </div>

            </h3>

            <div class="example-box-wrapper">
              <div class="profile-box content-box">
                <div class="content-box-header clearfix bg-green" style="font-size: 12px;font-weight: bold; padding: 6px !important;">
                  
                  <div class="row">
                    
                    <div class="col-md-2"> <span style="margin-left:10px;">Project</span> </div>
                    <div class="col-md-2"> <span style="margin-left:10px;">Task</span> </div>
                    <?php foreach($result['weekdays'] as $k => $res){ ?>
                    <div class="col-md-1"> <span> <?php echo date("D d", strtotime($res)); ?> </span> </div>
                    <?php } ?>
                    <div class="col-md-1"> <span>Total Hrs</span> </div>

                  </div>
                  

                </div>

                <div class="list-group">
                  <?php foreach($result['days'] as $k => $res){  ?>
                  <a style="border-bottom: 1px solid #4caf50;margin-top: 1px;" class="list-group-item">
                    <div class="row">
                      
                    <div class="col-md-2"> 
                      <span> <?php echo $res['project_name']; ?> </span> 
                    </div>

                    <div class="col-md-2"> 
                      <span> <?php echo $res['task_name']; ?> </span> 
                    </div>

                    <?php foreach($res['days_hrs'] as $k1 => $hrs){  ?>
                    <div class="col-md-1">
                     <span> <?php echo $hrs; ?> </span> 
                    </div>
                    <?php } ?>

                    <div class="col-md-1" style="text-align: center;"> 
                      <span> <?php echo $res['total_hrs']; ?> </span> 
                    </div>

                    </div>
                  </a> 
                  <?php } ?>
          
                 
                 
                </div>
              </div>
            </div>


            <div class="example-box-wrapper" style="margin-top: 100px;">
              <div class="content-box-header clearfix bg-green" style=" border-top-left-radius: 0px;border-top-right-radius: 0px; border-bottom-left-radius: 3px;border-bottom-right-radius: 3px;font-size: 12px;font-weight: bold; padding: 10px !important;">
                
              </div>
            </div>
           
          </div>
        </div>
      </div>
    </div>
  </div>
      
<div class="modal fade bs-edit-modal-lg rejectModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-contentss" style=" background-color: white;">
    
      <form method="post" class="form-horizontal bordered-row" data-parsley-validate=""> 
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h4 class="modal-title">Time Sheet Reject</h4>
        </div>
        <div class="modal-body">
          <div class="content-box-wrapper">

              <div class="row">

                <div class="form-group">
                  <label class="col-sm-3 control-label">Reason for reject</label>
                  <div class="col-sm-6">
                    <textarea name="reason" id="" class="form-control" required=""></textarea>
                  </div>
                </div>

              </div>

             <input type="hidden" name="fmaction" value="reject">
             <input type="hidden" name="id" value="<?= $result['id']; ?>">
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default " data-dismiss="modal">Close</button> 
          <button type="submit" class="btn btn-hover btn-primary">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>