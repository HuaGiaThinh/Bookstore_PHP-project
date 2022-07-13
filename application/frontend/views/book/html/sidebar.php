<?php
// list category
$listCategory = $this->listCategory;
$xhtmlCategory = '';
if (!empty($listCategory)) {
    foreach ($listCategory as $category) {
        $categoryNameURl = URL::filterURL($category['name']);
        $link = URL::createLink($this->params['module'], 'book', 'list', ['category_id' => $category['id']], "$categoryNameURl-{$category['id']}.html");
        $classActive = (@$this->params['category_id'] == $category['id']) ? 'my-text-primary' : 'text-dark';
        $xhtmlCategory .= '
            <div class="custom-control custom-checkbox collection-filter-checkbox pl-0 category-item">
                <a class="' . $classActive . '" href="' . $link . '">' . $category['name'] . '</a>
            </div>';
    }
}

// special books
if (!empty($this->specialBooks)) {
    $xhtmlSpecialBooks = HelperFrontend::createSliderBooks($this->specialBooks, $this->params, 'SÁCH NỔI BẬT');
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

    <?= $xhtmlSpecialBooks;?>
    <!-- silde-bar colleps block end here -->
</div>