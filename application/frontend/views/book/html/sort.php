<?php
$arrSort = [
    'price_asc'     => 'Giá tăng dần',
    'price_desc'    => 'Giá giảm dần',
    'latest'        => 'Mới nhất',
];

$selectBoxSort = HelperFrontend::select('sort', 'sort', $arrSort, @$this->params['sort']);
?>
<div class="product-page-filter">
    <form action="" id="sort-form" method="GET">
        <?= HelperFrontend::createInput('hidden', 'module', $this->params['module']) ?>
        <?= HelperFrontend::createInput('hidden', 'controller', $this->params['controller']) ?>
        <?= HelperFrontend::createInput('hidden', 'action', $this->params['action']) ?>

        <?php
        if (isset($this->params['category_id'])) echo HelperFrontend::createInput('hidden', 'category_id', $this->params['category_id']);
        ?>

        <?= $selectBoxSort; ?>
        <span style="margin-left: -30px;"><i class="fa fa-caret-down fa-2x text-secondary" aria-hidden="true"></i></span>
    </form>
</div>