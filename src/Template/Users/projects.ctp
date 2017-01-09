        <div class="panel">
          <div class="panel-body content-box">
            <h3 class="title-hero bg-primary">Projects</h3>
            <div class="example-box-wrapper">

            <div class="panel">
        <div class="panel-body">
        <h3 class="title-hero">Projects List <button class="btn btn-alt btn-hover btn-primary float-right"  data-toggle="modal" data-target=".bs-example-modal-lg"><span>Add New</span> <i class="glyph-icon icon-arrow-right"></i><div class="ripple-wrapper"></div></button></h3>

        <div class="example-box-wrapper">
        <div id="datatable-example_wrapper" class="dataTables_wrapper form-inline no-footer">
        <div class="row">
        <div class="col-sm-6">
        <div class="dataTables_length" id="datatable-example_length">
        <label>
        
        </label>
        </div>
        </div>
        <div class="col-sm-6">
        <div id="datatable-example_filter" class="dataTables_filter">
        <label>
        
        </label>
        </div>
        </div>
        </div>
        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered dataTable no-footer" id="datatable-example" role="grid" aria-describedby="datatable-example_info">
        <thead>
        <tr role="row">
        <th class="sorting_asc" tabindex="0" aria-controls="datatable-example" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending" aria-sort="ascending">
        #
        </th>
        <th class="sorting_asc" tabindex="0" aria-controls="datatable-example" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending" style="width: 201px;" aria-sort="ascending">
        Project Name
        </th>
        <th class="sorting" tabindex="0" aria-controls="datatable-example" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 258px;">Description</th>
        <th class="sorting" tabindex="0" aria-controls="datatable-example" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending" >Hours</th>
        <th class="sorting" tabindex="0" aria-controls="datatable-example" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending" >Start Date</th>
        <th class="sorting" tabindex="0" aria-controls="datatable-example" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending" >End Date</th>
        <th tabindex="0" aria-controls="datatable-example" rowspan="1" colspan="1">Actions</th>
        
        </tr>
        </thead>
        <tbody>
          <?php foreach($projects as $k=>$project_det){?>
        <tr class="gradeA <?php if($k%2 == 0) {?>odd <?php } else { ?> even <?php } ?>" role="row">
        <td><?= $k+1?></td>
        <td class="sorting_1"><?= $project_det->project_name ?></td>
        <td><?= $project_det->description ?></td>
        <td><?= $project_det->estimated_time ?></td>
        <td class="center"><?= $this->Time->format($project_det->estimated_start_date, 'Y-MM-dd');?></td>
        <td class="center"><?= $this->Time->format($project_det->estimated_end_date, 'Y-MM-dd');?></td>
        <td class="center">
              <a href="<?= $this->Url->build(array("action" => "projects", $project_det->id));?>"><i class="glyph-icon demo-icon tooltip-button icon-elusive-pencil" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"></i></a>&nbsp;&nbsp;
                <a href="<?= $this->Url->build(array("action" => "projects", $project_det->id, "delete"));?>" onclick="javascript:confirm('Are you sure want to delete this Project?')"><i class="glyph-icon demo-icon tooltip-button icon-elusive-trash" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"></i></a>
                <a href="#" data-toggle="modal" data-target=".bs-document-modal-lg" data-id="<?= $project_det->id ?>" class="project_document" onclick="setprojectid('<?= $project_det->id ?>');"><i class="glyph-icon demo-icon tooltip-button icon-elusive-doc-new" data-toggle="tooltip" data-placement="top" title="" data-original-title="Documents"></i></a>
                <a href="<?= $this->Url->build(array("action" => "projectdetail", $project_det->id));?>" ><i class="glyph-icon demo-icon tooltip-button icon-elusive-slideshare" data-toggle="tooltip" data-placement="top" title="" data-original-title="View Timeline"></i></a>
        </td>
        </tr>
        <?php } ?>
        
        </tbody>
        </table>
        <div class="row">
        <div class="col-sm-6">
        <div class="dataTables_info" id="datatable-example_info" role="status" aria-live="polite"></div>
        </div>
        <div class="col-sm-6">
        <div class="dataTables_paginate paging_bootstrap" id="datatable-example_paginate">
        
        </div>
        </div>
        </div>
        </div>
        </div>
        </div>
        </div>

            </div>
          </div>
        </div>
        
