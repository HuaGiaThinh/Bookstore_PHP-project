<?php
$linkFE         = URL::createLink('frontend', 'index', 'index');
$linkProfile    = URL::createLink($this->params['module'], 'user', 'profile');
$linkLogout     = URL::createLink($this->params['module'], 'index', 'logout');

$user = Session::get('user');
$userInfo = $user['info'];
?>
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

        <li class="nav-item">
            <a class="nav-link" href="<?= $linkFE; ?>" role="button">
                <i class="fas fa-eye"></i> View Site
            </a>
        </li>
        <li class="nav-item dropdown user-menu">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                <img src="<?= $this->_pathImg ?>avatar-cat.jpg" class="user-image img-circle elevation-2" alt="User Image">
                <span class="d-none d-md-inline"><?= ucfirst($userInfo['username']);?></span>
            </a>
            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">
                <!-- User image -->
                <li class="user-header bg-info">
                    <img src="<?= $this->_pathImg ?>avatar-cat.jpg" class="img-circle elevation-2" alt="User Image">

                    <p>
                        <?= ucfirst($userInfo['username']);?>
                        <small><?= $userInfo['email'];?></small>
                    </p>
                </li>
                <!-- Menu Footer-->
                <li class="user-footer">
                    <a href="<?= $linkProfile; ?>" class="btn btn-default btn-flat">Profile</a>
                    <a href="<?= $linkLogout; ?>" class="btn btn-default btn-flat float-right">Sign out</a>
                </li>
            </ul>
        </li>
    </ul>
</nav>