<?php
$xhtml = '';
if (!empty($this->specialBook)) {
    $items = $this->specialBook;
    foreach ($items as $item) {
        $linkItem = URL::createLink($this->params['module'], 'book', 'detail', ['book_id' => $item['id']]);

        $saleOff = HelperFrontend::showItemSaleOff($item['sale_off']);
        $name = (strlen($item['name']) > 25) ? (substr($item['name'], 0, 25) . '...') : $item['name'];

        $price = number_format($item['price'], 0, ',', '.');
        $price = ($saleOff != null) ? $price = '<del>' . $price . ' đ</del>' : '';
        $priceAfterSaleOff = $item['price'] - (($item['price'] * $item['sale_off']) / 100);
        $priceAfterSaleOff = number_format($priceAfterSaleOff, 0, ',', '.');

        $pictureURL = HelperFrontend::createPictureURL($item['picture'], $this->params);

        $linkQuickView = URL::createLink($this->params['module'], $this->params['controller'], 'ajaxQuickView', ['book_id' => $item['id']]);
        $xhtml .= '
            <div class="product-box">
                <div class="img-wrapper">' . $saleOff . '
                    <div class="front">
                        <a href="' . $linkItem . '">
                            <img src="' . $pictureURL . '" class="img-fluid blur-up lazyload bg-img" alt="">
                        </a>
                    </div>
                    <div class="cart-info cart-wrap">
                        <a href="#" title="Add to cart"><i class="ti-shopping-cart"></i></a>
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
                    <a href="' . $linkItem . '" title="' . $item['name'] . '">
                        <h6>' . $name . '</h6>
                    </a>
                    <h4 class="text-lowercase">' . $priceAfterSaleOff . ' đ ' . $price . '</h4>
                </div>
            </div>    
        ';
    }
}
?>
<!-- Title-->
<div class="title1 section-t-space title5">
    <h2 class="title-inner1">Sản phẩm nổi bật</h2>
    <hr role="tournament6">
</div>
<!-- Product slider -->
<section class="section-b-space p-t-0 j-box ratio_asos">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="product-4 product-m no-arrow">
                    <?= $xhtml; ?>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Product slider end -->