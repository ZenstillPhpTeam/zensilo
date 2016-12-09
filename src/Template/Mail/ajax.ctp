<?= $this->element('mail_menu');?>
  <div class="col-md-9 mail_list_page">
    <div class="content-box mail_view_box hide">
      
    </div>
    <div class="content-box mail_list_box">
      <div class="mail-header clearfix"><span class="mail-title" style="text-transform: capitalize;"><?= $type;?></span>
        <div class="float-right col-md-4 pad0A">
          <div class="input-group">
            <input type="text" class="form-control">
            <div class="input-group-btn">
              <button type="button" class="btn btn-default" tabindex="-1"><i class="glyph-icon icon-search"></i></button>
            </div>
          </div>
        </div>
      </div>
      <div class="mail-toolbar clearfix">
        <div class="float-left">
          <input type="checkbox" id="select_all" class="custom-checkbox">
          <a href="#" title="" class="btn btn-default mrg5R refresh_mail_data"><i class="glyph-icon font-size-11 icon-refresh"></i></a>
          <div class="dropdown"><a href="#" title="" class="btn btn-default" data-toggle="dropdown"><i class="glyph-icon icon-cog"></i> <i class="glyph-icon icon-chevron-down"></i></a>
            <ul class="dropdown-menu float-right">
              <li class="bulk_action" data-val="important"><a href="#" title=""><i class="glyph-icon icon-certificate mrg5R"></i> Set as Important</a></li>
              <li class="bulk_action" data-val="unimportant"><a href="#" title=""><i class="glyph-icon icon-certificate mrg5R"></i> Set as UnImportant</a></li>
              <li class="divider"></li>
              <?php if($type != 'trash' && $type != 'drafts'){?>
              <li class="bulk_action" data-val="trash"><a href="#" class="font-red" title=""><i class="glyph-icon icon-remove mrg5R"></i> Move to trash</a></li>
              <?php }elseif($type == 'trash'){?>
              <li class="bulk_action" data-val="revert"><a href="#" class="font-red" title=""><i class="glyph-icon icon-remove mrg5R"></i> Revert back</a></li>
              <li class="bulk_action" data-val="remove"><a href="#" class="font-red" title=""><i class="glyph-icon icon-remove mrg5R"></i> Permanently Remove</a></li>
              <?php }elseif($type == 'drafts'){?>
              <li class="bulk_action" data-val="remove"><a href="#" class="font-red" title=""><i class="glyph-icon icon-remove mrg5R"></i> Discard Draft</a></li>
              <?php }?>
            </ul>
          </div>
        </div>
        <?php if(count($mails)){?>
        <div class="float-right">
          <div class="btn-toolbar">
            <div class="btn-group">
              <div class="size-md mrg10R"><?php echo $this->Paginator->counter(array('format' => 'range'));?></div>
            </div>
            <div class="btn-group mail_pagination">
              <?= $this->Paginator->numbers() ? '<span class="btn btn-default">'.$this->Paginator->prev(__('<'), array('tag' => false)).'</span>' : '' ?>
              <?= $this->Paginator->numbers() ? '<span class="btn btn-default">'.$this->Paginator->next(__('>'), array('tag' => false)).'</span>' : '' ?>
            </div>
          </div>
        </div>
        <?php }?>
      </div>
      <table class="table table-hover text-center mail_list_table">
        <tbody>
          <?php if(count($mails)){foreach($mails as $mail){?>
          <tr class="<?= $mail->readed ? '' : 'unread_mail'; ?>" data-val="<?= $mail->id?>">
            <td><input value="<?= $mail->id?>" type="checkbox" id="mail-checkbox-1" class="custom-checkbox"></td>
            
            <?php if($type == 'inbox' || $type == 'important'){?>
            <td><i data-star="<?= $mail->starred ? 0 : 1;?>" data-val="<?= $mail->id?>" class="glyph-icon icon-star <?= $mail->starred ? 'important_mail' : ''; ?> important_mail_info"></i></td>
            <?php }?>
            <td class="email-title"><?= $mail->user->email; ?></td>
            <td class="email-body"><?= $mail->message; ?></td>
            <td><?= $mail->created; ?></td>
          </tr>
          <?php }}else{?>
          <tr><td colspan="5">No mails found.</td></tr>
          <?php }?>
        </tbody>
      </table>
    </div>
  </div>