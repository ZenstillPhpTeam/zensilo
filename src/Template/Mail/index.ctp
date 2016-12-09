<div class="row mailbox-wrapper">
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
</div>
<script type="text/javascript">
  
  function refresh_data()
  {
      $.get("<?= $this->Url->build(['controller' => 'mail', 'action' => 'index', $type, 1])?>", function(res){
        $(".mailbox-wrapper").html(res);
      });
  }

  $(document).on("click", ".mail_list_page .mail_list_table .important_mail_info", function(e){
    e.stopPropagation();
    $.get("<?= $this->Url->build(['controller' => 'ajax', 'action' => 'update_important_mail'])?>/"+$(this).data("val")+"/"+$(this).data("star"), function(res){
      refresh_data();
    });
  });

  $(document).on("click", ".mail_list_page .refresh_mail_data", function(){
      refresh_data();
  });

  $(document).on("click", ".mail_list_page #select_all", function(){
      if($(this).is(":checked"))
        $(".mail_list_table input:checkbox").prop("checked", true);
      else
        $(".mail_list_table input:checkbox").prop("checked", false);
  });

  $(document).on("click", ".mail_list_page .bulk_action", function(){
      var aa = [];
      $(".mail_list_table input:checked").each(function(){
        aa.push($(this).val());
      });

      if(!aa.length){
        alert("Select mail and then do bulk action");
        return;
      }

      $.post("<?= $this->Url->build(['controller' => 'ajax', 'action' => 'bulk_action'])?>/", {action: $(this).data("val"), ids: aa}, function(res){
        refresh_data();
      });
  });
  var current_mail = 0;
  $(document).on("click", ".mail_list_page .mail_list_table tr", function(){
    <?php if($type != 'drafts'){?>
      current_mail = $(this).data("val");
      $.get("<?= $this->Url->build(['controller' => 'mail', 'action' => 'single'])?>/"+$(this).data("val"), function(res){
            if(res)
            {
              $(".mail_view_box").html(res);
              $(".mail_list_box").toggleClass("hide");
              $(".mail_view_box").toggleClass("hide");
            }
      });
    <?php }else{?>
      window.location.assign("<?= $this->Url->build(['controller' => 'mail', 'action' => 'compose'])?>/"+$(this).data("val")+'/draft');
    <?php }?>
  });

  $(document).on("click", ".mail_list_page #back_to_list", function(){
    $(".mail_list_box").toggleClass("hide");
    $(".mail_view_box").toggleClass("hide");
  });

  $(document).on("click", ".print_mail", function(){
    win = window.open("", "_blank", "scrollbars=yes,resizable=yes,top=100,left=500,width=800,height=500");
    $(win.document).find("body").html($(".mail_view_box").html());
    $(win.document).find("body .btn").remove();
    $(win.document).find("body .mrg10B").after("<hr>");
    win.print();
  });

  $(document).on("click", ".trash_mail", function(){
    var aa = [current_mail];
    $.post("<?= $this->Url->build(['controller' => 'ajax', 'action' => 'bulk_action'])?>/", {action: "trash", ids: aa}, function(res){
        refresh_data();
        $(".mail_list_box").toggleClass("hide");
        $(".mail_view_box").toggleClass("hide");
    });
  });
</script>