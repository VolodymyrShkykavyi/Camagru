<?php
if (!isset($_POST['register_login']) || !isset($_POST['register_email'])) {
	$_POST['register_login'] = "";
	$_POST['register_email'] = "";
}

?>
<?php if (!isset($ViewData['verify_url'])): ?>
        <div class="container pt-3">
            <form action="/account/register" method="post">
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-5">
                        <h2>Registration</h2>
                        <hr>
                    </div>
                </div>

                <div class="row">
                    <label for="login_input" class="col-md-3 text-md-right form-text">Login:</label>
                    <div class="col-md-5">
                        <div class="input-group mb-2 mr-0">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-user"></i></span>
                            </div>
                            <input class="form-control" id="login_input" type="text"
                                   value="<?= $_POST['register_login']; ?>" name="register_login" required>
                        </div>
                    </div>
                    <div class="col-md-4 p-0">
                        <span id="login_status" class="fa preloader d-none text-left align-middle"></span>
                    </div>
                </div>

                <div class="row">
                    <label for="email_input" class="col-md-3 text-md-right form-text">E-Mail:</label>
                    <div class="col-md-5">
                        <div class="input-group mb-2 mr-0">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                            </div>
                            <input class="form-control" id="email_input" type="email"
                                   value="<?= $_POST['register_email']; ?>"
                                   name="register_email" required>
                        </div>
                    </div>
                    <div class="col-md-4 p-0">
                        <span id="email_status" class="fa preloader d-none text-left align-middle"></span>
                    </div>
                </div>

                <div class="row">
                    <label for="psw_input" class="col-md-3 text-md-right form-text">Password:</label>
                    <div class="col-md-5">
                        <div class="input-group mb-2 mr-0">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-key"></i></span>
                            </div>
                            <input class="form-control" id="psw_input" type="password" value=""
                                   name="register_password" required>
                        </div>
                    </div>
                    <div class="col-md-4 p-0">
                        <span id="psw_status" class="fa fa-check d-none text-left align-middle"></span>
                    </div>
                </div>

                <div class="row">
                    <label for="psw_input_confirm" class="col-md-3 text-md-right form-text">Confirm password:</label>
                    <div class="col-md-5">
                        <div class="input-group mb-2 mr-0">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-repeat"></i></span>
                            </div>
                            <input class="form-control" id="psw_input_confirm" type="password" value="" required>
                        </div>
                    </div>
                    <div class="col-md-4 p-0">
                        <span id="psw_status_confirm" class="fa fa-check d-none text-left align-middle"></span>
                    </div>
                </div>

                <div class="row pb-5 pt-md-3 pt-sm-1">
                    <div class="col-md-3"></div>
                    <div class="col-md-9">
                        <button class="btn btn-success" id="btn_register" type="submit">
                            <i class="fa fa-user-plus"></i> Register me
                        </button>
                    </div>
                </div>
            </form>
        </div>
    <script src="/public/scripts/registration.js"></script>
<?php endif; ?>


