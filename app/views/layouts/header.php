<header class="container-fluid bg-dark text-light">
    <div class="row">
        <div class="col-md-6">
            <a id="logo" href="/"><h1>Camagru</h1></a>
        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-7">
                </div>
                <?php if (!isset($_SESSION['authorization']) || empty($_SESSION['authorization'])
                || empty($_SESSION['authorization']['login'])): ?>
                <form id="login-form" action="/account/login" method="post">
                    <div class="form-group">
                        <input type="text" class="form-control" name="login_username" placeholder="Username" value="">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="login_password" placeholder="Password" value="">
                    </div>
                    <button type="submit" class="btn btn-primary" title="login">
                        <i class="fa fa-chevron-right text-dark"></i>
                    </button>
                    <div>
                        <a href="/">Lost password? </a>
                        <a href="/register" style="float: right;">Register</a>
                    </div>
                </form>
                    <?php //$_SESSION['authorization']['login']='adm'; ?>
                    <?php else: ?>
                    <div class="col-md-3">
                        Hello, <?=$_SESSION['authorization']['login']; ?>
                    </div>
                    <form action="/account/logout" method="post">
                        <button type="submit" id="btn_logout" class="btn btn-primary text-dark" title="logout">
                            <i class="fa fa-power-off"></i>
                        </button>
                    </form>
                    <?php //unset($_SESSION['authorization']);?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</header>