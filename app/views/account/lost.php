<?php
if (!isset($ViewData['result']) && isset($ViewData['token']) &&
	isset($ViewData['login']) && $ViewData['token'] && $ViewData['login']):?>
    <form method="post" action="/account/lost">
        <input type="password" name="newPassword" placeholder="New password">
        <input type="password" name="repeatPassword" placeholder="Repeat password">
        <input type="hidden" name="token" value="<?= $ViewData['token']; ?>">
        <input type="hidden" name="login" value="<?= $ViewData['login']; ?>">
        <button type="submit" class="btn" name="action" value="resetPassword">Reset password</button>
    </form>
<?php elseif (isset($ViewData['result']) && $ViewData['result'] == 'OK'): ?>
    <span class="text-success">Your password has been changed!</span>
<?php elseif (isset($ViewData['result']) && $ViewData['result'] == 'ERROR'): ?>
    <span class="text-danger">Can't change password. Please try again</span>
<?php else: ?>
    <form method="post" action="/account/lost">
        <input type="text" name="login" placeholder="Username">
        <button type="submit" name="action" value="sendMail">Get reinitialization mail</button>
    </form>
<?php endif; ?>
