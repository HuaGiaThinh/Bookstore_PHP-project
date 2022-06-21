<!DOCTYPE html>
<html lang="en">

<head>
    <?= $this->_metaHTTP; ?>
    <?= $this->_metaName; ?>
    <title><?= $this->_title; ?></title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback" />
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <?= $this->_pluginCssFiles; ?>
    <?= $this->_cssFiles; ?>
</head>

<body class="hold-transition login-page">
    <?php
    require_once APPLICATION_PATH . $this->_moduleName . DS . 'views' . DS . $this->_fileView . '.php';
    ?>
    <!-- /.login-box -->

    <?= $this->_pluginJsFiles; ?>
    <?= $this->_jsFiles; ?>
</body>

</html>