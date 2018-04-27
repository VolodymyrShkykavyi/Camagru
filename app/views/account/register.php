<?php
if (!isset($_POST['register_login']) || !isset($_POST['register_email'])){
	$_POST['register_login'] = "";
	$_POST['register_email'] = "";
}

?>
<?php if (!isset($ViewData['verify_url'])): ?>
	<form action="/account/register" method="post">
    Login: <input id="login_input" type="text" value="<?=$_POST['register_login'];?>" name="register_login"><span id="login_status" class="fa preloader d-none text-center"></span>
        <br>
    Pass: <input id="psw_input" type="password" value="" name="register_password"><span id="psw_status" class="fa fa-check d-none text-center"></span>
        <br>
    Email: <input id="email_input" type="email" value="<?=$_POST['register_email'];?>" name="register_email"><span id="email_status" class="fa preloader d-none text-center"></span>
        <br>
    <button id="btn_register" type="submit">Register me</button>
</form>
<script src="/public/scripts/registration.js"></script>
<?php endif; ?>