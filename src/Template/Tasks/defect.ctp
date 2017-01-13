        <div class="panel">
          <div class="panel-body content-box">
            <h3 class="title-hero bg-primary">Defect</h3>
            <div class="example-box-wrapper">

            <div class="panel">
        <div class="panel-body">
        <h3 class="title-hero"> <button id="addclient" class="btn btn-alt btn-hover btn-primary0 float-right"  data-toggle="modal" data-target=".bs-example-modal-lg" ><span>Add New</span> <i class="glyph-icon icon-arrow-right"></i><div class="ripple-wrapper"></div></button></h3>
        <div class="row">
        <div class="fliter">
        <ul>
        <li>Project</li>
        <li>Priority</li>
        <li>Severity</li>
        <li>Status</li>
        <li>Create On</li>
        <li>Created By</li>
        <li>Root Cause</li>
        </ul>
        </div>
        </div>
        <div class="tasks-table table-responsive" style="overflow-x:auto;">
        <table class="table table-striped" >
        <tbody>
             <tr>
                <th>Id</th>
                <th>Project</th>
                <th>Title</th>
                <th>Description</th>
                <th>Priority</th>
                <th>Severity</th>
                <th>Status</th>
                <th>Assigned To</th>
                <th>Created On</th>
                <th>Created By</th>
                <th>Root Cause</th>
                <th>Resolved On</th>
                <th>Resolved By</th>
                <th>Closed On</th>
                <th>Closed By</th>
             </tr>
             <tr>
                <td>Name</td>
                <td>Assigned To</td>
                <td>Start</td>
                <td>Due</td>
                <td>Estimation</td>
                <td>Status</td>
                <td>Name</td>
                <td>Assigned To</td>
                <td>Start</td>
                <td>Due</td>
                <td>Estimation</td>
                <td>Status</td>
                <td>Due</td>
                <td>Estimation</td>
                <td><i class="glyph-icon icon-cog setting"></i></td>
            </tr>
        </tbody>
        </table>
        <div class="table-menu">
        <ul>
            <li>Edit</li>
            <li>Delete</li>
            <li>Copy</li>
            <li>Create Subtask</li>
        </ul>
        </div>
        </div>
        <style>
        .tasks-table{ position: relative; } 
        .tasks-table table tr th{font-weight: 600;}
        .setting{ font-size: 16px; padding-left:14px; cursor: pointer;}
         .table-menu{ width:120px; background: #ededed;  position: absolute; right: 0; top:77px;  display: none;}
        .table-menu ul{ padding: 0px 10px;}
        .table-menu ul li{ list-style-type: none; padding: 5px 5px; border-bottom: 1px solid #cccccc;}
        .table-menu ul li:last-child{ border-bottom:none; }
        .table-menu ul li:hover{ background:#E91E63; color:#fff; }
        </style>
        <script>
        $(".setting").click(function(){
           $(".table-menu").toggle();
         });
        </script>       
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
          <h4 class="modal-title">New Task</h4>
        </div>
        <div class="modal-body">
          <div class="content-box-wrapper">

              <div class="row">
              <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="form-group">
                  <label class="col-sm-5 control-label">User id</label>
                  <div class="col-sm-7">
                    <input name="task_name" class="form-control" id="" placeholder="Task Name" type="text" required="" value="<?= isset($copy_task) ? $copy_task->task_name: ''?>">
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-5 control-label">Project</label>
                  <div class="col-sm-7">
                     <input name="estimated_effort" class="form-control" id="" placeholder="Estimated Effort"  required="" value="<?= isset($copy_task) ? $copy_task->estimated_effort: ''?>"/>
                  </div>
                </div>

                <div class="form-group" id="project_id_add_div">
                  <label class="col-sm-5 control-label">Title</label>
                  <div class="col-sm-7">
                    <select  class="form-control" name="project_id"  required="" id="project_id_add" >
                      <option value="">Select Project</option>
                    <?php foreach($projects as $key => $value) { ?>
                      <option value="<?php echo $value['id']; ?>" <?= isset($copy_task) ? $copy_task->project_id == $value['id'] ? 'selected' : '' : '';?> ><?php echo $value['project_name']; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-5 control-label">Description</label>
                  <div class="col-sm-7">
                  <textarea name="description" class="form-control" id="" placeholder="Description"  required=""><?= isset($copy_task) ? $copy_task->description: ''?></textarea>
                  </div>
                   
                </div>

                <div class="form-group">
                  <label class="col-sm-5 control-label">Priority</label>
                  <div class="col-sm-7">
                    <select  class="form-control" name="priority"  required="">
                      <option value="">Select Priority</option>
                      <option value="High" <?= isset($copy_task) ? $copy_task->priority == "High" ? 'selected' : '' : '';?>>High</option>
                      <option value="Low" <?= isset($copy_task) ? $copy_task->priority == "Low" ? 'selected' : '' : '';?>>Low</option>
                      <option value="Medium" <?= isset($copy_task) ? $copy_task->priority == "Medium" ? 'selected' : '' : '';?>>Medium</option>
                    </select>
                  </div>
                </div>
                <div class="form-group .bordered-row">
                  <label class="col-sm-5 control-label">Severity</label>
                  <div class="col-sm-7">
                    <select  class="form-control" name="priority"  required="">
                      <option value="">Select Priority</option>
                      <option value="High" <?= isset($copy_task) ? $copy_task->priority == "High" ? 'selected' : '' : '';?>>High</option>
                      <option value="Low" <?= isset($copy_task) ? $copy_task->priority == "Low" ? 'selected' : '' : '';?>>Low</option>
                      <option value="Medium" <?= isset($copy_task) ? $copy_task->priority == "Medium" ? 'selected' : '' : '';?>>Medium</option>
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-5 control-label">Status</label>
                  <div class="col-sm-7">
                    <select  class="form-control" name="status"  required="">
                      <option value="">Select Status</option>
                      <option value="New" <?= isset($copy_task) ? $copy_task->status == "New" ? 'selected' : '' : '';?>>New</option>
                      <option value="In Progress" <?= isset($copy_task) ? $copy_task->status == "In Progress" ? 'selected' : '' : '';?>>In Progress</option>
                      <option value="Ready To Test" <?= isset($copy_task) ? $copy_task->status == "Ready To Test" ? 'selected' : '' : '';?>>Ready To Test</option>
                      <option value="Completed" <?= isset($copy_task) ? $copy_task->status == "Completed" ? 'selected' : '' : '';?>>Completed</option>                      
                    </select>
                  </div>
                </div> 

                
                </div>
                 <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="form-group">
                  <label class="col-sm-5 control-label">Assigned To</label>
                  <div class="col-sm-7">
                    <input name="task_name" class="form-control" id="" placeholder="Task Name" type="text" required="" value="<?= isset($copy_task) ? $copy_task->task_name: ''?>">
                  </div>
                </div>
                 <div class="form-group">
                  <label class="col-sm-5 control-label">Created On</label>
                  <div class="col-sm-7">
                    <input name="task_name" class="form-control" id="" placeholder="Task Name" type="text" required="" value="<?= isset($copy_task) ? $copy_task->task_name: ''?>">
                  </div>
                </div>
                 <div class="form-group">
                  <label class="col-sm-5 control-label">Created By</label>
                  <div class="col-sm-7">
                    <input name="task_name" class="form-control" id="" placeholder="Task Name" type="text" required="" value="<?= isset($copy_task) ? $copy_task->task_name: ''?>">
                  </div>
                </div> <div class="form-group">
                  <label class="col-sm-5 control-label">Root Cause</label>
                  <div class="col-sm-7">
                    <select  class="form-control" name="priority"  required="">
                      <option value="">Select Priority</option>
                      <option value="High" <?= isset($copy_task) ? $copy_task->priority == "High" ? 'selected' : '' : '';?>>High</option>
                      <option value="Low" <?= isset($copy_task) ? $copy_task->priority == "Low" ? 'selected' : '' : '';?>>Low</option>
                      <option value="Medium" <?= isset($copy_task) ? $copy_task->priority == "Medium" ? 'selected' : '' : '';?>>Medium</option>
                    </select>
                  </div>
                </div>
                 <div class="form-group">
                  <label class="col-sm-5 control-label">Resolved On</label>
                  <div class="col-sm-7">
                    <input name="task_name" class="form-control" id="" placeholder="Task Name" type="text" required="" value="<?= isset($copy_task) ? $copy_task->task_name: ''?>">
                  </div>
                </div>
                 <div class="form-group">
                  <label class="col-sm-5 control-label">Resolved By</label>
                  <div class="col-sm-7">
                    <input name="task_name" class="form-control" id="" placeholder="Task Name" type="text" required="" value="<?= isset($copy_task) ? $copy_task->task_name: ''?>">
                  </div>
                </div>
                 <div class="form-group">
                  <label class="col-sm-5 control-label">Closed On</label>
                  <div class="col-sm-7">
                    <input name="task_name" class="form-control" id="" placeholder="Task Name" type="text" required="" value="<?= isset($copy_task) ? $copy_task->task_name: ''?>">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-5 control-label">Closed By</label>
                  <div class="col-sm-7">
                    <input name="task_name" class="form-control" id="" placeholder="Task Name" type="text" required="" value="<?= isset($copy_task) ? $copy_task->task_name: ''?>">
                  </div>
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






