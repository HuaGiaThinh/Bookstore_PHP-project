<?php
// list category
$listCategory = $this->listCategory;
$xhtmlCategory = '';
if (!empty($listCategory)) {
    foreach ($listCategory as $category) {
        $link = URL::createLink($this->params['module'], 'book', 'list', ['category_id' => $category['id']]);
        $classActive = (@$this->params['category_id'] == $category['id']) ? 'my-text-primary' : 'text-dark';
        $xhtmlCategory .= '
            <div class="custom-control custom-checkbox collection-filter-checkbox pl-0 category-item">
                <a class="' . $classActive . '" href="' . $link . '">' . $category['name'] . '</a>
            </div>';
    }
}

// special books
$xhtmlSpecialBooks = '';
$i = 0;
if (!empty($this->specialBooks)) {
    $xhtmlSpecialBooks = '<div>';
    foreach ($this->specialBooks as $book) {
        $link = URL::createLink($this->params['module'], $this->params['controller'], 'detail', ['book_id' => $book['id']]);

        $picture = HelperFrontend::createPictureURL($book['picture'], $this->params);
        $name = (strlen($book['name']) > 50) ? (substr($book['name'], 0, 50) . '...') : $book['name'];
        $priceAfterSaleOff = HelperFrontend::priceSaleOff($book['price'], $book['sale_off']);

        if ($i == 4) $xhtmlSpecialBooks .= '</div><div>';
        $xhtmlSpecialBooks .= '
            <div class="media">
                <a href="' . $link . '">
                    <img style="width: 116px;height: 160px;"class="img-fluid blur-up lazyload" src="' . $picture . '" alt="' . $book['name'] . '">
                </a>
                <div class="media-body align-self-center">
                    <div class="rating">
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                    </div>
                    <a href="' . $link . '" title="' . $book['name'] . '">
                        <h6>' . $name . '</h6>
                    </a>
                    <h4 class="text-lowercase">' . $priceAfterSaleOff . ' đ</h4>
                </div>
            </div>';
        $i++;
    }
    $xhtmlSpecialBooks .= '</div>';
}
?>
<div class="col-sm-3 collection-filter">

    <!-- side-bar colleps block stat -->
    <div class="collection-filter-block">
        <!-- brand filter start -->
        <div class="collection-mobile-back"><span class="filter-back"><i class="fa fa-angle-left" aria-hidden="true"></i> back</span></div>
        <div class="collection-collapse-block open">
            <h3 class="collapse-block-title">Danh mục</h3>
            <div class="collection-collapse-block-content">
                <div class="collection-brand-filter">
                    <?= $xhtmlCategory; ?>
                    <div class="custom-control custom-checkbox collection-filter-checkbox pl-0 text-center">
                        <span class="text-dark font-weight-bold" id="btn-view-more">Xem thêm</span>
                    </div>
                </div>
            </div>
        </div>
    </div>



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
            </div> -->
        </div>
    </div>
    <!-- silde-bar colleps block end here -->
</div>