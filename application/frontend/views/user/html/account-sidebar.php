<?php
$linkLogout     = URL::createLink($this->params['module'], $this->params['controller'], 'logout', null, 'dang-xuat.html');
$linkPassword   = URL::createLink($this->params['module'], $this->params['controller'], 'changePassword', null, 'thay-doi-mat-khau.html');
$linkProfile    = URL::createLink($this->params['module'], 'user', 'profile', null, 'tai-khoan.html');
$linkOrderHistory    = URL::createLink($this->params['module'], 'user', 'orderHistory', null, 'lich-su-mua-hang.html');


$arrNavigation = [
    'profile' => [
        'link' => $linkProfile,
        'text' => 'Thông tin tài khoản',
    ],
    'changePassword' => [
        'link' => $linkPassword,
        'text' => 'Thay đổi mật khẩu',
    ],
    'orderHistory' => [
        'link' => $linkOrderHistory,
        'text' => 'Lịch sử mua hàng',
    ],
    'logout' => [
        'link' => $linkLogout,
        'text' => 'Đăng xuất',
    ],

];

$xhtmlNavigation =  HelperFrontend::createNav($arrNavigation, $this->params);
?>
<div class="account-sidebar">
    <a class="popup-btn">Menu</a>
</div>
<div class="dashboard-left">
    <div class="collection-mobile-back"><span class="filter-back"><i class="fa fa-angle-left" aria-hidden="true"></i> Ẩn</span></div>
    <div class="block-content">
        <ul><?= $xhtmlNavigation;?></ul>
    </div>
</div>