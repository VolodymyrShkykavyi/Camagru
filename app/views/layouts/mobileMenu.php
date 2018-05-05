<div class="d-block d-sm-block d-md-none d-lg-none d-xl-none bg-dark  pt-2">
    <hr class="m-0">
    <div class="mobile-menu" id="mobile-menu">
        <a href="/">Gallery</a>
        <?php
        if (isset($_SESSION['authorization']) && !empty($_SESSION['authorization'])) {
            ?>
            <a class="nav-link" href="/gallery/montage">Make photo!</a>
            <a class="nav-link" href="/gallery/upload">My uploads</a>
            <a href="/account/settings">Account settings</a>
            <?php
        } ?>

        <a href="javascript:void(0);" onclick="myFunc()" class="mobile-menu-icon">
            <i class="fa fa-bars"></i>
        </a>
    </div>
</div>

<script>
    function myFunc() {
        var x = document.getElementById('mobile-menu');
        x.classList.toggle('mobile-menu-show');
    }
</script>