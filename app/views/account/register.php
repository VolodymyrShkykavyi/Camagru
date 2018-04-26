Register view
<?php
if (isset($ViewData['errors'])) {
	echo 'errors: ' . $ViewData['errors'] . '<br>';
}
if (!isset($_POST['register_login']) || !isset($_POST['register_email'])){
	$_POST['register_login'] = "";
	$_POST['register_email'] = "";
}

?>
<?php if (!isset($ViewData['verify_url'])): ?>
	<form action="/account/register" method="post">
    Login: <input type="text" value="<?=$_POST['register_login'];?>" name="register_login"><br>
    Pass: <input type="password" value="" name="register_password"><br>
    Email: <input type="email" value="<?=$_POST['register_email'];?>" name="register_email"><br>
    <button type="submit">Register me</button>
</form>
<?php endif; ?>