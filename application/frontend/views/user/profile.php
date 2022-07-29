<?php
$data = $this->data;
$elements = [
    [
        'label'     => Form::label('Email', false),
        'element'   => Form::input('email', 'form[email]', @$data['email'], 'form-control', 'readOnly')
    ],
    [
        'label'     => Form::label('Họ và tên', false),
        'element'   => Form::input('text', 'form[fullname]', @$data['fullname'], 'form-control')
    ],
    [
        'label'     => Form::label('Số điện thoại', false),
        'element'   => Form::input('number', 'form[phone]', @$data['phone'], 'form-control')
    ],
    [
        'label'     => Form::label('Địa chỉ', false),
        'element'   => Form::input('text', 'form[address]', @$data['address'], 'form-control')
    ]
];

$xhtml = Form::showElements($elements);

// breadcrumb
$xhtmlBreadcrumb = HelperFrontend::createBreadcrumb('Thông Tin Tài khoản');
?>

<?= $xhtmlBreadcrumb;?>
<section class="faq-section section-b-space">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <?php require_once 'html/account-sidebar.php'; ?>
            </div>
            <div class="col-lg-9">
                <div class="dashboard-right">
                    <div class="dashboard">
                        <form action="" method="post" id="admin-form" class="theme-form">
                            <?= $xhtml?>
                            <button type="submit" id="submit" name="submit" value="Cập nhật thông tin" class="btn btn-solid btn-sm">Cập nhật thông tin</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>