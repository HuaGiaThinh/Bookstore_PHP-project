<?php
foreach ($this->listCategory as $value) {
    if (isset($this->params['category_id']) && $this->params['category_id'] == $value['id']) {
        $pageTitle = $value['name'];
        break;
    }
}

$xhtml = '';
if (!empty($this->items)) {
    $items = $this->items;
    foreach ($items as $item) {
        $linkItem = '#';

        $saleOff = HelperFrontend::showItemSaleOff($item['sale_off']);
        $name = (strlen($item['name']) > 25) ? (substr($item['name'], 0, 25) . '...') : $item['name'];

        $price = number_format($item['price'], 0, ',', '.');
        $price = ($saleOff != null) ? $price = '<del>' . $price . ' đ</del>' : '';
        $priceAfterSaleOff = $item['price'] - (($item['price'] * $item['sale_off']) / 100);
        $priceAfterSaleOff = number_format($priceAfterSaleOff, 0, ',', '.');

        $picturePath    = UPLOAD_PATH . $this->params['controller'] . DS . $item['picture'];

        $pictureURL     = UPLOAD_URL . '/default' . '/defaultImage.jpg';
        if (file_exists($picturePath)) {
            $pictureURL = UPLOAD_URL . $this->params['controller'] . DS . $item['picture'];
        }

        $xhtml .= '
            <div class="col-xl-3 col-6 col-grid-box">
                <div class="product-box">
                    <div class="img-wrapper">' . $saleOff . '
                        <div class="front">
                            <a href="' . $linkItem . '">
                                <img src="' . $pictureURL . '" class="img-fluid blur-up lazyload bg-img" alt="">
                            </a>
                        </div>
                        <div class="cart-info cart-wrap">
                            <a href="#" title="Add to cart"><i class="ti-shopping-cart"></i></a>
                            <a href="#" title="Quick View"><i class="ti-search" data-toggle="modal" data-target="#quick-view"></i></a>
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
                        <p>' . $item['description'] . '</p>
                        <h4 class="text-lowercase">' . $priceAfterSaleOff . ' đ ' . $price . '</h4>
                    </div>
                </div>
            </div>        
        ';
    }
} else {
    $xhtml = '
        <div class="w-100 p-3 mt-2" id="empty-message">
            <h5 class="text-center alert alert-danger">Dữ liệu đang được cập nhật!</h5>
        </div>';
}

?>
<div class="breadcrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="page-title">
                    <h2 class="py-2"><?= $pageTitle ?? 'Tất cả sách'; ?></h2>
                </div>
            </div>
        </div>
    </div>
</div>
<section class="section-b-space j-box ratio_asos">
    <div class="collection-wrapper">
        <div class="container">
            <div class="row">
                <?php require_once 'html/sidebar.php'; ?>
                <div class="collection-content col">
                    <div class="page-main-content">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="collection-product-wrapper">
                                    <div class="product-top-filter">
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <div class="filter-main-btn">
                                                    <span class="filter-btn btn btn-theme"><i class="fa fa-filter" aria-hidden="true"></i> Filter</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="product-filter-content">
                                                    <div class="collection-view">
                                                        <ul>
                                                            <li><i class="fa fa-th grid-layout-view"></i></li>
                                                            <li><i class="fa fa-list-ul list-layout-view"></i></li>
                                                        </ul>
                                                    </div>
                                                    <div class="collection-grid-view">
                                                        <ul>
                                                            <li class="my-layout-view" data-number="2">
                                                                <img src="images/icon/2.png" alt="" class="product-2-layout-view">
                                                            </li>
                                                            <li class="my-layout-view" data-number="3">
                                                                <img src="images/icon/3.png" alt="" class="product-3-layout-view">
                                                            </li>
                                                            <li class="my-layout-view active" data-number="4">
                                                                <img src="images/icon/4.png" alt="" class="product-4-layout-view">
                                                            </li>
                                                            <li class="my-layout-view" data-number="6">
                                                                <img src="images/icon/6.png" alt="" class="product-6-layout-view">
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="product-page-filter">
                                                        <form action="" id="sort-form" method="GET">
                                                            <select id="sort" name="sort">
                                                                <option value="default" selected> - Sắp xếp - </option>
                                                                <option value="price_asc">Giá tăng dần</option>
                                                                <option value="price_desc">Giá giảm dần</option>
                                                                <option value="latest">Mới nhất</option>
                                                            </select>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <!-- content -->
                                    <div class="product-wrapper-grid" id="my-product-list">
                                        <div class="row margin-res">
                                            <?= $xhtml; ?>
                                        </div>
                                    </div>


                                    <!-- pagination -->
                                    <div class="product-pagination">
                                        <div class="theme-paggination-block">
                                            <div class="container-fluid p-0">
                                                <div class="row">
                                                    <div class="col-xl-6 col-md-6 col-sm-12">
                                                        <nav aria-label="Page navigation">
                                                            <nav>
                                                                <ul class="pagination">
                                                                    <li class="page-item disabled">
                                                                        <a href="" class="page-link"><i class="fa fa-angle-double-left"></i></a>
                                                                    </li>
                                                                    <li class="page-item disabled">
                                                                        <a href="" class="page-link"><i class="fa fa-angle-left"></i></a>
                                                                    </li>
                                                                    <li class="page-item active">
                                                                        <a class="page-link">1</a>
                                                                    </li>
                                                                    <li class="page-item">
                                                                        <a class="page-link" href="#">2</a>
                                                                    </li>
                                                                    <li class="page-item">
                                                                        <a class="page-link" href="#">3</a>
                                                                    </li>
                                                                    <li class="page-item">
                                                                        <a class="page-link" href="#"><i class="fa fa-angle-right"></i></a>
                                                                    </li>
                                                                    <li class="page-item">
                                                                        <a class="page-link" href="#"><i class="fa fa-angle-double-right"></i></a>
                                                                    </li>
                                                                </ul>
                                                            </nav>
                                                        </nav>
                                                    </div>
                                                    <div class="col-xl-6 col-md-6 col-sm-12">
                                                        <div class="product-search-count-bottom">
                                                            <h5>Showing Items 1-12 of 55 Result</h5>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>