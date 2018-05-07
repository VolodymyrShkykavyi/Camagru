<header class="container-fluid bg-dark text-light">
    <div class="row">
        <div class="col-md-3 vertical-center ">
            <h1 class="m-auto">
                <a id="logo" href="/">Camagru</a>
            </h1>
        </div>
        <div class="col-md-4 pt-2 pb-2 vertical-center justify-content-center text-center">
            <a href="/gallery/montage" class="btn btn-primary ml-lg-5 ml-md-5">Make Photo!</a>
        </div>
        <div class="col-md-5 text-center">
            <div class="float-lg-right float-md-right d-inline-flex">
				<?php if (!isset($_SESSION['authorization']) || empty($_SESSION['authorization'])
					|| empty($_SESSION['authorization']['login'])): ?>
                    <form id="login-form" action="/account/login" method="post">
                        <div class="form-group">
                            <input type="text" class="form-control-sm" name="login_username" placeholder="Username"
                                   value="">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control-sm" name="login_password" placeholder="Password"
                                   value="">
                        </div>
                        <button type="submit" name="submit" class="btn btn-primary" title="login">
                            <i class="fa fa-chevron-right text-dark"></i>
                        </button>
                        <div class="small">
                            <a href="/account/lost">Lost password? </a>
                            <a href="/register" style="float: right;">Register</a>
                        </div>
                    </form>
                <script src="/public/scripts/signin.js"></script>
				<?php else: ?>
                    <div class="vertical-center mr-5">
                        Hello, <span id="user_login" class="ml-2"><?= $_SESSION['authorization']['login']; ?></span>
                    </div>
                    <div class="mr-3">
                        <a class="btn btn-primary rounded-circle " title="Account settings" href="/account/settings">
                            <i class="fa fa-cogs mt-2 text-dark"></i>
                        </a>
                    </div>
                    <div class="mr-2">
                        <form action="/account/logout" method="post">
                            <button type="submit" id="btn_logout" class="btn btn-primary text-dark" title="logout">
                                <i class="fa fa-power-off"></i>
                            </button>
                        </form>
                    </div>
				<?php endif; ?>
            </div>
        </div>
    </div>
</header>