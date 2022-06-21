<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once 'html/head.php'; ?>
</head>

<body>
    <!-- <div class="loader_skeleton">
        <div class="typography_section">
            <div class="typography-box">
                <div class="typo-content loader-typo">
                    <div class="pre-loader"></div>
                </div>
            </div>
        </div>
    </div> -->

    <?php
    require_once APPLICATION_PATH . $this->_moduleName . DS . 'views' . DS . $this->_fileView . '.php';
    ?>


    <!-- phonering -->
    <?php require_once 'html/phonering.php'; ?>

    <!-- tap to top -->
    <?php require_once 'html/tap-to-top.php'; ?>
    <!-- tap to top end -->

    <?php require_once 'html/script.php'; ?>
</body>

</html>