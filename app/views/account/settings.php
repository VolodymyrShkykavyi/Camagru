<div class="row mt-3 mb-4">
    <div class="col-12">
        <div>
            <h2>Account</h2>
        </div>

        <div class="row">
            <div class="col-12 mb-3">
                <span class="text-success h6 mb-1">Change login</span>
                <form id="change-login" class="form-row vertical-center">
                    <input type="text" class="form-control mb-1 col-5" name="newLogin" placeholder="New username">
                    <div class="col-md-7 col-lg-7 col-sm-12  pl-2">
                        <span id="change-login-login-status" class="fa d-none preloader text-left"></span>
                    </div>
                    <input type="password" class="form-control mb-1 col-5" name="password"
                           placeholder="Yor password">
                    <div class="col-md-7 col-lg-7 col-sm-12 pl-2">
                        <span id="change-login-psw-status" class="fa d-none"></span>
                    </div>
                    <button type="button" name="submit" class="btn btn-primary shadow-none float-right">Change username</button>
                </form>
            </div>

            <div class="col-12 mb-3">
                <span class="text-success h6 mb-1">Change email</span>
                <form id="change-email" class="form-row vertical-center">
                    <input type="email" class="form-control mb-1 col-5" name="newEmail" placeholder="New E-Mail">
                    <div class="col-md-7 col-lg-7 col-sm-12 pl-2">
                        <span id="change-email-email-status" class="fa d-none text-left"></span>
                    </div>
                    <input type="password" class="form-control mb-1 col-5" name="password" placeholder="Yor password">
                    <div class="col-md-7 col-lg-7 col-sm-12 pl-2">
                        <span id="change-email-psw-status" class="fa d-none text-left"></span>
                    </div>
                    <button type="button" name="submit" class="btn btn-primary shadow-none float-right">Change E-Mail</button>
                </form>
            </div>

            <div class="col-12 mb-3">
                <span class="text-success h6 mb-1">Change password</span>
                <form id="change-password" class="form-row vertical-center">
                    <input type="password" class="form-control mb-1 col-5" name="CurrPassword"
                           placeholder="Current password" required>
                    <div class="col-md-7 col-lg-7 col-sm-12 pl-2">
                        <span id="change-psw-current-status" class="fa d-none text-left"></span>
                    </div>
                    <input type="password" class="form-control mb-1 col-5" name="NewPassword" placeholder="New password" required>
                    <div class="col-md-7 col-lg-7 col-sm-12 pl-2">
                        <span id="change-psw-new-status" class="fa d-none text-left"></span>
                    </div>
                    <input type="password" class="form-control mb-1 col-5" name="RepeatPassword"
                           placeholder="Repeat new password" required>
                    <div class="col-md-7 col-lg-7 col-sm-12 pl-2">
                        <span id="change-psw-repeat-status" class="fa d-none text-left"></span>
                    </div>
                    <button type="button" name="submit" class="btn btn-primary shadow-none float-right">Change password</button>
                </form>
            </div>
        </div>

        <hr>
    </div>
    <div class="col-12">
        <div>
            <h2>Notifications</h2>
        </div>
        <?php //TODO: load check from db?>
        <form id="change-notifications">
            <div class="form-check">
                <label class="form-check-label">
                    <input type="checkbox" class="form-check-input" name="like" checked>
                    Send an email when your image was liked
                </label>
            </div>
            <div class="form-check">
                <label class="form-check-label">
                    <input type="checkbox" class="form-check-input" name="comment" checked>
                    Send an email when your image was commented
                </label>
            </div>
            <button type="button" class="btn btn-primary mt-2" name="submit">Apply</button>
        </form>
        <hr>
    </div>
    <div class="col-12">
        <h2>smt</h2>
        sett
    </div>
</div>
<script src="/public/scripts/accountSettings.js"></script>