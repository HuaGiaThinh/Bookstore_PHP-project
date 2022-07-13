<?php
$xhtmlCategory = '';
$xhtmlBooks = '';
if (!empty($this->topCategory)) {
    foreach ($this->topCategory as $key => $category) {
        $classCurrent = ($key == 0) ? 'class="current"' : '';
        $classDefault = ($key == 0) ? 'active default' : '';

        $xhtmlCategory .= sprintf('<li %s><a href="tab-category-%s" class="my-product-tab" data-category="%s">%s</a></li>', $classCurrent, $category['id'], $category['id'], $category['name']);

        $xhtmlBooks .= sprintf('<div id="tab-category-%s" class="tab-content %s">', $category['id'], $classDefault);

        $xhtmlBooks .= '<div class="no-slider row tab-content-inside">';

        // books in category
        $xhtmlBooks .= HelperFrontend::createXhtmlBooks($category['books'], $this->params);

        $categoryID         = $category['id'];
        $categoryNameURL    = URL::filterURL($category['name']);
        $linkCategory = URL::createLink($this->params['module'], 'book', 'list', ['category_id' => $category['id']], "$categoryNameURL-$categoryID.html");
        $xhtmlBooks .= sprintf('</div><div class="text-center"><a href="%s" class="btn btn-solid">Xem tất cả</a></div></div>', $linkCategory);
    }
}

?>
<div class="title1 section-t-space title5">
    <h2 class="title-inner1">Danh mục nổi bật</h2>
    <hr role="tournament6">
</div>
<section class="p-t-0 j-box ratio_asos">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="theme-tab">
                    <ul class="tabs tab-title">
                        <?= $xhtmlCategory; ?>
                    </ul>
                    <div class="tab-content-cls">
                        <?= $xhtmlBooks; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>