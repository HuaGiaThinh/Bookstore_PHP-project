<?php
$xhtmlSpecialBooks = '';
$i = 0;
if (!empty($this->specialBooks)) {
    $xhtmlSpecialBooks = '<div>';
    foreach ($this->specialBooks as $book) {
        $link = URL::createLink($this->params['module'], $this->params['controller'], 'detail', ['book_id' => $book['id']]);

        $picture = HelperFrontend::createPictureURL($book['picture'], $this->params);
        $name = (strlen($book['name']) > 15) ? (substr($book['name'], 0, 15) . '...') : $book['name'];
        $priceAfterSaleOff = HelperFrontend::priceSaleOff($item['price'], $item['sale_off']);

        if ($i == 4) $xhtmlSpecialBooks .= '</div><div>';
        $xhtmlSpecialBooks .= '
            <div class="media">
                <a href="'.$link.'">
                    <img style="width: 116px;height: 160px;"class="img-fluid blur-up lazyload" src="'.$picture.'" alt="'.$book['name'].'">
                </a>
                <div class="media-body align-self-center">
                    <div class="rating">
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                    </div>
                    <a href="'.$link.'" title="'.$book['name'].'">
                        <h6>'.$name.'</h6>
                    </a>
                    <h4 class="text-lowercase">'.$priceAfterSaleOff.' đ</h4>
                </div>
            </div>';       
        $i++;
    }
    $xhtmlSpecialBooks .= '</div>';
}
?>
<div class="theme-card">
    <h5 class="title-border">Sách nổi bật</h5>
    <div class="offer-slider slide-1">
        <?= $xhtmlSpecialBooks;?>
        <!-- <div>
            <div class="media">
                <a href="item.html">
                    <img class="img-fluid blur-up lazyload" src="images/product.jpg" alt="Cẩm Nang Cấu Trúc Tiếng Anh"></a>
                <div class="media-body align-self-center">
                    <div class="rating">
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                    </div>
                    <a href="item.html" title="Cẩm Nang Cấu Trúc Tiếng Anh">
                        <h6>Cẩm Nang Cấu Trúc Tiếng Anh</h6>
                    </a>
                    <h4 class="text-lowercase">48,020 đ</h4>
                </div>
            </div>
            <div class="media">
                <a href="item.html">
                    <img class="img-fluid blur-up lazyload" src="images/product.jpg" alt="Cẩm Nang Cấu Trúc Tiếng Anh"></a>
                <div class="media-body align-self-center">
                    <div class="rating">
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                    </div>
                    <a href="item.html" title="Cẩm Nang Cấu Trúc Tiếng Anh">
                        <h6>Cẩm Nang Cấu Trúc Tiếng Anh</h6>
                    </a>
                    <h4 class="text-lowercase">48,020 đ</h4>
                </div>
            </div>
            <div class="media">
                <a href="item.html">
                    <img class="img-fluid blur-up lazyload" src="images/product.jpg" alt="Cẩm Nang Cấu Trúc Tiếng Anh"></a>
                <div class="media-body align-self-center">
                    <div class="rating">
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                    </div>
                    <a href="item.html" title="Cẩm Nang Cấu Trúc Tiếng Anh">
                        <h6>Cẩm Nang Cấu Trúc Tiếng Anh</h6>
                    </a>
                    <h4 class="text-lowercase">48,020 đ</h4>
                </div>
            </div>
            <div class="media">
                <a href="item.html">
                    <img class="img-fluid blur-up lazyload" src="images/product.jpg" alt="Cẩm Nang Cấu Trúc Tiếng Anh"></a>
                <div class="media-body align-self-center">
                    <div class="rating">
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                    </div>
                    <a href="item.html" title="Cẩm Nang Cấu Trúc Tiếng Anh">
                        <h6>Cẩm Nang Cấu Trúc Tiếng Anh</h6>
                    </a>
                    <h4 class="text-lowercase">48,020 đ</h4>
                </div>
            </div>
        </div>
        <div>
            <div class="media">
                <a href="item.html">
                    <img class="img-fluid blur-up lazyload" src="images/product.jpg" alt="Cẩm Nang Cấu Trúc Tiếng Anh"></a>
                <div class="media-body align-self-center">
                    <div class="rating">
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                    </div>
                    <a href="item.html" title="Cẩm Nang Cấu Trúc Tiếng Anh">
                        <h6>Cẩm Nang Cấu Trúc Tiếng Anh</h6>
                    </a>
                    <h4 class="text-lowercase">48,020 đ</h4>
                </div>
            </div>
            <div class="media">
                <a href="item.html">
                    <img class="img-fluid blur-up lazyload" src="images/product.jpg" alt="Cẩm Nang Cấu Trúc Tiếng Anh"></a>
                <div class="media-body align-self-center">
                    <div class="rating">
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                    </div>
                    <a href="item.html" title="Cẩm Nang Cấu Trúc Tiếng Anh">
                        <h6>Cẩm Nang Cấu Trúc Tiếng Anh</h6>
                    </a>
                    <h4 class="text-lowercase">48,020 đ</h4>
                </div>
            </div>
            <div class="media">
                <a href="item.html">
                    <img class="img-fluid blur-up lazyload" src="images/product.jpg" alt="Cẩm Nang Cấu Trúc Tiếng Anh"></a>
                <div class="media-body align-self-center">
                    <div class="rating">
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                    </div>
                    <a href="item.html" title="Cẩm Nang Cấu Trúc Tiếng Anh">
                        <h6>Cẩm Nang Cấu Trúc Tiếng Anh</h6>
                    </a>
                    <h4 class="text-lowercase">48,020 đ</h4>
                </div>
            </div>
            <div class="media">
                <a href="item.html">
                    <img class="img-fluid blur-up lazyload" src="images/product.jpg" alt="Cẩm Nang Cấu Trúc Tiếng Anh"></a>
                <div class="media-body align-self-center">
                    <div class="rating">
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                    </div>
                    <a href="item.html" title="Cẩm Nang Cấu Trúc Tiếng Anh">
                        <h6>Cẩm Nang Cấu Trúc Tiếng Anh</h6>
                    </a>
                    <h4 class="text-lowercase">48,020 đ</h4>
                </div>
            </div>
        </div> -->
    </div>
</div>