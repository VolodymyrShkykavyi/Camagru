<?php
if (!isset($ViewData['result']) && isset($ViewData['token']) &&
    isset($ViewData['login']) && $ViewData['token'] && $ViewData['login']):?>
    <form method="post" action="/account/lost" class="form-row  mt-3 mb-4">
        <div class="col-12 mt-1">
            <input type="password" name="newPassword" placeholder="New password">
        </div>
        <div class="col-12 mt-1">
            <input type="password" name="repeatPassword" placeholder="Repeat password">
        </div>
        <div class="col-12 mt-1">
            <input type="hidden" name="token" value="<?= $ViewData['token']; ?>">
        </div>
        <div class="col-12 mt-1">
            <input type="hidden" name="login" value="<?= $ViewData['login']; ?>">
        </div>
        <div class="col-12 mt-1">
            <button type="submit" class="btn btn-primary" name="action" value="resetPassword">Reset password</button>
        </div>
    </form>
<?php elseif (isset($ViewData['result']) && $ViewData['result'] == 'OK'): ?>
    <span class="text-success">Your password has been changed!</span>
<?php elseif (isset($ViewData['result']) && $ViewData['result'] == 'ERROR'): ?>
    <span class="text-danger">Can't change password. Please try again</span>
<?php else: ?>
    <form method="post" action="/account/lost" class="form-row  mt-3 mb-4">
        <div class="col-12 mt-1">
            <input type="text" name="login" placeholder="Username">
        </div>
        <div class="col-12 mt-1">
            <button type="submit" class="btn btn-primary" name="action" value="sendMail">Get reinitialization mail
            </button>
        </div>
    </form>
<?php endif; ?>
