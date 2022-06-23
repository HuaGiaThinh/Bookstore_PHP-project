<?php
$linkHome = URL::createLink($this->params['module'], $this->params['controller'], 'index');
switch ($this->params['type']) {
    case 'register-success':
        $message    = 'Tài khoản của bạn đã được tạo thành công. Xin vui lòng đợi kích hoạt từ người quản trị!';
        break;
    case 'not-permission':
        $message    = 'Bạn không đủ quyền để truy cập vào chức năng này!';
        break;
    case 'not-url':
        $message    = 'Đường dẫn không hợp lệ!';
        break;
}

?>
<div class="breadcrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="page-title">
                    <h2 class="py-2">Trang thông báo</h2>
                </div>
            </div>
        </div>
    </div>
</div>
<section class="section-b-space">
    <div class="container title1 section-t-space">
        <h3 style="color: #fb5353;"><?= $message; ?> Click vào <a href="<?= $linkHome; ?>">đây</a> để trở về trang chủ
        </h3>
    </div>
</section>