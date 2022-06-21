<?php
$linkHome = URL::createLink($this->params['module'], $this->params['controller'], 'index');
switch ($this->params['type']) {
    case 'register-success':
        $message    = 'Tài khoản của bạn đã được tạo thành công. Xin vui lòng đợi kích hoạt từ người quản trị!';
        break;
    case 'not-permission':
        $message    = 'Bạn không có quyền truy cập vào chức năng này!';
        break;
    case 'not-url':
        $message    = 'Đường dẫn không hợp lệ!';
        break;
}

?>
<div class="container title1 section-t-space"><h3><?= $message; ?><br>Click vào <a href="<?= $linkHome;?>">đây</a> để trở về trang chủ</h3></div>
