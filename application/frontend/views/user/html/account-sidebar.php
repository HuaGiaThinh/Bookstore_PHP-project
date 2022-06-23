<?php
$linkHome       = URL::createLink($this->params['module'], $this->params['controller'], 'index');
$linkRegister   = URL::createLink($this->params['module'], $this->params['controller'], 'register');
$linkLogin      = URL::createLink($this->params['module'], $this->params['controller'], 'login');
$linkLogout     = URL::createLink($this->params['module'], 'index', 'logout');
$linkProfile    = URL::createLink($this->params['module'], 'user', 'profile');

?>
<div class="account-sidebar">
    <a class="popup-btn">Menu</a>
</div>
<h3 class="d-lg-none">Tài khoản</h3>
<div class="dashboard-left">
    <div class="collection-mobile-back"><span class="filter-back"><i class="fa fa-angle-left" aria-hidden="true"></i> Ẩn</span></div>
    <div class="block-content">
        <ul>
            <li class="active"><a href="<?= $linkProfile;?>">Thông tin tài khoản</a></li>
            <li class=""><a href="change-password.html">Thay đổi mật khẩu</a></li>
            <li class=""><a href="order-history.html">Lịch sử mua hàng</a></li>
            <li class=""><a href="<?= $linkLogout;?>">Đăng xuất</a>
            </li>
        </ul>
    </div>
</div>