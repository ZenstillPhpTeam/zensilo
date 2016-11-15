<?= $this->Html->script(array('../assets/widgets/wizard/wizard', '../assets/widgets/wizard/wizard-demo', '../assets/widgets/tabs/tabs', '../assets/widgets/modal/modal')) ?>
<div class="panel">
  <div class="panel-body">
    <h3 class="title-hero">
    Category 
    <button class="btn btn-default" data-toggle="modal" data-target=".bs-example-modal-lg">Add New</button>
    </h3>
    <div class="example-box-wrapper">
      <div class="hide-columns">
        <table class="table table-bordered table-striped table-condensed">
          <thead>
            <tr>
              <th>#</th>
              <th>Name</th>
              <th>Description</th>
              <th>For</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($categories as $k=>$cat){?>
            <tr>
              <td><?= $k+1?></td>
              <td><?= $cat->name;?></td>
              <td><?= $cat->description;?></td>
              <td><?= $cat->type;?></td>
              <td>
                <a href="<?= $this->Url->build(array("action" => "category", $cat->id));?>"><i class="glyph-icon icon-pencil"></i></a>&nbsp;&nbsp;
                <a href="<?= $this->Url->build(array("action" => "category", $cat->id, 'delete'));?>" onclick="javascript:confirm('Are you sure want to delete this category?')"><i class="glyph-icon icon-trash"></i></a>
              </td>
            </tr>
            <?php }?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<?php if(isset($category)){?> 
<button id="editcatgeory" class="btn btn-default" data-toggle="modal" data-target=".bs-edit-modal-lg">Add New</button>
<script type="text/javascript">
  $(document).ready(function(){
    $("#editcatgeory").trigger("click");
  });
</script>      
<div class="modal fade bs-edit-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form method="post" class="form-horizontal bordered-row">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h4 class="modal-title">Edit Category</h4>
        </div>
        <div class="modal-body">
          <div class="content-box-wrapper">
                <div class="form-group">
                  <label class="col-sm-3 control-label">Name</label>
                  <div class="col-sm-6">
                    <input value="<?= $category->name?>" name="name" class="form-control" id="" placeholder="Example placeholder..." type="text">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">Description</label>
                  <div class="col-sm-6">
                    <textarea name="description" id="" class="form-control"><?= $category->description?></textarea>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">For</label>
                  <div class="col-sm-6">
                    <select class="form-control" name="type">
                      <option <?= $category->type == 'Door' ? 'selected' : '';?>>Door</option>
                      <option <?= $category->type == 'Handle' ? 'selected' : '';?>>Handle</option>
                    </select>
                  </div>
                </div>
            </div>
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
        <input type="hidden" name="id" value="<?= $category->id?>">
      </form>
    </div>
  </div>
</div>
<?php }else{?>
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form method="post" class="form-horizontal bordered-row">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h4 class="modal-title">New Category</h4>
        </div>
        <div class="modal-body">
          <div class="content-box-wrapper">
                <div class="form-group">
                  <label class="col-sm-3 control-label">Name</label>
                  <div class="col-sm-6">
                    <input name="name" class="form-control" id="" placeholder="Example placeholder..." type="text">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">Description</label>
                  <div class="col-sm-6">
                    <textarea name="description" id="" class="form-control"></textarea>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">For</label>
                  <div class="col-sm-6">
                    <select class="form-control" name="type">
                      <option>Door</option>
                      <option>Handle</option>
                    </select>
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