<?php if(isset($project)){?> 
<button id="editclient" class="btn btn-default" style="display:none;" data-toggle="modal" data-target=".bs-edit-modal-lg">Add New</button>
<script type="text/javascript">
  $(document).ready(function(){
    $("#editclient").trigger("click");
  });
</script>  
<div class="modal fade bs-edit-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form method="post" enctype="multipart/form-data" class="form-horizontal bordered-row" data-parsley-validate=""> 
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h4 class="modal-title">Edit Project</h4>
        </div>
        <div class="modal-body">
          <div class="content-box-wrapper">

              <div class="row">
                  <div class="col-md-12">

                  <div class="form-group">
                  <label class="col-sm-3 control-label">Project Name</label>
                  <div class="col-sm-6">
                    <input name="project_name" class="form-control" id="" placeholder="Project Name" type="text" required="" value="<?= $project->project_name ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">Description</label>
                  <div class="col-sm-6">
                    <textarea name="description" id="" class="form-control" required=""><?= $project->description ?></textarea>
                  </div>
                </div>
                
                
                <div class="form-group .bordered-row">
                  <label class="col-sm-3 control-label">Start Date</label>
                  <div class="col-sm-6 input-prepend">
                    <span class="add-on input-group-addon"><i class="glyph-icon icon-calendar"></i></span><input name="estimated_start_date"  id="" type="text" class="bootstrap-datepickere form-control"  data-date-format="yyyy-mm-dd" required="" value="<?= $this->Time->format($project->estimated_start_date, 'Y-MM-dd');?>"/>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-3 control-label">End Date</label>
                  <div class="col-sm-6 input-prepend">
                    <span class="add-on input-group-addon"><i class="glyph-icon icon-calendar"></i></span><input name="estimated_end_date"  id="" type="text" class="bootstrap-datepickere1 form-control"   required="" data-date-format="yyyy-mm-dd" value="<?= $this->Time->format($project->estimated_end_date, 'Y-MM-dd');?>" />
                  </div>
                </div>
                
                <div class="form-group">
                  <label class="col-sm-3 control-label">Assign Team</label>
                  <div class="col-sm-6">
                    <select multiple="multiple" class="multi-select" name="teams[]" id="14multiselect" style="position: absolute; left: -9999px;" >
                    <?php foreach($team_members as $key => $value) { ?>
                      <option value="<?php echo $value['user_id']; ?>"  ><?php echo $value['client_name']; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-3 control-label">Assign Client</label>
                  <div class="col-sm-6">
                    <select  class="form-control" name="client_id"  required="">
                      <option value="">Select Client</option>
                    <?php foreach($project_clients as $key => $value) { ?>
                      <option value="<?php echo $value['user_id']; ?>" <?= $project->client_id == $value['user_id'] ? 'selected' : '';?>><?php echo $value['client_name']; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>

                </div>
                </div>

             <input type="hidden" name="id" value="<?= $project->id ?>">
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default " data-dismiss="modal">Close</button> 
          <button type="submit" class="btn btn-hover btn-primary">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php } ?>
        <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form method="post" enctype="multipart/form-data" class="form-horizontal bordered-row" data-parsley-validate=""> 
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h4 class="modal-title">New Project</h4>
        </div>
        <div class="modal-body">
          <div class="content-box-wrapper">

          <div class="row">
                 
                <div class="form-group">
                  <label class="col-sm-3 control-label">Project Name</label>
                  <div class="col-sm-6">
                    <input name="project_name" class="form-control" id="" placeholder="Project Name" type="text" required="">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">Description</label>
                  <div class="col-sm-6">
                    <textarea name="description" id="" class="form-control" required=""></textarea>
                  </div>
                </div>
                <div class="form-group" <?php if($loggedInUser['userrole'] != "admin") { ?> style="display:none;" <?php } ?>>
                <?php if($loggedInUser['userrole'] == "company") { $comp = $loggedInUser['id']; }
                elseif($loggedInUser['userrole'] == "user") { $comp = $loggedInUser['parent_id']; }else { $comp = '';} ?>
                  <label class="col-sm-3 control-label">Company Name</label>
                  <div class="col-sm-6">
                    <select class="form-control" name="company_id">
                      <option value="0">Select Company Name</option>
                      <?php foreach ($clients as $key => $value) { ?>
                      <option value="<?php echo $value['user_id']; ?>" <?= $comp == $value['user_id'] ? 'selected' : '';?>><?php echo $value['client_name']; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                
                <div class="form-group .bordered-row">
                  <label class="col-sm-3 control-label">Start Date</label>
                  <div class="col-sm-6">
                    <input name="estimated_start_date"  id="" type="text" class="bootstrap-datepicker form-control"  data-date-format="yyyy-mm-dd" required="">
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-3 control-label">End Date</label>
                  <div class="col-sm-6">
                    <input name="estimated_end_date"  id="" type="text" class="bootstrap-datepicker1 form-control"  data-date-format="yyyy-mm-dd" required="">
                  </div>
                </div>


                <div class="form-group">
                  <label class="col-sm-3 control-label">Assign Team</label>
                  <div class="col-sm-6">
                    <select multiple="multiple" class="multi-select" name="teams[]" id="14multiselect" style="position: absolute; left: -9999px;" >
                    <?php foreach($team_members as $key => $value) { ?>
                      <option value="<?php echo $value['user_id']; ?>"><?php echo $value['client_name']; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-3 control-label">Assign Client</label>
                  <div class="col-sm-6">
                    <select  class="form-control" name="client_id"  required="">
                      <option value="">Select Client</option>
                    <?php foreach($project_clients as $key => $value) { ?>
                      <option value="<?php echo $value['user_id']; ?>"><?php echo $value['client_name']; ?></option>
                      <?php } ?>
                    </select>
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
 <div class="modal fade bs-document-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form id="fileupload" method="post" enctype="multipart/form-data" class="form-horizontal bordered-row" data-parsley-validate=""> 

        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h4 class="modal-title">Add Documents</h4>
        </div>
        <div class="modal-body">
          <div class="panel">
          <div class="panel-body">
            <h3 class="title-hero">Add Documents</h3>
            <div class="example-box-wrapper">
              <form id="fileupload" action="<?= $this->Url->build(array("action" => "server")) ?>" method="POST" enctype="multipart/form-data">
                      <input type="hidden" name="project_doc_id" value="" id="project_doc_id" />
                <div class="row fileupload-buttonbar">
                  <div class="col-lg-12">
                    <div class="float-left"><span class="btn btn-md btn-success fileinput-button"><i class="glyph-icon icon-plus"></i> Add files...
                      <input type="file" name="files[]" multiple="multiple">
                      </span>
                      <button type="submit" class="btn btn-md btn-default start"><i class="glyph-icon icon-upload"></i> Start upload</button>
                      <button type="reset" class="btn btn-md btn-warning cancel"><i class="glyph-icon icon-ban"></i> Cancel upload</button>
                      <button type="button" class="btn btn-md btn-danger delete"><i class="glyph-icon icon-trash-o"></i> Delete</button>
                    </div>
                    <input type="checkbox" class="toggle width-reset float-left">
                    <span class="fileupload-process"></span></div>
                  <div class="col-lg-6 fileupload-progress fade">
                    <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                      <div class="progress-bar progress-bar-success bg-green">
                        <div class="progressbar-overlay"></div>
                      </div>
                    </div>
                    <div class="progress-extended">&nbsp;</div>
                  </div>
                </div>
                <table role="presentation" class="table table-striped">
                  <tbody class="files">
                  </tbody>
                </table>
              </form>
              <div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls" data-filter=":even">
                <div class="slides"></div>
                <h3 class="title"></h3>
                <a class="prev">‹</a> <a class="next">›</a> <a class="close">×</a> <a class="play-pause"></a>
                <ol class="indicator">
                </ol>
              </div>
              <script id="template-upload" type="text/x-tmpl">{% for (var i=0, file; file=o.files[i]; i++) { %}
                  <tr class="template-upload fade">
                      <td>
                          <span class="preview"></span>
                      </td>
                      <td>
                          <p class="name">{%=file.name%}</p>
                          <strong class="error text-danger"></strong>
                      </td>
                      <td>
                          <p class="size">Processing...</p>
                          <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success bg-green" style="width:0%;"></div></div>
                      </td>
                      <td>
                          {% if (!i && !o.options.autoUpload) { %}
                              <button class="btn btn-md btn-default start" disabled>
                                <span class="button-content">
                                  <i class="glyph-icon icon-upload"></i>
                                  Start
                                </span>
                              </button>
                          {% } %}
                          {% if (!i) { %}
                              <button class="btn btn-md btn-warning cancel">
                                  <span class="button-content">
                                    <i class="glyph-icon icon-ban-circle"></i>
                                    Cancel
                                  </span>
                              </button>
                          {% } %}
                      </td>
                  </tr>
              {% } %}</script>
              <script id="template-download" type="text/x-tmpl">{% for (var i=0, file; file=o.files[i]; i++) { %}
                  <tr class="template-download fade">
                      <td>
                          <span class="preview">
                              {% if (file.thumbnailUrl) { %}
                                  <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}" style="width:100px;height:100px;"></a>
                              {% } %}
                          </span>
                      </td>
                      <td>
                          <p class="name">
                              {% if (file.url) { %}
                                  <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
                              {% } else { %}
                                  <span>{%=file.name%}</span>
                              {% } %}
                          </p>
                          {% if (file.error) { %}
                              <div><span class="label label-danger">Error</span> {%=file.error%}</div>
                          {% } %}
                      </td>
                      <td>
                          <span class="size">{%=o.formatFileSize(file.size)%}</span>
                      </td>
                      <td>
                          {% if (file.deleteUrl) { %}
                              <button class="btn btn-md btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
                                  <span class="button-content">
                                    <i class="glyph-icon icon-trash"></i>
                                    Delete
                                  </span>
                              </button>
                              <input type="checkbox" name="delete" value="1" class="toggle width-reset float-left">
                          {% } else { %}
                              <button class="btn btn-md btn-warning cancel">
                                  <span class="button-content">
                                    <i class="glyph-icon icon-ban-circle"></i>
                                    Cancel
                                  </span>
                              </button>
                          {% } %}
                      </td>
                  </tr>
              {% } %}</script></div>
          </div>
        </div>
        </div>

    </form>
    </div>
    </div>
    </div>


<script src="http://blueimp.github.io/JavaScript-Templates/js/tmpl.min.js"></script>
<script src="http://blueimp.github.io/JavaScript-Load-Image/js/load-image.all.min.js"></script>
<script src="http://blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js"></script>
<script src="http://blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>

<?= $this->Html->script(array('../assets/widgets/multi-upload/jquery.iframe-transport', '../assets/widgets/multi-upload/jquery.fileupload', '../assets/widgets/multi-upload/jquery.fileupload-process', '../assets/widgets/multi-upload/jquery.fileupload-image', '../assets/widgets/multi-upload/jquery.fileupload-audio', '../assets/widgets/multi-upload/jquery.fileupload-video', '../assets/widgets/multi-upload/jquery.fileupload-validate', '../assets/widgets/multi-upload/jquery.fileupload-ui', '../assets/widgets/multi-upload/main')); ?>
<!--[if (gte IE 8)&(lt IE 10)]>
<?= $this->Html->script(array('../assets/widgets/multi-upload/cors/jquery.xdr-transport')); ?>
<![endif]-->

<script>
function setprojectid(id){
  $('#project_doc_id').val(id);
}
</script>