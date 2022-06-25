<?php
$linkHome = URL::createLink($this->params['module'], 'dashboard', 'index');

$arrNavigation = [
    [
        'linkNav' => URL::createLink($this->params['module'], 'dashboard', 'index'),
        'name' => 'Dashboard',
        'icon' => 'fa-tachometer-alt',

    ],
    [
        'name' => 'Group',
        'icon' => 'fa-users',
        'navChild' => [
            'linkList'  => URL::createLink($this->params['module'], 'group', 'index'),
            'linkAdd'   => URL::createLink($this->params['module'], 'group', 'form')
        ]

    ],
    [
        'name' => 'User',
        'icon' => 'fa-user',
        'navChild' => [
            'linkList'  => URL::createLink($this->params['module'], 'user', 'index'),
            'linkAdd'   => URL::createLink($this->params['module'], 'user', 'form')
        ]

    ],
    [
        'name' => 'Category',
        'icon' => 'fa-thumbtack',
        'navChild' => [
            'linkList'  => URL::createLink($this->params['module'], 'category', 'index'),
            'linkAdd'   => URL::createLink($this->params['module'], 'user', 'form')
        ]

    ],
    [
        'name' => 'Book',
        'icon' => 'fa-book-open',
        'navChild' => [
            'linkList'  => URL::createLink($this->params['module'], 'book', 'index'),
            'linkAdd'   => URL::createLink($this->params['module'], 'book', 'form')
        ]
    ],
    [
        'linkNav' => URL::createLink($this->params['module'], 'user', 'changePassword'),
        'name' => 'ChangePassword',
        'icon' => 'fa-key',
    ],
];

$xhtmlNavigation =  HelperFrontend::createNav($arrNavigation, $this->params);
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
                <a href="#" class="d-block"><?= ucfirst($userInfo['username']); ?></a>
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