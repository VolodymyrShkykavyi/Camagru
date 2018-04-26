<header class="container-fluid bg-dark text-light">
    <div class="row">
        <div class="col-md-5 vertical-center">
            <h1><a id="logo" href="/">Camagru</a></h1>
        </div>
        <div class="col-md-2 vertical-center">
            <a href="/gallery" class="btn btn-primary">Make Photo!</a>
        </div>
        <div class="col-md-5">
            <div  class="pull-right d-inline-flex">
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
                    <?php else: ?>
                    <div class="vertical-center mr-5">
                        Hello, <?=$_SESSION['authorization']['login']; ?>
                    </div>
                <div class="mr-2">
                    <form action="/account/logout" method="post">
                        <button type="submit" id="btn_logout" class="btn btn-primary text-dark" title="logout">
                            <i class="fa fa-power-off"></i>
                        </button>
                    </form>
                </div>
                    <?php //unset($_SESSION['authorization']);?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</header>