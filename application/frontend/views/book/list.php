<?php
$pageTitle = 'Tất cả sách';
foreach ($this->listCategory as $value) {
    if (isset($this->params['category_id']) && $this->params['category_id'] == $value['id']) {
        $pageTitle = $value['name'];
        $this->params['category_name'] = $value['name'];
        break;
    }
}

if (!empty($this->items)) {
    $items = $this->items;
    $xhtml = HelperFrontend::createXhtmlBooks($items, $this->params, true, 'col-xl-3 col-6 col-grid-box', true);
} else {
    $xhtml = '
        <div class="w-100 p-3 mt-2" id="empty-message">
            <h5 class="text-center alert alert-danger">Dữ liệu đang được cập nhật!</h5>
        </div>';
}

// pagination
$categoryName = URL::filterURL(@$this->params['category_name']);
$linkParams = isset($this->params['category_id']) ? ['category_id' => $this->params['category_id']] : '';
$route = isset($this->params['category_id']) ? "$categoryName-{$this->params['category_id']}" : 'sach';
$linkPage = URL::createLink($this->params['module'], $this->params['controller'], $this->params['action'], $linkParams, "$route.html?");
$xhtmlPagination = $this->pagination->showPaginationFrontend($linkPage);

// breadcrumb
$xhtmlBreadcrumb = HelperFrontend::createBreadcrumb($pageTitle);
?>

<?= $xhtmlBreadcrumb; ?>
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
                                    <!-- filter -->
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
                                                                <img src="<?= $this->_pathImg ?>/icon/2.png" alt="" class="product-2-layout-view">
                                                            </li>
                                                            <li class="my-layout-view" data-number="3">
                                                                <img src="<?= $this->_pathImg ?>/icon/3.png" alt="" class="product-3-layout-view">
                                                            </li>
                                                            <li class="my-layout-view active" data-number="4">
                                                                <img src="<?= $this->_pathImg ?>/icon/4.png" alt="" class="product-4-layout-view">
                                                            </li>
                                                            <li class="my-layout-view" data-number="6">
                                                                <img src="<?= $this->_pathImg ?>/icon/6.png" alt="" class="product-6-layout-view">
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <?php require_once 'html/sort.php'; ?>
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
                                    <?= $xhtmlPagination; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade bd-example-modal-lg theme-modal" id="quick-view" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content quick-view-modal">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">X</span></button>
                <div class="row">
                    <div class="col-lg-6 col-xs-12">
                        <div class="quick-view-img"><img src="" alt="" class="w-100 img-fluid blur-up lazyload book-picture"></div>
                    </div>
                    <div class="col-lg-6 rtl-text">
                        <div class="product-right">
                            <h2 class="book-name"></h2>
                            <h3 class="book-price"><del></del></h3>
                            <div class="border-product">
                                <div class="book-description"></div>
                            </div>
                            <div class="product-description border-product">
                                <h6 class="product-title">Số lượng</h6>
                                <div class="qty-box">
                                    <div class="input-group">
                                        <span class="input-group-prepend">
                                            <button type="button" class="btn quantity-left-minus" data-type="minus" data-field="">
                                                <i class="ti-angle-left"></i>
                                            </button>
                                        </span>
                                        <input type="text" name="quantity" class="form-control input-number" value="1">
                                        <span class="input-group-prepend">
                                            <button type="button" class="btn quantity-right-plus" data-type="plus" data-field="">
                                                <i class="ti-angle-right"></i>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="product-buttons">
                                <a href="#" class="btn btn-solid mb-1 btn-add-to-cart add-to-cart">Chọn Mua</a>
                                <a href="item.html" class="btn btn-solid mb-1 btn-view-book-detail">Xem chi tiết</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>