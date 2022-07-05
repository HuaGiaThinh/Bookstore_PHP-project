<?php
$xhtmlCategory = '';
$xhtmlBooks = '';
if (!empty($this->topCategory)) {
    foreach ($this->topCategory as $key => $category) {
        $classCurrent = ($key == 0) ? 'class="current"' : '';
        $classDefault = ($key == 0) ? 'active default' : '';

        $xhtmlCategory .= sprintf('<li %s><a href="tab-category-%s" class="my-product-tab" data-category="%s">%s</a></li>', $classCurrent, $category['id'], $category['id'], $category['name']);


        $xhtmlBooks .= '<div id="tab-category-' . $category['id'] . '" class="tab-content ' . $classDefault . '">';
        $xhtmlBooks .= '<div class="no-slider row tab-content-inside">';
        foreach ($category['books'] as $book) {
            $linkItem = URL::createLink($this->params['module'], 'book', 'detail', ['book_id' => $book['id']]);

            $saleOff = HelperFrontend::showItemSaleOff($book['sale_off']);
            $name = (strlen($book['name']) > 25) ? (substr($book['name'], 0, 25) . '...') : $book['name'];

            $price = number_format($book['price'], 0, ',', '.');
            $price = ($saleOff != null) ? $price = '<del>' . $price . ' đ</del>' : '';
            $priceAfterSaleOff = HelperFrontend::priceAfterSaleOff($book['price'], $book['sale_off']);

            $linkOrder = URL::createLink($this->params['module'], 'user', 'order', ['book_id' => $book['id'], 'price' => $priceAfterSaleOff]);

            $priceAfterSaleOff = number_format($priceAfterSaleOff, 0, ',', '.');
            $pictureURL = HelperFrontend::createPictureURL($book['picture'], $this->params);

            $linkQuickView = URL::createLink($this->params['module'], $this->params['controller'], 'ajaxQuickView', ['book_id' => $book['id']]);

            $xhtmlBooks .= '
                <div class="product-box">
                    <div class="img-wrapper">' . $saleOff . '
                        <div class="front">
                            <a href="'.$linkItem.'">
                                <img src="' . $pictureURL . '" class="img-fluid blur-up lazyload bg-img" alt="' . $book['name'] . '">
                            </a>
                        </div>
                        <div class="cart-info cart-wrap">
                            <a href="'.$linkOrder.'" class="add-to-cart" title="Add to cart"><i class="ti-shopping-cart"></i></a>
                            <a href="' . $linkQuickView . '" title="Quick View" class="quick-view"><i class="ti-search" data-toggle="modal" data-target="#quick-view"></i></a>
                        </div>
                    </div>
                    <div class="product-detail">
                        <div class="rating">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                        </div>
                        <a href="'.$linkItem.'" title="' . $book['name'] . '">
                            <h6>' . $name . '</h6>
                        </a>
                        <h4 class="text-lowercase">' . $priceAfterSaleOff . ' đ ' . $price . '</h4>
                    </div>
                </div>
            ';
        }
        $linkCategory = URL::createLink($this->params['module'], 'book', 'list', ['category_id' => $category['id']]);
        $xhtmlBooks .= '</div><div class="text-center"><a href="' . $linkCategory . '" class="btn btn-solid">Xem tất cả</a></div></div>';
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