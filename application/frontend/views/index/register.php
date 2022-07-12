<?php
if (isset($this->data)) $data = $this->data;
$linkLogin = URL::createLink($this->params['module'], $this->params['controller'], 'login');

$elements = [
    [
        'label'     => Form::label('Tên tài khoản'),
        'element'   => Form::input('text', 'form[username]', @$data['username'], 'form-control')
    ],
    [
        'label'     => Form::label('Họ và tên', false),
        'element'   => Form::input('text', 'form[fullname]', @$data['fullname'], 'form-control')
    ],
    [
        'label'     => Form::label('Email'),
        'element'   => Form::input('email', 'form[email]', @$data['email'], 'form-control')
    ],
    [
        'label'     => Form::label('Mật khẩu'),
        'element'   => Form::input('password', 'form[password]', '', 'form-control')
    ]
];

$xhtml = Form::showElements($elements, 'col-md-6');
$btnSubmit = HelperFrontend::createButton('submit', 'submit', 'register', 'submit', 'Tạo tài khoản', 'btn-solid');

// breadcrumb
$xhtmlBreadcrumb = HelperFrontend::createBreadcrumb('Đăng ký tài khoản');
?>

<?= $xhtmlBreadcrumb;?>
<section class="register-page section-b-space">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h3>Đăng ký tài khoản</h3>
                <?= $this->errors ?? '';?>
                <div class="theme-card">
                    <form action="" method="post" id="admin-form" class="theme-form">
                        <div class="form-row"><?= $xhtml;?></div>
                        <?= $btnSubmit?>
                        
                        <p style="margin-top: 20px; font-size: 16px">Bạn đã có tài khoản? Đăng nhập tại <a href="<?= $linkLogin;?>">đây</a></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>