<?php
$linkHome = URL::createLink('frontend', 'index', 'index');

$iconEmail      = Form::createIconLogin('fas fa-envelope');
$iconPassword   = Form::createIconLogin('fas fa-lock');

$inputEmail     = Form::input('email', 'form[email]', '', 'form-control', 'placeholder="Email" required');
$inputPassword  = Form::input('password', 'form[password]', '', 'form-control', 'placeholder="Password" required');

$rowEmail       = Form::row($inputEmail, $iconEmail, 'input-group mb-3');
$rowPassword    = Form::row($inputPassword, $iconPassword, 'input-group mb-3');

$btnLogin   = HelperFrontend::createButton('submit', '', '', '', 'Sign In', 'btn-info btn-block');
$btnCancel  = HelperBackend::createButton($linkHome, 'danger', 'Cancel', false, false, 'btn-block')
?>
<div class="login-box">
    <div class="card card-outline card-info">
        <div class="card-header text-center">
            <h2 class="h2"><b>Admin Login</b></h2>
        </div>
        <div class="card-body">
            <p class="login-box-msg">Sign in to start your session</p>

            <form action="" method="POST">
                <?= ($this->errors ?? '') ?>
                <?= $rowEmail . $rowPassword;?>
                <?= $btnLogin . $btnCancel?>
            </form>
        </div>
    </div>
</div>