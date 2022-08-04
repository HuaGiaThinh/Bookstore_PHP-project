<?php
$flagError = false;
$flagPayment = false;
$title = 'Trang thông báo';
$linkHome = URL::createLink($this->params['module'], $this->params['controller'], 'index');
switch ($this->params['type']) {
    case 'register-success':
        // $message    = 'Tài khoản của bạn đã được tạo thành công. Xin vui lòng đợi kích hoạt từ người quản trị';
        $message    = 'Tài khoản của bạn đã được tạo thành công!';
        break;
    case 'not-permission':
        $flagError  = true;
        $message    = 'Bạn không đủ quyền để truy cập vào chức năng này';
        break;
    case 'not-url':
        $flagError  = true;
        $message    = 'Đường dẫn không hợp lệ';
        break;
    case 'error':
        $flagError  = true;
        $message    = 'Có lỗi trong quá trình thực hiện';
        break;
    case 'updateProfile-success':
        $message    = 'Thông tin của bạn đã được cập nhật thành công';
        break;
    case 'payment-success':
        $flagPayment = true;
        $title = 'Mua hàng thành công';
        break;
}

$xhtmlMessage = '';
if ($flagError) $xhtmlMessage = '<h1>404</h1>';

if (isset($message)) $xhtmlMessage .= sprintf('<h2 style="line-height: 50px">%s</h2>', $message);

// breadcrumb
$xhtmlBreadcrumb = HelperFrontend::createBreadcrumb($title);

$linkOrderHistory    = URL::createLink($this->params['module'], 'user', 'orderHistory', null, 'lich-su-mua-hang.html');
?>

<?= $xhtmlBreadcrumb;?>
<?php if ($flagPayment) { ?>
    <section class="section-b-space">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="success-text"><i class="fa fa-check-circle" aria-hidden="true"></i>
                    <h2>Cảm ơn bạn đã mua hàng</h2>
                    <p>Hàng hóa sẽ được chuyển đến bạn trong thời gian sớm nhất</p>
                    <p>Mã đơn hàng: <b><?= $this->params['id'];?></b></p>
                    <a href="<?= $linkOrderHistory; ?>" class="btn btn-solid">Kiểm tra đơn hàng</a>
                </div>
            </div>
        </div>
    </div>
</section>
<?php } else {?>
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
<?php } ?>