<?php
$userInfo   = Session::get('user');
$cart       = Session::get('cart');
$quantityCart   = (!empty($cart)) ? array_sum($cart['quantity']) : 0;

$linkHome       = URL::createLink($this->params['module'], 'index', 'index', null, 'trang-chu.html');
$linkRegister   = URL::createLink($this->params['module'], 'index', 'register', null, 'dang-ky.html');
$linkLogin      = URL::createLink($this->params['module'], 'index', 'login', null, 'dang-nhap.html');
$linkLogout     = URL::createLink($this->params['module'], 'user', 'logout', null, 'dang-xuat.html');
$linkProfile    = URL::createLink($this->params['module'], 'user', 'profile', null, 'tai-khoan.html');
$linkAdmin      = URL::createLink('backend', 'index', 'dashboard');
$linkCategory   = URL::createLink($this->params['module'], 'category', 'index', null, 'danh-muc.html');
$linkBook       = URL::createLink($this->params['module'], 'book', 'list', null, 'sach.html');
$linkCart       = URL::createLink($this->params['module'], 'user', 'cart', null, 'gio-hang.html');

$arrMenu = [
    ['text' => 'Đăng nhập', 'link' => $linkLogin],
    ['text' => 'Đăng ký', 'link' => $linkRegister]
];

if ($userInfo) {
    $arrMenu = [
        ['text' => 'Tài khoản', 'link' => $linkProfile],
        ['text' => 'Đăng xuất', 'link' => $linkLogout]
    ];

    if ($userInfo['group_acp'] == 1) {
        $arrMenu[] = ['text' => 'Admin Panel', 'link' => $linkAdmin];
    }

    $userName = $userInfo['info']['username'];
    $userName = strlen($userName) > 15 ? (substr($userName, 0, 15) . '...') : $userName;
}
$userMenu = HelperFrontend::createMenu($arrMenu, 'onhover-show-div');


// Menu category
function listCategory()
{
    $model = new Model();

    $query[]     = 'SELECT `id`, `name` FROM `' . TBL_CATEGORY . '`';
    $query[]     = "WHERE `status` = 'active'";
    $query[]     = "ORDER BY `ordering` ASC";

    $query              = implode(" ", $query);
    $listCategory       = $model->fetchAll($query);
    return $listCategory;
}

$listCategory = listCategory();
$xhtmlCats = '';
if (!empty($listCategory)) {
    foreach ($listCategory as $value) {
        $nameURL = URL::filterURL($value['name']);
        $link = URL::createLink($this->params['module'], 'book', 'list', ['category_id' => $value['id']], "$nameURL-{$value['id']}.html");
        $xhtmlCats .= sprintf('<li><a href="%s">%s</a></li>', $link, $value['name']);
    }
}

$controller = !empty($this->params['controller']) ? $this->params['controller'] : 'index';
$action     = !empty($this->params['action']) ? $this->params['action'] : 'index';
?>
<header class="my-header sticky">
    <div class="mobile-fix-option"></div>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="main-menu">
                    <div class="menu-left">
                        <div class="brand-logo">
                            <a href="<?= $linkHome; ?>">
                                <h2 class="mb-0" style="color: #ff9e3e">BookStore</h2>
                            </a>
                        </div>
                    </div>
                    <div class="menu-right pull-right">
                        <div>
                            <nav id="main-nav">
                                <div class="toggle-nav"><i class="fa fa-bars sidebar-bar"></i></div>
                                <ul id="main-menu" class="sm pixelstrap sm-horizontal">
                                    <li>
                                        <div class="mobile-back text-right">Back<i class="fa fa-angle-right pl-2" aria-hidden="true"></i></div>
                                    </li>
                                    <li><a href="<?= $linkHome; ?>" data-active="index-index">Trang chủ</a></li>
                                    <li><a href="<?= $linkBook; ?>" data-active="book-list">Sách</a></li>
                                    <li>
                                        <a href="<?= $linkCategory; ?>" data-active="category-index">Danh mục</a>
                                        <ul>
                                            <?= $xhtmlCats; ?>
                                        </ul>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                        <div class="top-header">
                            <ul class="header-dropdown">
                                <li class="onhover-dropdown mobile-account">
                                    <div style="display: flex;align-items: center">
                                        <img src="<?= $this->_pathImg ?>avatar.png" alt="avatar">
                                        <b><?= $userName ?? ''?></b>
                                    </div>

                                    <?= $userMenu ?>
                                </li>
                            </ul>
                        </div>
                        <div>
                            <div class="icon-nav">
                                <ul>
                                    <li class="onhover-div mobile-search">
                                        <div>
                                            <img src="<?= $this->_pathImg ?>search.png" onclick="openSearch()" class="img-fluid blur-up lazyload" alt="">
                                            <i class="ti-search" onclick="openSearch()"></i>
                                        </div>
                                        <div id="search-overlay" class="search-overlay">
                                            <div>
                                                <span class="closebtn" onclick="closeSearch()" title="Close Overlay">×</span>
                                                <div class="overlay-content">
                                                    <div class="container">
                                                        <div class="row">
                                                            <div class="col-xl-12">
                                                                <form action="" method="GET">
                                                                    <div class="form-group">
                                                                        <input type="text" class="form-control" name="search" id="search-input" placeholder="Tìm kiếm sách...">
                                                                    </div>
                                                                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="onhover-div mobile-cart">
                                        <div>
                                            <a href="<?= $linkCart;?>" id="cart" class="position-relative">
                                                <img src="<?= $this->_pathImg ?>cart.png" class="img-fluid blur-up lazyload" alt="cart">
                                                <i class="ti-shopping-cart"></i>
                                                <span class="badge badge-warning"><?= $quantityCart?></span>
                                            </a>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<script type="text/javascript">
    let controller = '<?= $controller?>';
    let action = '<?= $action?>';
    let dataActive = controller + '-' + action;

    document.querySelector(`a[data-active=${dataActive}]`).classList.add("my-menu-link", "active");
</script>