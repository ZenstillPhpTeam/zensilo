<?php
if (!isset($params['escape']) || $params['escape'] !== false) {
    $message = h($message);
}
?>
<div class="alert alert-error alert-danger message error" onclick="this.classList.add('hidden')"><div class="bg-red alert-icon"><i class="glyph-icon icon-check"></i></div><div class="alert-content"><h4 class="alert-title">Warning</h4><p><?= $message ?></p></div></div>
