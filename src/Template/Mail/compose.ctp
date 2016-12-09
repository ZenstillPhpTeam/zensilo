<?= $this->Html->script(array('../assets/widgets/summernote-wysiwyg/summernote-wysiwyg'));?>
<script type="text/javascript">/* WYSIWYG editor */

    $(function() { "use strict";
        $('.wysiwyg-editor').summernote({
            height: 350
        });
    });</script><script>$(function() {
        $('body').addClass('closed-sidebar');
    });</script>
  <div class="row mailbox-wrapper">
    <?= $this->element('mail_menu');?>
    <div class="col-md-9">
      <div class="content-box">
        <div class="mail-header clearfix">
          <div class="float-left"><span class="mail-title">Compose new message</span></div>
        </div>
        <div class="divider"></div>
        <?php 
        if(isset($ddata))
        {
            $to = []; $cc = []; $bcc = [];
            
            if($type == 'draft')
            {
              foreach($ddata->mail_participants as $us)
              {
                if($us->type == 'to')
                  $to[] = $us->user_id;
                elseif($us->type == 'cc')
                  $cc[] = $us->user_id;
                elseif($us->type == 'bcc')
                  $bcc[] = $us->user_id;
              }
            }
            elseif($type == 'reply')
            {
              $to[] = $ddata->mail_from;
            }
        }
        ?>
        <form method="post" class="form-horizontal mrg15T row" role="form">
          <div class="form-group">
            <label for="inputEmail1" class="col-sm-2 control-label">To:</label>
            <div class="col-sm-8">
              <select name="mail_to[]" multiple class="chosen-select">
                <?php foreach($company_users as $us){?>
                <option <?= (isset($ddata) && in_array($us->id, $to)) ? 'selected' : ''; ?> value="<?= $us->id;?>"><?= $us->email;?></option>
                <?php }?>
                <?php foreach($company_clients as $us){?>
                <option <?= (isset($ddata) && in_array($us->id, $to)) ? 'selected' : ''; ?> value="<?= $us->id;?>"><?= $us->email;?></option>
                <?php }?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="inputEmail2" class="col-sm-2 control-label">CC:</label>
            <div class="col-sm-8">
              <select name="mail_cc[]" multiple class="chosen-select">
                <?php foreach($company_users as $us){?>
                <option <?= (isset($ddata) && in_array($us->id, $cc)) ? 'selected' : ''; ?> value="<?= $us->id;?>"><?= $us->email;?></option>
                <?php }?>
                <?php foreach($company_clients as $us){?>
                <option <?= (isset($ddata) && in_array($us->id, $cc)) ? 'selected' : ''; ?> value="<?= $us->id;?>"><?= $us->email;?></option>
                <?php }?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">BCC:</label>
            <div class="col-sm-8">
              <select name="mail_bcc[]" multiple class="chosen-select">
                <?php foreach($company_users as $us){?>
                <option <?= (isset($ddata) && in_array($us->id, $bcc)) ? 'selected' : ''; ?> value="<?= $us->id;?>"><?= $us->email;?></option>
                <?php }?>
                <?php foreach($company_clients as $us){?>
                <option <?= (isset($ddata) && in_array($us->id, $bcc)) ? 'selected' : ''; ?> value="<?= $us->id;?>"><?= $us->email;?></option>
                <?php }?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="inputEmail4" class="col-sm-2 control-label">Subject:</label>
            <div class="col-sm-8">
              <input value="<?= (isset($ddata) && $type != 'forward') ? ($type == 'reply' ? 'Reply : '.$ddata->subject : $ddata->subject) : '';?>" name="subject" type="text" class="form-control" id="inputEmail4" placeholder="Subject">
            </div>
          </div>
          <div class="pad15A">
            <textarea class="wysiwyg-editor" name="message">
              <?= (isset($ddata) && $type == 'draft') ? $ddata->message : '';?>
            </textarea>
          </div>
          <div class="button-pane">
            <input id="sendMail" type="submit" class="btn btn-info" value="Send mail" />
            <input id="draftMail" type="submit" class="btn btn-link font-gray-dark" value="Cancel" />
            <input type="hidden" id="setvalue" name="">
          </div>
        </form>
      </div>
    </div>
  </div>
  <script type="text/javascript">
    $(document).ready(function(){
      $("#sendMail, #draftMail").click(function(){
            $("#setvalue").attr("name", $(this).attr("id"));
      });
    });
  </script>