<?php
$linkHome       = URL::createLink($this->params['module'], 'index', 'dashboard');
$linkProfile    = URL::createLink($this->params['module'], 'user', 'profile');

$arrNavigation = [
    [
        'linkNav' => URL::createLink($this->params['module'], 'index', 'dashboard'),
        'name' => 'Dashboard',
        'class' => 'index',
        'icon' => 'fa-tachometer-alt',

    ],
    [
        'linkNav' => URL::createLink($this->params['module'], 'group', 'index'),
        'name' => 'Group',
        'class' => 'group',
        'icon' => 'fa-users',
    ],
    [
        'name' => 'User',
        'icon' => 'fa-user',
        'class' => 'user',
        'navChild' => [
            'linkList'  => URL::createLink($this->params['module'], 'user', 'index'),
            'linkForm'   => URL::createLink($this->params['module'], 'user', 'form'),
            'classChild-list' => 'user-index',
            'classChild-form' => 'user-form'
        ]

    ],
    [
        'name' => 'Category',
        'icon' => 'fa-thumbtack',
        'class' => 'category',
        'navChild' => [
            'linkList'  => URL::createLink($this->params['module'], 'category', 'index'),
            'linkForm'   => URL::createLink($this->params['module'], 'category', 'form'),
            'classChild-list' => 'category-index',
            'classChild-form' => 'category-form',
        ]

    ],
    [
        'name' => 'Book',
        'icon' => 'fa-book-open',
        'class' => 'book',
        'navChild' => [
            'linkList'  => URL::createLink($this->params['module'], 'book', 'index'),
            'linkForm'   => URL::createLink($this->params['module'], 'book', 'form'),
            'classChild-list' => 'book-index',
            'classChild-form' => 'book-form',
        ]
    ],
    [
        'linkNav' => URL::createLink($this->params['module'], 'user', 'changePassword'),
        'name' => 'ChangePassword',
        'class' => 'changePassword',
        'icon' => 'fa-key',
    ],
];

$xhtmlNavigation =  HelperBackend::createNav($arrNavigation);
?>
<aside class="main-sidebar sidebar-dark-info elevation-4">
    <!-- Brand Logo -->
    <a href="<?= $linkHome; ?>" class="brand-link">
        <img src="<?= $this->_pathImg ?>logo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: 0.8" />
        <span class="brand-text font-weight-light">Admin Control Panel</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?= $this->_pathImg ?>avatar.jpg" class="img-circle elevation-2" alt="User Image" />
            </div>
            <div class="info">
                <a href="<?= $linkProfile; ?>" class="d-block"><?= ucfirst($userInfo['username']); ?></a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
                <?= $xhtmlNavigation ?>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>