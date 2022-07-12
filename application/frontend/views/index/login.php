<?php
$linkRegister = URL::createLink($this->params['module'], $this->params['controller'], 'register');

$elements = [
    [
        'label'     => Form::label('Email'),
        'element'   => Form::input('email', 'form[email]', '', 'form-control', 'required')
    ],
    [
        'label'     => Form::label('Mật khẩu'),
        'element'   => Form::input('password', 'form[password]', '', 'form-control', 'required')
    ]
];

$xhtml = Form::showElements($elements);
$btnSubmit = HelperFrontend::createButton('submit', 'submit', 'login', 'submit', 'Đăng nhập', 'btn-solid');

// breadcrumb
$xhtmlBreadcrumb = HelperFrontend::createBreadcrumb('Đăng nhập');
?>

<?= $xhtmlBreadcrumb;?>
<section class="login-page section-b-space">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <h3>Đăng nhập</h3>
                <div class="theme-card">
                    <form action="" method="post" id="admin-form" class="theme-form" name="login-form">
                        <?= @$this->errors; ?>
                        <?= $xhtml; ?>
                        <?= $btnSubmit; ?>
                    </form>
                </div>
            </div>
            <div class="col-lg-6 right-login">
                <h3>Khách hàng mới</h3>
                <div class="theme-card authentication-right">
                    <h6 class="title-font">Đăng ký tài khoản</h6>
                    <p>Sign up for a free account at our store. Registration is quick and easy. It allows you to be
                        able to order from our shop. To start shopping click register.</p>
                    <a href="<?= $linkRegister; ?>" class="btn btn-solid">Đăng ký</a>
                </div>
            </div>
        </div>
    </div>
</section>