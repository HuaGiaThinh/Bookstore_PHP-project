<?php
$linkHome = URL::createLink('frontend', 'index', 'index');
?>
<div class="login-box">
    <!-- /.login-logo -->
    <div class="card card-outline card-info">
        <div class="card-header text-center">
            <h2 class="h2"><b>Admin Login</b></h2>
        </div>
        <div class="card-body">
            <p class="login-box-msg">Sign in to start your session</p>

            <form action="" method="POST">
                <?= ($this->errors ?? '') ?>
                <div class="input-group mb-3">
                    <input type="email" class="form-control" name="form[email]" placeholder="Email" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" name="form[password]" placeholder="Password" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-info btn-block">Sign In</button>
                <a href="<?= $linkHome; ?>" class="btn btn-danger btn-block">Cancel</a>
            </form>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>