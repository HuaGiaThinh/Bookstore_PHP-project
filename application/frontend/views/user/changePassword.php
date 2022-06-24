<?php
$data = $this->data;
$elements = [
    [
        'label'     => Form::label('Mật khẩu cũ'),
        'element'   => Form::input('password', 'form[old_password]', '', 'form-control')
    ],
    [
        'label'     => Form::label('Mật khẩu mới'),
        'element'   => Form::input('password', 'form[password]', '', 'form-control')
    ],
    [
        'label'     => Form::label('Nhập lại mật khẩu mới'),
        'element'   => Form::input('password', 'form[confirm_password]', '', 'form-control')
    ],
];

$xhtml = Form::showElements($elements);
?>
<div class="breadcrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="page-title">
                    <h2 class="py-2">Đổi mật khẩu</h2>
                </div>
            </div>
        </div>
    </div>
</div>

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
                            <?= @$this->errors?>
                            <?= $xhtml?>
                            <!-- <input type="hidden" id="form[token]" name="form[token]" value="1599258345"> -->
                            <button type="submit" id="submit" name="submit" value="Cập nhật thông tin" class="btn btn-solid btn-sm">Cập nhật thông tin</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>