<?php
$items = $this->items;
$xhtml = '';
if (!empty($items)) {
    foreach ($items as $item) {
        $link = '#';

        $picturePath    = UPLOAD_PATH . $this->params['controller'] . DS . $item['picture'];
        $pictureURL     = UPLOAD_URL . '/default' . '/defaultImage.jpg';
        if (file_exists($picturePath)) {
            $pictureURL = UPLOAD_URL . $this->params['controller'] . DS . $item['picture'];
        }

        $xhtml .=
            '<div class="product-box">
                <div class="img-wrapper">
                    <div class="front">
                        <a href="' . $link . '">
                            <img src="' . $pictureURL . '" class="img-fluid blur-up lazyload bg-img" alt="">
                        </a>
                    </div>
                </div>
                <div class="product-detail">
                    <a href="' . $link . '">
                        <h4>' . $item['name'] . '</h4>
                    </a>
                </div>
            </div>';
    }
}
?>
<div class="breadcrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="page-title">
                    <h2 class="py-2">Danh mục sách</h2>
                </div>
            </div>
        </div>
    </div>
</div>
<section class="ratio_asos j-box pets-box section-b-space" id="category">
    <div class="container">
        <div class="no-slider five-product row">
            <!-- <div class="product-box">
                <div class="img-wrapper">
                    <div class="front">
                        <a href="list.html"><img src="images/product.jpg" class="img-fluid blur-up lazyload bg-img" alt=""></a>
                    </div>
                </div>
                <div class="product-detail">
                    <a href="list.html">
                        <h4>Bà mẹ - Em bé</h4>
                    </a>
                </div>
            </div> -->
            <?= $xhtml;?>
        </div>

        <!-- <div class="product-pagination">
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
                                <h5>Showing Items 1-15 of 22 Result</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
    </div>
</section>