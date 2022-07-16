<?php
$linkSubmit     = URL::createLink($this->params['module'], $this->params['controller'], 'buy');
$linkDeleteAll  = URL::createLink($this->params['module'], 'user', 'removeItemFromCart', ['book_id' => 'all']);
$xhtml = '';
$priceTotal = 0;
if (!empty($this->items)) {
    foreach ($this->items as $item) {
        $priceTotal += $item['totalPrice'];
        $linkItem   = URL::createLink($this->params['module'], 'book', 'detail', ['book_id' => $item['id']]);
        $pictureURL = HelperFrontend::createPictureURL($item['picture'], $this->params);
        $price      = number_format($item['price'], 0, ',', '.');
        $totalPrice = number_format($item['totalPrice'], 0, ',', '.');
        $linkInputQuantity = URL::createLink($this->params['module'], 'index', 'order', ['book_id' => $item['id'], 'price' => $item['price']]);
        $linkRemoveItem = URL::createLink($this->params['module'], 'user', 'removeItemFromCart', ['book_id' => $item['id']]);
        $xhtml .= '
            <tr>
                <td>
                    <a href="' . $linkItem . '"><img src="' . $pictureURL . '" alt="' . $item['name'] . '"></a>
                </td>
                <td><a href="' . $linkItem . '">' . $item['name'] . '</a>
                    <div class="mobile-cart-content row">
                        <div class="col-xs-3">
                            <div class="qty-box">
                                <div class="input-group">
                                    <input type="number" name="quantity" value="' . $item['quantity'] . '" class="form-control input-number" id="quantity-10" min="1">
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-3">
                            <h2 class="td-color text-lowercase">' . $price . ' đ</h2>
                        </div>
                        <div class="col-xs-3">
                            <h2 class="td-color text-lowercase">
                                <a href="#" class="icon"><i class="ti-close"></i></a>
                            </h2>
                        </div>
                    </div>
                </td>
                <td>
                    <h2 class="text-lowercase">' . $price . ' đ</h2>
                </td>
                <td>
                    <div class="qty-box">
                        <div class="input-group">
                            <input type="number" name="quantity" value="' . $item['quantity'] . '" class="form-control input-number" id="quantity-' . $item['id'] . '" min="1"
                             data-url="' . $linkInputQuantity . '">
                        </div>
                    </div>
                </td>
                <td><a href="' . $linkRemoveItem . '" class="icon"><i class="ti-close"></i></a></td>
                <td>
                    <h2 class="td-color text-lowercase">' . $totalPrice . ' đ</h2>
                </td>
            </tr>';
        $xhtml .= HelperFrontend::createInputHidden('book_id', $item['id'], "book_id_{$item['id']}");
        $xhtml .= HelperFrontend::createInputHidden('price', $item['price'], "price_{$item['id']}");
        $xhtml .= HelperFrontend::createInputHidden('quantity', $item['quantity'], "quantity_{$item['id']}");
        $xhtml .= HelperFrontend::createInputHidden('name', $item['name'], "name_{$item['id']}");
        $xhtml .= HelperFrontend::createInputHidden('picture', $item['picture'], "picture_{$item['id']}");
    }
}

// breadcrumb
$xhtmlBreadcrumb = HelperFrontend::createBreadcrumb('Giỏ hàng');
?>

<?php
echo $xhtmlBreadcrumb;
if (!empty($xhtml)) {
?>
    <form action="<?= $linkSubmit ?>" method="POST" name="admin-form" id="admin-form">
        <section class="cart-section section-b-space">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <table class="table cart-table table-responsive-xs">
                            <thead>
                                <tr class="table-head">
                                    <th scope="col">Hình ảnh</th>
                                    <th scope="col">Tên sách</th>
                                    <th scope="col">Giá</th>
                                    <th scope="col">Số Lượng</th>
                                    <th scope="col"><a style="color:#777777" href="<?= $linkDeleteAll; ?>">Xóa tất cả</a></th>
                                    <th scope="col">Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?= $xhtml; ?>
                            </tbody>

                        </table>
                        <table class="table cart-table table-responsive-md">
                            <tfoot>
                                <tr>
                                    <td>Tổng :</td>
                                    <td>
                                        <h2 class="text-lowercase"><?= number_format($priceTotal, 0, ',', '.') ?> đ</h2>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="row cart-buttons">
                    <div class="col-6"><a href="trang-chu.html" class="btn btn-solid">Tiếp tục mua sắm</a></div>
                    <div class="col-6"><button type="submit" class="btn btn-solid">Đặt hàng</button></div>
                </div>
            </div>
        </section>
    </form>
<?php } else { ?>
    <section class="cart-section section-b-space">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 text-center">
                    <i class="fa fa-cart-plus fa-5x my-text-primary"></i>
                    <h5 class="my-3">Không có sản phẩm nào trong giỏ hàng của bạn</h5>
                    <a href="trang-chu.html" class="btn btn-solid">Tiếp tục mua sắm</a>
                </div>
            </div>
        </div>
    </section>
<?php } ?>