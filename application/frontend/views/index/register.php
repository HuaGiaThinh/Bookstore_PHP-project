<?php
$data = $this->data;

?>
<div class="breadcrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="page-title">
                    <h2 class="py-2">Đăng ký tài khoản</h2>
                </div>
            </div>
        </div>
    </div>
</div>
<section class="register-page section-b-space">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h3>Đăng ký tài khoản</h3>
                <?= $this->errors ?? '';?>
                <div class="theme-card">
                    <form action="" method="post" id="admin-form" class="theme-form">
                        <div class="form-row">
                            <div class="col-md-6">
                                <label for="username" class="required">Tên tài khoản</label>
                                <input type="text" id="form[username]" name="form[username]" value="<?= @$data['username']?>" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="fullname">Họ và tên</label>
                                <input type="text" id="form[fullname]" name="form[fullname]" value="<?= @$data['fullname']?>" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="required">Email</label>
                                <input type="email" id="form[email]" name="form[email]" value="<?= @$data['email']?>" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="password" class="required">Mật khẩu</label>
                                <input type="password" id="form[password]" name="form[password]" value="<?= @$data['password']?>" class="form-control">
                            </div>
                        </div>
                        <!-- <input type="hidden" id="form[token]" name="form[token]" value="1599208957"> -->
                        <button type="submit" id="submit" name="submit" value="register" class="btn btn-solid">Tạo tài khoản</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>