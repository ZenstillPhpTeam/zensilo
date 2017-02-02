<div class="panel">
  <div class="panel-body content-box">
    <h3 class="title-hero bg-primary">Defect</h3>
    <div class="example-box-wrapper">

    <div class="panel">
        <div class="panel-body">
        <h3 class="title-hero"> <button id="addclient" class="btn btn-alt btn-hover btn-primary0 float-right"  data-toggle="modal" data-target=".bs-example-modal-lg" ><span>Add New</span> <i class="glyph-icon icon-arrow-right"></i><div class="ripple-wrapper"></div></button></h3>
        <div class="row">
        <div class="fliter text-right">
        <form name="filterform" method="post">
        <label>Filter : </label>
        <select onchange="document.filterform.submit();" class="" name="filter[project_id]"  id="project_id_add" >
          <option value="">Project</option>
          <?php foreach($projects as $key => $value) { ?>
          <option <?= (isset($filter['project_id']) && $filter['project_id'] == $key) ? 'selected' : '';?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
          <?php } ?>
        </select>

        <select onchange="document.filterform.submit();" name="filter[priority]"  required>
          <option value="">Priority</option>
          <option <?= (isset($filter['priority']) && $filter['priority'] == "P1") ? 'selected' : '';?> value="P1">P1</option>
          <option <?= (isset($filter['priority']) && $filter['priority'] == "P2") ? 'selected' : '';?> value="P2">P2</option>
          <option <?= (isset($filter['priority']) && $filter['priority'] == "P3") ? 'selected' : '';?> value="P3">P3</option>
          <option <?= (isset($filter['priority']) && $filter['priority'] == "P4") ? 'selected' : '';?> value="P4">P4</option>
        </select>

        <select onchange="document.filterform.submit();" name="filter[severity]"  required>
          <option value="">Severity</option>
          <option <?= (isset($filter['severity']) && $filter['severity'] == "BLOCKER") ? 'selected' : '';?> value="BLOCKER">BLOCKER</option>
          <option <?= (isset($filter['severity']) && $filter['severity'] == "HIGH") ? 'selected' : '';?> value="HIGH">HIGH</option>
          <option <?= (isset($filter['severity']) && $filter['severity'] == "MEDIUM") ? 'selected' : '';?> value="MEDIUM">MEDIUM</option>
          <option <?= (isset($filter['severity']) && $filter['severity'] == "LOW") ? 'selected' : '';?> value="LOW">LOW</option>
        </select>

        <select onchange="document.filterform.submit();" name="filter[status]"  required>
          <option value="">Status</option>
          <option <?= (isset($filter['status']) && $filter['status'] == 1) ? 'selected' : '';?> value="1">New</option>
          <option <?= (isset($filter['status']) && $filter['status'] == 2) ? 'selected' : '';?> value="2">In Progress</option>
          <option <?= (isset($filter['status']) && $filter['status'] == 3) ? 'selected' : '';?> value="3">Ready To Test</option>
          <option <?= (isset($filter['status']) && $filter['status'] == 4) ? 'selected' : '';?> value="4">Completed</option>                      
        </select>

        <select onchange="document.filterform.submit();" name="filter[root_cause]"  required="">
          <option value="">Select Priority</option>
          <option <?= (isset($filter['root_cause']) && $filter['root_cause'] == "Requirements") ? 'selected' : '';?> value="Requirements">Requirements</option>
          <option <?= (isset($filter['root_cause']) && $filter['root_cause'] == "Design") ? 'selected' : '';?> value="Design">Design</option>
          <option <?= (isset($filter['root_cause']) && $filter['root_cause'] == "Coding") ? 'selected' : '';?> value="Coding">Coding</option>
          <option <?= (isset($filter['root_cause']) && $filter['root_cause'] == "Data") ? 'selected' : '';?> value="Data">Data</option>
          <option <?= (isset($filter['root_cause']) && $filter['root_cause'] == "Deployment") ? 'selected' : '';?> value="Deployment">Deployment</option>
          <option <?= (isset($filter['root_cause']) && $filter['root_cause'] == "Environment") ? 'selected' : '';?> value="Environment">Environment</option>    
        </select>
        </form>
        </div>
        <style>
        .project,.priority,.severity,.status,.create,.created,.rootcause{ position: relative; }
        .table-menu1 { width:120px; background: #ededed;  position: absolute; right: 450px; top:42px;  display: none; z-index: 1000;}
        .table-menu1 ul{ padding: 0px 10px;}
        .table-menu1 ul li{ list-style-type: none; padding: 5px 5px; border-bottom: 1px solid #cccccc;}
        .table-menu1 ul li:last-child{ border-bottom:none; }
        .table-menu1 ul li:hover{ background:#E91E63; color:#fff; }
        </style>
        <script>
        $(".project").click(function(){
           $(".table-menu1").toggle();
         });
        </script>
        </div>
        <?php $starr = [1=>'New', 2=>'In Progress', 3=>'Ready to Test', 4=>'Completed'];?>
        <div class="tasks-table table-responsive" style="overflow-x:auto;">
        <table class="table table-striped" >
        <tbody>
             <tr>
                <th>#</th>
                <th>Title</th>
                <th>Description</th>
                <th>Project/Task</th>
                <th>Priority</th>
                <th>Severity</th>
                <th>Status</th>
                <th>Assigned To</th>
                <th>Root Cause</th>
                <th>Actions</th>
             </tr>
            <?php foreach($defects as $k=>$res){?> 
             <tr>
                <td><?= $k+1;?></td>
                <td><?= $res->title;?></td>
                <td><?= $res->description;?></td>
                <td><?= $res->project_id ? $this->Custom->get_projectname($res->project_id) : '';?><?= $this->Custom->get_taskname($res->task_id) ? '/'.$this->Custom->get_taskname($res->task_id) : '';?></td>
                <td><?= $res->priority;?></td>
                <td><?= $res->severity;?></td>
                <td><?= $starr[$res->status];?></td>
                <td><?= $res->assigned_to ? $this->Custom->get_username($res->assigned_to) : '';?></td>
                <td><?= $res->root_cause;?></td>
                <td>
                  <a href="<?= $this->Url->build(array("action" => "defect", $res->id));?>"><i class="glyph-icon demo-icon tooltip-button icon-elusive-pencil" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"></i></a>&nbsp;&nbsp;
                  <a href="<?= $this->Url->build(array("action" => "defect", $res->id, "delete"));?>" onclick="return confirm('Are you sure want to delete this Project?')"><i class="glyph-icon demo-icon tooltip-button icon-elusive-trash" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"></i></a>
                  <!-- <a class="view_defect" data-defect='<?= json_encode($res)?>'><i class="glyph-icon demo-icon tooltip-button icon-elusive-slideshare" data-toggle="tooltip" data-placement="top" title="" data-original-title="View"></i></a> -->
                </td>
            </tr>
            <?php }?>
        </tbody>
        </table>
       
        </div>
        <style>
        .tasks-table{ position: relative; } 
        .tasks-table table tr th{font-weight: 600;}
      
        </style>
          
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form method="post" enctype="multipart/form-data" class="form-horizontal bordered-row" data-parsley-validate=""> 
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h4 class="modal-title">New Defects</h4>
        </div>
        <div class="modal-body">
          <div class="content-box-wrapper">

              <div class="row">
              <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="form-group">
                  <label class="col-sm-5 control-label">Title</label>
                  <div class="col-sm-7">
                    <input name="title" class="form-control" type="text" required="">
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-5 control-label">Description</label>
                  <div class="col-sm-7">
                     <textarea name="description" class="form-control"  required></textarea>
                  </div>
                </div>

                <div class="form-group" id="project_id_add_div">
                  <label class="col-sm-5 control-label">Project</label>
                  <div class="col-sm-7">
                    <select  class="form-control projectfield" name="project_id"  id="project_id_add" >
                      <option value="">Select Project</option>
                      <?php foreach($projects as $key => $value) { ?>
                      <option <?= ($action == 'add_project' && $id == $key) ? 'selected' : '';?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>

                <div class="form-group" id="project_id_add_div">
                  <label class="col-sm-5 control-label">Task</label>
                  <div class="col-sm-7">
                    <select  class="form-control taskfield" name="task_id"  id="project_id_add" >
                      <option value="">Select Task</option>
                      <?php foreach($tasks as $projectid => $value) { foreach($value as $key => $value) { ?>
                      <option style="display:none;" data-id="<?= $projectid;?>" <?= ($action == 'add_task' && $id == $key) ? 'selected' : '';?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
                      <?php }} ?>
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-5 control-label">Priority</label>
                  <div class="col-sm-7">
                    <select  class="form-control" name="priority"  required>
                      <option value="">Select Priority</option>
                      <option value="P1">P1</option>
                      <option value="P2">P2</option>
                      <option value="P3">P3</option>
                      <option value="P4">P4</option>
                    </select>
                  </div>
                </div>
                <div class="form-group .bordered-row">
                  <label class="col-sm-5 control-label">Severity</label>
                  <div class="col-sm-7">
                    <select  class="form-control" name="severity"  required>
                      <option value="">Select Priority</option>
                      <option value="BLOCKER">BLOCKER</option>
                      <option value="HIGH">HIGH</option>
                      <option value="MEDIUM">MEDIUM</option>
                      <option value="LOW">LOW</option>
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-5 control-label">Status</label>
                  <div class="col-sm-7">
                    <select  class="form-control" name="status"  required>
                      <option value="">Select Status</option>
                      <option selected="" value="1">New</option>
                      <option value="2">In Progress</option>
                      <option value="3">Ready To Test</option>
                      <option value="4">Completed</option>                      
                    </select>
                  </div>
                </div> 
                <div class="form-group">
                  <label class="col-sm-5 control-label">Release No.</label>
                  <div class="col-sm-7">
                    <input name="release_no" class="form-control" type="text" required>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-5 control-label">Requirement</label>
                  <div class="col-sm-7">
                    <textarea name="requirement" class="form-control"></textarea>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-5 control-label">Steps to Reproduce</label>
                  <div class="col-sm-7">
                    <textarea name="reproduce_steps" class="form-control" required></textarea>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-5 control-label">Document</label>
                  <div class="col-sm-7">
                    <input name="document" class="form-control" type="file">
                  </div>
                </div>

                </div>
                 <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="form-group">
                  <label class="col-sm-5 control-label">Assigned To</label>
                  <div class="col-sm-7">
                    <select name="assigned_to" class="form-control">
                      <option value="">Select User</option>
                      <?php foreach($company_users as $us){?>
                      <option value="<?= $us->id;?>"><?= $us->username;?></option>
                      <?php }?>
                    </select>
                  </div>
                </div>
                 
                  
                <div class="form-group">
                  <label class="col-sm-5 control-label">Environment</label>
                  <div class="col-sm-7">
                    <input name="environment" class="form-control" type="text" required="">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-5 control-label">Functional Category</label>
                  <div class="col-sm-7">
                    <input name="functional_category" class="form-control" type="text" required="">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-5 control-label">Root Cause</label>
                  <div class="col-sm-7">
                    <select  class="form-control" name="root_cause"  >
                      <option value="">Select Root Cause</option>
                      <option value="Requirements">Requirements</option>
                      <option value="Design">Design</option>
                      <option value="Coding">Coding</option>
                      <option value="Data">Data</option>
                      <option value="Deployment">Deployment</option>
                      <option value="Environment">Environment</option>
                    </select>
                  </div>
                </div>
                 <div class="form-group">
                  <label class="col-sm-5 control-label">Resolved On</label>
                  <div class="col-sm-7">
                    <input name="resolved_date" class="bootstrap-datepicker form-control" data-date-format="yyyy-mm-dd" type="text">
                  </div>
                </div>
                 <div class="form-group">
                  <label class="col-sm-5 control-label">Resolved By</label>
                  <div class="col-sm-7">
                    <select name="resolved_by" class="form-control">
                      <option value="">Select User</option>
                      <?php foreach($company_users as $us){?>
                      <option value="<?= $us->id;?>"><?= $us->username;?></option>
                      <?php }?>
                    </select>
                  </div>
                </div>
                 <div class="form-group">
                  <label class="col-sm-5 control-label">Closed On</label>
                  <div class="col-sm-7">
                    <input name="closed_date" class="bootstrap-datepicker form-control" data-date-format="yyyy-mm-dd" type="text">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-5 control-label">Closed By</label>
                  <div class="col-sm-7">
                    <select name="closed_by" class="form-control">
                      <option value="">Select User</option>
                      <?php foreach($company_users as $us){?>
                      <option value="<?= $us->id;?>"><?= $us->username;?></option>
                      <?php }?>
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-5 control-label">Os</label>
                  <div class="col-sm-7">
                    <input name="os" class="form-control" id="" type="text">
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-5 control-label">Browser</label>
                  <div class="col-sm-7">
                    <input name="browser" class="form-control" id="" type="text">
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-5 control-label">Additional Notes</label>
                  <div class="col-sm-7">
                    <textarea name="additional_notes" class="form-control"></textarea>
                  </div>
                </div>

                </div>



                </div>
                </div>
            </div>         
        
        <div class="modal-footer">
          <button type="button" class="btn btn-default " data-dismiss="modal">Close</button> 
          <button type="submit" class="btn btn-hover btn-primary">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>


<?php if(isset($defect)){?>
<script type="text/javascript">
  $(window).load(function(){
    $(".edit-modal-lg").modal("show");
  });
</script>
<div class="modal fade edit-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form method="post" enctype="multipart/form-data" class="form-horizontal bordered-row" data-parsley-validate=""> 
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h4 class="modal-title">Edit Defects</h4>
        </div>
        <div class="modal-body">
          <div class="content-box-wrapper">

              <div class="row">
              <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="form-group">
                  <label class="col-sm-5 control-label">Title</label>
                  <div class="col-sm-7">
                    <input name="title" class="form-control" type="text" value="<?= $defect->title;?>" required="">
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-5 control-label">Description</label>
                  <div class="col-sm-7">
                     <textarea name="description" class="form-control"  required><?= $defect->description;?></textarea>
                  </div>
                </div>

                <div class="form-group" id="project_id_add_div">
                  <label class="col-sm-5 control-label">Project</label>
                  <div class="col-sm-7">
                    <select  class="form-control projectfield" name="project_id"  id="project_id_add" >
                      <option value="">Select Project</option>
                      <?php foreach($projects as $key => $value) { ?>
                      <option <?= $defect->project_id == $key ? 'selected' : '';?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>

                <div class="form-group" id="project_id_add_div">
                  <label class="col-sm-5 control-label">Task</label>
                  <div class="col-sm-7">
                    <select  class="form-control taskfield" name="task_id"  id="project_id_add" >
                      <option value="">Select Task</option>
                      <?php foreach($tasks as $projectid => $value) { foreach($value as $key => $value) { ?>
                      <option style="display:none;" data-id="<?= $projectid;?>" <?= $defect->task_id == $key ? 'selected' : '';?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
                      <?php }} ?>
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-5 control-label">Priority</label>
                  <div class="col-sm-7">
                    <select  class="form-control" name="priority"  required>
                      <option value="">Select Priority</option>
                      <option <?= $defect->priority == "P1" ? 'selected' : '';?> value="P1">P1</option>
                      <option <?= $defect->priority == "P2" ? 'selected' : '';?> value="P2">P2</option>
                      <option <?= $defect->priority == "P3" ? 'selected' : '';?> value="P3">P3</option>
                      <option <?= $defect->priority == "P4" ? 'selected' : '';?> value="P4">P4</option>
                    </select>
                  </div>
                </div>
                <div class="form-group .bordered-row">
                  <label class="col-sm-5 control-label">Severity</label>
                  <div class="col-sm-7">
                    <select  class="form-control" name="severity"  required>
                      <option value="">Select Priority</option>
                      <option <?= $defect->severity == "BLOCKER" ? 'selected' : '';?> value="BLOCKER">BLOCKER</option>
                      <option <?= $defect->severity == "HIGH" ? 'selected' : '';?> value="HIGH">HIGH</option>
                      <option <?= $defect->severity == "MEDIUM" ? 'selected' : '';?> value="MEDIUM">MEDIUM</option>
                      <option <?= $defect->severity == "LOW" ? 'selected' : '';?> value="LOW">LOW</option>
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-5 control-label">Status</label>
                  <div class="col-sm-7">
                    <select  class="form-control dstatus" name="status"  required>
                      <option value="">Select Status</option>
                      <option <?= $defect->status == 1 ? 'selected' : '';?> value="1">New</option>
                      <option <?= $defect->status == 2 ? 'selected' : '';?> value="2">In Progress</option>
                      <option <?= $defect->status == 3 ? 'selected' : '';?> value="3">Ready To Test</option>
                      <option <?= $defect->status == 4 ? 'selected' : '';?> value="4">Completed</option>                      
                    </select>
                  </div>
                </div> 
                <div class="form-group">
                  <label class="col-sm-5 control-label">Release No.</label>
                  <div class="col-sm-7">
                    <input name="release_no" class="form-control" value="<?= $defect->release_no;?>" type="text" required>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-5 control-label">Requirement</label>
                  <div class="col-sm-7">
                    <textarea name="requirement" class="form-control"><?= $defect->requirement;?></textarea>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-5 control-label">Steps to Reproduce</label>
                  <div class="col-sm-7">
                    <textarea name="reproduce_steps" class="form-control" required><?= $defect->reproduce_steps;?></textarea>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-5 control-label">Document</label>
                  <div class="col-sm-7">
                    <input name="document" class="form-control" type="file">
                    <a target="blank" download href="<?= $defect->document;?>"><?= basename($defect->document);?></a> 
                  </div>
                </div>

                </div>
                 <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="form-group">
                  <label class="col-sm-5 control-label">Assigned To</label>
                  <div class="col-sm-7">
                    <select name="assigned_to" class="form-control">
                      <option value="">Select User</option>
                      <?php foreach($company_users as $us){?>
                      <option <?= $defect->assigned_to == $us->id ? 'selected' : '';?> value="<?= $us->id;?>"><?= $us->username;?></option>
                      <?php }?>
                    </select>
                  </div>
                </div>
                 
                  
                <div class="form-group">
                  <label class="col-sm-5 control-label">Environment</label>
                  <div class="col-sm-7">
                    <input name="environment" class="form-control" type="text" value="<?= $defect->environment;?>" required="">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-5 control-label">Functional Category</label>
                  <div class="col-sm-7">
                    <input name="functional_category" class="form-control" type="text" value="<?= $defect->functional_category;?>" required="">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-5 control-label">Root Cause</label>
                  <div class="col-sm-7">
                    <select  class="form-control mandatory1 mandatory2" name="root_cause" >
                      <option  value="">Select Root Cause</option>
                      <option <?= $defect->root_cause == "Requirements" ? 'selected' : '';?> value="Requirements">Requirements</option>
                      <option <?= $defect->root_cause == "Design" ? 'selected' : '';?> value="Design">Design</option>
                      <option <?= $defect->root_cause == "Coding" ? 'selected' : '';?> value="Coding">Coding</option>
                      <option <?= $defect->root_cause == "Data" ? 'selected' : '';?> value="Data">Data</option>
                      <option <?= $defect->root_cause == "Deployment" ? 'selected' : '';?> value="Deployment">Deployment</option>
                      <option <?= $defect->root_cause == "Environment" ? 'selected' : '';?> value="Environment">Environment</option>
                    </select>
                  </div>
                </div>
                 <div class="form-group">
                  <label class="col-sm-5 control-label">Resolved On</label>
                  <div class="col-sm-7">
                    <input name="resolved_date" class="bootstrap-datepicker form-control mandatory1 mandatory2" data-date-format="yyyy-mm-dd" type="text" value="<?= $this->Time->format($defect->resolved_date, 'Y-MM-dd');?>">
                  </div>
                </div>
                 <div class="form-group">
                  <label class="col-sm-5 control-label">Resolved By</label>
                  <div class="col-sm-7">
                    <select name="resolved_by" class="form-control mandatory1 mandatory2">
                      <option value="">Select User</option>
                      <?php foreach($company_users as $us){?>
                      <option <?= $defect->resolved_by == $us->id ? 'selected' : '';?> value="<?= $us->id;?>"><?= $us->username;?></option>
                      <?php }?>
                    </select>
                  </div>
                </div>
                 <div class="form-group">
                  <label class="col-sm-5 control-label">Closed On</label>
                  <div class="col-sm-7">
                    <input name="closed_date" class="bootstrap-datepicker form-control mandatory2" data-date-format="yyyy-mm-dd" type="text" value="<?= $this->Time->format($defect->closed_date, 'Y-MM-dd');?>">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-5 control-label">Closed By</label>
                  <div class="col-sm-7">
                    <select name="closed_by" class="form-control mandatory2">
                      <option value="">Select User</option>
                      <?php foreach($company_users as $us){?>
                      <option <?= $defect->closed_by == $us->id ? 'selected' : '';?> value="<?= $us->id;?>"><?= $us->username;?></option>
                      <?php }?>
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-5 control-label">Os</label>
                  <div class="col-sm-7">
                    <input name="os" class="form-control" id="" value="<?= $defect->os;?>" type="text">
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-5 control-label">Browser</label>
                  <div class="col-sm-7">
                    <input name="browser" class="form-control" value="<?= $defect->browser;?>" id="" type="text">
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-5 control-label">Additional Notes</label>
                  <div class="col-sm-7">
                    <textarea name="additional_notes" class="form-control"><?= $defect->additional_notes;?></textarea>
                  </div>
                </div>

                </div>



                </div>
                </div>
            </div>         
        
        <div class="modal-footer">
          <input type="hidden" name="id" value="<?= $defect->id ?>">
          <button type="button" class="btn btn-default " data-dismiss="modal">Close</button> 
          <button type="submit" class="btn btn-hover btn-primary">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php }?>
<script type="text/javascript">
  $(document).ready(function(){
    $(".projectfield").change(function(){
      $(this).parents("form").find(".taskfield option").hide();
      $(this).parents("form").find(".taskfield option[data-id="+$(this).val()+"]").show();
    });
    <?php if(isset($defect)){?>
    $(".edit-modal-lg .taskfield option[data-id=<?= $defect->project_id;?>]").show();

    <?php if($defect->status == 3){?>
      $(".mandatory1").attr("required", "required");
    <?php }elseif($defect->status == 4){?>
      $(".mandatory2").attr("required", "required");
    <?php }?>

    $(".edit-modal-lg .dstatus").change(function(){
      $(".mandatory1").removeAttr("required");
      $(".mandatory2").removeAttr("required");
      if($(this).val() == '3')
        $(".mandatory1").attr("required", "required");
      else if($(this).val() == '4')
        $(".mandatory2").attr("required", "required");
    });

    <?php }?>
    <?php if($action == 'add_task'){?>
    pd = $(".bs-example-modal-lg .taskfield option[value=<?= $id;?>]").data("id");
    $('.bs-example-modal-lg .projectfield').val(pd);
    $(".bs-example-modal-lg .taskfield option[data-id="+pd+"]").show();
    <?php }?>
  })
</script>