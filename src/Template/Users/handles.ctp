<?= $this->Html->script(array('../assets/widgets/wizard/wizard', '../assets/widgets/wizard/wizard-demo', '../assets/widgets/tabs/tabs', '../assets/widgets/modal/modal')) ?>
<div class="panel">
  <div class="panel-body">
    <h3 class="title-hero">
    Handles 
    <button class="btn btn-default" data-toggle="modal" data-target=".bs-example-modal-lg">Add New</button>
    </h3>
    <div class="example-box-wrapper">
      <div class="hide-columns">
        <table class="table table-bordered table-striped table-condensed">
          <thead>
            <tr>
              <th>#</th>
              <th>Name</th>
              <th>Category</th>
              <th>Color</th>
              <th>Image</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($handles as $k=>$dor){?>
            <tr>
              <td><?= $k+1?></td>
              <td><?= $dor->title;?></td>
              <td><?= $this->Custom->category_name($dor->category);?></td>
              <td><?= $this->Custom->color_name($dor->color);?></td>
              <td> <img width="90" src="<?php echo $siteurl.'upload/handle/'.$dor->image; ?>"></td>
              <td>
                <a href="<?= $this->Url->build(array("action" => "handles", $dor->id));?>"><i class="glyph-icon icon-pencil"></i></a>&nbsp;&nbsp;
                <a href="<?= $this->Url->build(array("action" => "handles", $dor->id, "delete"));?>" onclick="javascript:confirm('Are you sure want to delete this door?')"><i class="glyph-icon icon-trash"></i></a>
              </td>
            </tr>
            <?php }?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<?php if(isset($handle)){?> 
<button id="editcatgeory" class="btn btn-default" data-toggle="modal" data-target=".bs-edit-modal-lg">Add New</button>
<script type="text/javascript">
  $(document).ready(function(){
    $("#editcatgeory").trigger("click");
  });
</script>      
<div class="modal fade bs-edit-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form method="post" enctype="multipart/form-data" class="form-horizontal bordered-row">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h4 class="modal-title">Edit Handle</h4>
        </div>
        <div class="modal-body">
          <div class="content-box-wrapper">
               <div class="form-group">
                  <label class="col-sm-3 control-label">Name</label>
                  <div class="col-sm-6">
                    <input value="<?= $handle->title?>" name="title" class="form-control" id="" placeholder="Example placeholder..." type="text">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">Description</label>
                  <div class="col-sm-6">
                    <textarea name="description" id="" class="form-control"><?= $handle->description?></textarea>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-3 control-label">Category</label>
                  <div class="col-sm-6">
                    <select class="form-control" name="category">
                      <option value="0">Select Category</option>
                      <?php foreach ($categories as $key => $value) { ?>
                      <option <?= $handle->category == $value['id'] ? 'selected' : '';?> value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                
                <div class="form-group">
                  <label class="col-sm-3 control-label">Color</label>
                  <div class="col-sm-6">
                    <select class="form-control" name="color">
                      <option value="0">Select Color</option>
                      <?php foreach ($colors as $key => $value) { ?>
                      <option <?= $handle->color == $value['id'] ? 'selected' : '';?> value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-3 control-label">Image</label>
                  <div class="col-sm-3">
                    <input name="image" class="form-control" id="" type="file">
                  </div>
                   <div class="col-sm-3">
                    <img width="90" src="<?php echo $siteurl.'upload/handle/'.$handle->image; ?>">
                  </div>
                </div>

            </div>
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
        <input type="hidden" name="id" value="<?= $handle->id?>">
      </form>
    </div>
  </div>
</div>
<?php }else{?>
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form method="post" enctype="multipart/form-data" class="form-horizontal bordered-row">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h4 class="modal-title">New Handle</h4>
        </div>
        <div class="modal-body">
          <div class="content-box-wrapper">
                <div class="form-group">
                  <label class="col-sm-3 control-label">Name</label>
                  <div class="col-sm-6">
                    <input name="title" class="form-control" id="" placeholder="Example placeholder..." type="text">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">Description</label>
                  <div class="col-sm-6">
                    <textarea name="description" id="" class="form-control"></textarea>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-3 control-label">Category</label>
                  <div class="col-sm-6">
                    <select class="form-control" name="category">
                      <option value="0">Select Category</option>
                      <?php foreach ($categories as $key => $value) { ?>
                      <option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                
                <div class="form-group">
                  <label class="col-sm-3 control-label">Color</label>
                  <div class="col-sm-6">
                    <select class="form-control" name="color">
                      <option value="0">Select Color</option>
                      <?php foreach ($colors as $key => $value) { ?>
                      <option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-3 control-label">Image</label>
                  <div class="col-sm-6">
                    <input name="image" class="form-control" id="" type="file">
                  </div>
                </div>

            </div>
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php }?>