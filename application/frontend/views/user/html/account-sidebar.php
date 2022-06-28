<?php
$linkHome       = URL::createLink($this->params['module'], $this->params['controller'], 'index');
$linkRegister   = URL::createLink($this->params['module'], $this->params['controller'], 'register');
$linkLogin      = URL::createLink($this->params['module'], $this->params['controller'], 'login');
$linkLogout     = URL::createLink($this->params['module'], $this->params['controller'], 'logout');
$linkPassword   = URL::createLink($this->params['module'], $this->params['controller'], 'changePassword');
$linkProfile    = URL::createLink($this->params['module'], 'user', 'profile');


$arrNavigation = [
    'profile' => [
        'link' => URL::createLink($this->params['module'], 'user', 'profile'),
        'text' => 'Thông tin tài khoản',
    ],
    'changePassword' => [
        'link' => URL::createLink($this->params['module'], $this->params['controller'], 'changePassword'),
        'text' => 'Thay đổi mật khẩu',
    ],
    'order-history' => [
        'link' => URL::createLink($this->params['module'], 'user', 'order-history'),
        'text' => 'Lịch sử mua hàng',
    ],
    'logout' => [
        'link' => URL::createLink($this->params['module'], $this->params['controller'], 'logout'),
        'text' => 'Đăng xuất',
    ],

];

$xhtmlNavigation =  HelperFrontend::createNav($arrNavigation, $this->params);
?>
<div class="account-sidebar">
    <a class="popup-btn">Menu</a>
</div>
<h3 class="d-lg-none">Tài khoản</h3>
<div class="dashboard-left">
    <div class="collection-mobile-back"><span class="filter-back"><i class="fa fa-angle-left" aria-hidden="true"></i> Ẩn</span></div>
    <div class="block-content">
        <ul><?= $xhtmlNavigation;?></ul>
    </div>
</div>