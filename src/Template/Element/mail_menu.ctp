<div class="col-md-3">
    <div class="content-box nav-list mrg15B">
      <div class="pad10A"><a href="<?= $this->Url->build(array('controller' => 'mail', 'action' => 'compose'));?>" class="btn btn-success btn-lg btn-block" title="Compose new mail">Compose new mail</a></div>
      
      <div class="list-group">
        <a href="<?= $this->Url->build(array('controller' => 'mail', 'action' => 'index'));?>" class="list-group-item" title=""><i class="glyph-icon font-gray icon-inbox"></i> Inbox <span class="badge bg-blue"><?= $inbox_count;?></span></a> 
        <a href="<?= $this->Url->build(array('controller' => 'mail', 'action' => 'index', 'sent'));?>" class="list-group-item" title=""><i class="glyph-icon font-gray icon-envelope-o"></i> Sent Mail <span class="badge bg-azure"><?= $sent_count;?></span></a> 
        <a href="<?= $this->Url->build(array('controller' => 'mail', 'action' => 'index', 'important'));?>" class="list-group-item" title=""><i class="glyph-icon font-gray icon-certificate"></i> Important <span class="badge bg-azure"><?= $important_count;?></span></a> 
        <a href="<?= $this->Url->build(array('controller' => 'mail', 'action' => 'index', 'drafts'));?>" class="list-group-item" title=""><i class="glyph-icon font-gray icon-file-text-o"></i> Drafts <span class="badge bg-azure"><?= $draft_count;?></span></a> 
        <a href="<?= $this->Url->build(array('controller' => 'mail', 'action' => 'index', 'trash'));?>" class="list-group-item" title=""><i class="glyph-icon font-gray icon-trash-o"></i> Trash <span class="badge bg-red"><?= $trash_count;?></span></a>
      </div>
    </div>
    
  </div>