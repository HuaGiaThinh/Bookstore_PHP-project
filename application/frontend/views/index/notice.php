<?php
$flagError = false;
$linkHome = URL::createLink($this->params['module'], $this->params['controller'], 'index');
switch ($this->params['type']) {
    case 'register-success':
        $message    = 'Tài khoản của bạn đã được tạo thành công. Xin vui lòng đợi kích hoạt từ người quản trị';
        break;
    case 'not-permission':
        $flagError  = true;
        $message    = 'Bạn không đủ quyền để truy cập vào chức năng này';
        break;
    case 'not-url':
        $flagError  = true;
        $message    = 'Đường dẫn không hợp lệ';
        break;
    case 'updateProfile-success':
        $message    = 'Thông tin của bạn đã được cập nhật thành công';
        break;
}

$xhtmlMessage = '';
if ($flagError) $xhtmlMessage = '<h1>404</h1>';

$xhtmlMessage .= "<h2>$message</h2>";
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
<section class="p-0">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="error-section">
                    <?= $xhtmlMessage; ?>
                    <a href="<?= $linkHome; ?>" class="btn btn-solid">Quay lại trang chủ</a>
                </div>
            </div>
        </div>
    </div>
</section>