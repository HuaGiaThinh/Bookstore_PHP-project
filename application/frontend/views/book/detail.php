<?php
$linkCart = URL::createLink($this->params['module'], 'user', 'cart');
if (!empty($this->bookInfo)) {
    $bookInfo = $this->bookInfo;

    $pictureURL = HelperFrontend::createPictureURL($bookInfo['picture'], $this->params);

    $price = number_format($bookInfo['price'], 0, ',', '.');
    $priceAfterSaleOff = HelperFrontend::priceAfterSaleOff($bookInfo['price'], $bookInfo['sale_off']);

    $linkOrder  = URL::createLink($this->params['module'], 'user', 'order', ['book_id' => $bookInfo['id'], 'price' => $priceAfterSaleOff]);
    $priceAfterSaleOff = number_format($priceAfterSaleOff, 0, ',', '.');
    if ($bookInfo['sale_off'] != 0) {
        $xhtmlPrice = sprintf(
            '<h4><del>%s đ</del><span style="color:red"> -%s%s</span></h4><h3>%s đ</h3>',
            $price,
            $bookInfo['sale_off'],
            '%',
            $priceAfterSaleOff
        );
    } else {
        $xhtmlPrice = '<h3>' . $price . ' đ</h3>';
    }
}

// Related Books
$xhtmlRelatedBooks = '';
if (!empty($this->relatedBooks)) {
    foreach ($this->relatedBooks as $item) {
        $linkItem   = URL::createLink($this->params['module'], $this->params['controller'], 'detail', ['book_id' => $item['id']]);

        $saleOff = HelperFrontend::showItemSaleOff($item['sale_off']);
        $name = (strlen($item['name']) > 25) ? (substr($item['name'], 0, 25) . '...') : $item['name'];

        $price = number_format($item['price'], 0, ',', '.');
        $price = ($saleOff != null) ? $price = '<del>' . $price . ' đ</del>' : '';
        $priceAfterSaleOff = HelperFrontend::priceAfterSaleOff($item['price'], $item['sale_off']);

        $linkOrderBookRelated = URL::createLink($this->params['module'], 'user', 'order', ['book_id' => $item['id'], 'price' => $priceAfterSaleOff]);

        $priceAfterSaleOff = number_format($priceAfterSaleOff, 0, ',', '.');
        $pictureSrc = HelperFrontend::createPictureURL($item['picture'], $this->params);

        $linkQuickView = URL::createLink($this->params['module'], $this->params['controller'], 'ajaxQuickView', ['book_id' => $item['id']]);

        $xhtmlRelatedBooks .= '
            <div class="col-xl-2 col-md-4 col-sm-6">
                <div class="product-box">
                    <div class="img-wrapper">' . $saleOff . '
                        <div class="front">
                            <a href="' . $linkItem . '">
                                <img src="' . $pictureSrc . '" class="img-fluid blur-up lazyload bg-img" alt="">
                            </a>
                        </div>
                        <div class="cart-info cart-wrap">
                            <a href="' . $linkOrderBookRelated . '" class="add-to-cart" title="Add to cart"><i class="ti-shopping-cart"></i></a>
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
            </div>        
        ';
    }
}
?>
<div class="breadcrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="page-title">
                    <h2 class="py-2"><?= $bookInfo['name']; ?></h2>
                </div>
            </div>
        </div>
    </div>
</div>
<section class="section-b-space">
    <div class="collection-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 col-sm-12 col-xs-12">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="filter-main-btn mb-2"><span class="filter-btn"><i class="fa fa-filter" aria-hidden="true"></i> filter</span></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-xl-4">
                                <div class="product-slick">
                                    <div><img src="<?= $pictureURL; ?>" alt="<?= $bookInfo['name'] ?>" class="img-fluid w-100 blur-up lazyload image_zoom_cls-0"></div>
                                </div>
                            </div>
                            <div class="col-lg-8 col-xl-8 rtl-text">
                                <div class="product-right">
                                    <h2 class="mb-2"><?= $bookInfo['name'] ?></h2>
                                    <?= $xhtmlPrice; ?>
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
                                        <a href="<?= $linkOrder; ?>" class="btn btn-solid ml-0 add-to-cart"><i class="fa fa-cart-plus"></i> Chọn mua</a>
                                    </div>
                                    <div class="border-product"><?= $bookInfo['description'] ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <section class="tab-product m-0">
                        <div class="container">
                            <div class="row">
                                <div class="col-sm-12 col-lg-12">
                                    <ul class="nav nav-tabs nav-material" id="top-tab" role="tablist">
                                        <li class="nav-item"><a class="nav-link active" id="top-home-tab" data-toggle="tab" href="#top-home" role="tab" aria-selected="true">Mô tả sản phẩm</a>
                                            <div class="material-border"></div>
                                        </li>
                                    </ul>
                                    <div class="tab-content nav-material" id="top-tabContent">
                                        <div class="tab-pane fade show active ckeditor-content" id="top-home" role="tabpanel" aria-labelledby="top-home-tab">
                                            <p><strong>Để Con Được Ốm</strong></p>

                                            <p><strong>Để con được ốm</strong>&nbsp;c&oacute; thể coi l&agrave; một
                                                cuốn nhật k&yacute; học l&agrave;m mẹ th&ocirc;ng qua những
                                                c&acirc;u chuyện từ trải nghiệm thực tế m&agrave;
                                                chị&nbsp;<strong>Uy&ecirc;n B&ugrave;i</strong>&nbsp;đ&atilde; trải
                                                qua từ khi mang thai đến khi em b&eacute; ch&agrave;o đời v&agrave;
                                                trở th&agrave;nh một c&ocirc; b&eacute; khỏe mạnh, vui vẻ.
                                                C&ugrave;ng với những c&acirc;u chuyện nhỏ th&uacute; vị của người
                                                mẹ l&agrave; lời khuy&ecirc;n mang t&iacute;nh chuy&ecirc;n
                                                m&ocirc;n, giải đ&aacute;p cụ thể từ b&aacute;c
                                                sỹ&nbsp;<strong>Nguyễn Tr&iacute; Đo&agrave;n</strong>, gi&uacute;p
                                                h&oacute;a giải những hiểu lầm từ kinh nghiệm d&acirc;n gian được
                                                truyền lại, cũng như l&yacute; giải một c&aacute;ch khoa học những
                                                th&ocirc;ng tin chưa đ&uacute;ng đắn đang được lưu truyền hiện nay,
                                                mang đến g&oacute;c nh&igrave;n đ&uacute;ng đắn nhất cho mỗi hiện
                                                tượng, sự việc với những kiến thức y khoa hiện đại được cập nhật
                                                li&ecirc;n tục. Cuốn s&aacute;ch sẽ gi&uacute;p c&aacute;c bậc phụ
                                                huynh trang bị một số kiến thức cơ bản trong việc chăm s&oacute;c
                                                trẻ một c&aacute;ch khoa học v&agrave; g&oacute;p phần gi&uacute;p
                                                c&aacute;c mẹ v&agrave; những-người-sẽ-l&agrave;-mẹ trở n&ecirc;n tự
                                                tin hơn trong việc chăm con, xua tan đi những lo lắng, để mỗi em
                                                b&eacute; ra đời đều được hưởng sự chăm s&oacute;c tốt nhất.</p>

                                            <p>Tr&ecirc;n thị trường c&oacute; nhiều đầu s&aacute;ch về chăm
                                                s&oacute;c trẻ, tuy nhi&ecirc;n đa phần đều l&agrave; nội dung được
                                                dịch từ c&aacute;c s&aacute;ch nước ngo&agrave;i n&ecirc;n phần
                                                n&agrave;o đ&oacute; kh&ocirc;ng ph&ugrave; hợp với c&aacute;c gia
                                                đ&igrave;nh Việt bởi sự kh&aacute;c biệt về suy nghĩ v&agrave;
                                                &yacute; thức hệ c&ugrave;ng những quan niệm sống. Đặc biệt
                                                l&agrave; c&aacute;c cuốn s&aacute;ch ấy kh&ocirc;ng bao giờ nhắc
                                                tới c&aacute;ch xử l&yacute; c&aacute;c vấn đề đời thường, những
                                                kinh nghiệm d&acirc;n gian hay phương ph&aacute;p chăm s&oacute;c
                                                trẻ từ &ldquo;kinh nghiệm c&aacute; nh&acirc;n&rdquo; của c&aacute;c
                                                mẹ tr&agrave;n lan tr&ecirc;n c&aacute;c diễn đ&agrave;n v&agrave;
                                                mạng x&atilde; hội - những điều đang tồn tại trong x&atilde; hội
                                                Việt ta hiện nay. Do đ&oacute;,<strong>&nbsp;Để con được
                                                    ốm</strong>&nbsp;trở th&agrave;nh một t&aacute;c phẩm độc
                                                đ&aacute;o khi đi s&acirc;u v&agrave;o vấn đề chăm s&oacute;c con
                                                trẻ c&ugrave;ng những điều bất cập trong x&atilde; hội Việt, trong
                                                những gia đ&igrave;nh Việt, giữa c&aacute;c th&agrave;nh vi&ecirc;n
                                                trong gia đ&igrave;nh.&nbsp;<strong>Để con được
                                                    ốm</strong>&nbsp;kh&ocirc;ng phải l&agrave; cuốn
                                                &ldquo;b&aacute;ch khoa to&agrave;n thư&rdquo; chữa b&aacute;ch bệnh
                                                ở trẻ em, n&oacute; đơn giản l&agrave; lời sẻ chia v&agrave; động
                                                vi&ecirc;n gửi đến c&aacute;c b&agrave; mẹ trẻ n&oacute;i
                                                ri&ecirc;ng v&agrave; c&aacute;c gia đ&igrave;nh n&oacute;i chung.
                                            </p>

                                            <p>Hi vọng, cuốn s&aacute;ch sẽ khiến c&aacute;c bậc phụ huynh cảm thấy
                                                như một luồng gi&oacute; m&aacute;t gi&uacute;p &ldquo;cởi
                                                phăng&rdquo;, &ldquo;cuốn bay&rdquo; những suy nghĩ, những định kiến
                                                kh&ocirc;ng đ&uacute;ng như những lớp &aacute;o gi&aacute;p vững
                                                chắc về hiều biết, về c&aacute;ch chăm s&oacute;c trẻ khi bệnh cũng
                                                như khi khỏe.</p>

                                            <p><strong>Nhận x&eacute;t</strong></p>

                                            <p>&ldquo;Khi cầm cuốn s&aacute;ch tr&ecirc;n tay, t&ocirc;i cảm thấy
                                                hết sức th&uacute; vị v&igrave; nội dung của n&oacute; đ&atilde; gạt
                                                bỏ hầu hết mọi quan niệm về chăm s&oacute;c trẻ theo &ldquo;kinh
                                                nghiệm&rdquo; truyền tai của c&aacute;c b&agrave; mẹ - nu&ocirc;i
                                                con nh&igrave;n sang nh&agrave; h&agrave;ng x&oacute;m. Đặc biệt
                                                hơn, n&oacute; được tổng kết từ thực tế chăm s&oacute;c con của một
                                                b&agrave; mẹ trẻ. Những rắc rối hết sức đời thường tưởng như nhỏ
                                                nhặt ấy đ&atilde; được giải đ&aacute;p v&agrave; ph&acirc;n
                                                t&iacute;ch một c&aacute;ch cặn kẽ bằng c&aacute;c chứng cứ khoa học
                                                v&agrave; những lời khuy&ecirc;n cũng hết sức đời thường.&rdquo;</p>

                                            <p><strong>(Bs. Ng&ocirc; Đức H&ugrave;ng, Bệnh viện Bạch Mai)</strong>
                                            </p>

                                            <p>&quot;Từ gi&acirc;y ph&uacute;t đầu ti&ecirc;n cầm quyển s&aacute;ch
                                                tr&ecirc;n tay, t&ocirc;i biết rằng quyển s&aacute;ch n&agrave;y sẽ
                                                tạo ra sự thay đổi trong nhận thức của cha mẹ Việt về c&aacute;ch
                                                chữa trị bằng tr&aacute;i tim y&ecirc;u thương, thay v&igrave; việc
                                                chữa trị th&ocirc;ng thường th&ocirc;ng qua c&aacute;c biểu hiện
                                                bệnh l&yacute;.&quot;</p>

                                            <p><strong>(Mrs. Jeannie Chan-Ho, Viện trưởng Viện Gi&aacute;o dục
                                                    Shichida Việt Nam)</strong></p>

                                            <p>&quot;Sức khỏe của con lu&ocirc;n l&agrave; mối quan t&acirc;m
                                                h&agrave;ng đầu của mẹ. Chỉ cần con hắt hơi th&ocirc;i l&agrave; lo
                                                lắng c&oacute; phải bệnh kh&ocirc;ng? Khi con bệnh, m&igrave;nh chăm
                                                s&oacute;c sao đ&acirc;y? Sao th&aacute;ng n&agrave;y con tăng
                                                k&yacute; &iacute;t vậy? Ph&aacute;t triển vậy c&oacute; b&igrave;nh
                                                thường kh&ocirc;ng? C&oacute; suy dinh dưỡng kh&ocirc;ng? H&ocirc;m
                                                nay con ăn c&oacute; v&agrave;i muỗng, sao đủ chất? Bao nhi&ecirc;u
                                                lo lắng, từ lớn đến nhỏ đều được B&aacute;c sĩ Tr&iacute;
                                                Đo&agrave;n giải th&iacute;ch r&otilde; r&agrave;ng, dễ hiểu
                                                v&agrave; mang t&iacute;nh khoa học. Nhiều kinh nghiệm d&acirc;n
                                                gian chưa đ&uacute;ng cũng được mổ xẻ, ph&acirc;n t&iacute;ch
                                                gi&uacute;p c&aacute;c mẹ hiểu c&aacute;i g&igrave; n&ecirc;n giữ
                                                lại, c&aacute;i g&igrave; n&ecirc;n điều chỉnh cho đ&uacute;ng. Thậm
                                                ch&iacute;, những người trong ng&agrave;nh y như t&ocirc;i cũng được
                                                cập nhật những kiến thức cũ th&agrave;nh mới. C&oacute; thể
                                                n&oacute;i, chưa quyển s&aacute;ch n&agrave;o l&agrave;m đươc điều
                                                n&agrave;y. T&ocirc;i tin Để con được ốm l&agrave; một quyển
                                                s&aacute;ch đ&aacute;ng để gối đầu giường cho c&aacute;c b&agrave;
                                                mẹ, gi&uacute;p c&aacute;c mẹ tự tin chăm s&oacute;c b&eacute;
                                                y&ecirc;u một c&aacute;ch tốt nhất!&quot;</p>

                                            <p><strong>(Bs. Anh Thy - Chuy&ecirc;n vi&ecirc;n Tư vấn Sữa mẹ Quốc tế
                                                    tại Việt Nam)</strong></p>

                                            <p>&quot;C&aacute;i hay của s&aacute;ch l&agrave; gi&uacute;p
                                                ch&uacute;ng ta - những học tr&ograve; bỡ ngỡ trong lớp học
                                                &ldquo;l&agrave;m cha mẹ&rdquo; - giảm bớt &aacute;p lực trong
                                                qu&aacute; tr&igrave;nh nu&ocirc;i con. Nu&ocirc;i con kh&ocirc;ng
                                                bao giờ nh&agrave;n nh&atilde;, nhưng n&ecirc;n mang đến niềm vui,
                                                thay v&igrave; sự căng thẳng v&agrave; những chuỗi ng&agrave;y
                                                d&agrave;i băn khoăn lo lắng, rồi dẫn tới bao điều kh&ocirc;ng hay
                                                kh&aacute;c.&quot;</p>

                                            <p><strong>(Bs. Đinh Huỳnh Linh, Bệnh viện Tim mạch Quốc gia)</strong>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="col-sm-3 collection-filter">
                    <div class="collection-filter-block">
                        <div class="collection-mobile-back">
                            <span class="filter-back"><i class="fa fa-angle-left" aria-hidden="true"></i> back</span>
                        </div>

                        <!-- Product service -->
                        <?php include_once 'html/product-service.php'; ?>
                    </div>

                    <!-- Special Books -->
                    <?php require_once 'html/special-books.php'; ?>

                    <!-- New Books -->
                    <?php require_once 'html/new-books.php'; ?>
                </div>

            </div>

            <!-- Related books -->
            <div class="row">
                <section class="section-b-space j-box ratio_asos pb-0">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 product-related">
                                <h2>Sản phẩm liên quan</h2>
                            </div>
                        </div>
                        <div class="row search-product">
                            <?= $xhtmlRelatedBooks; ?>
                        </div>
                    </div>
                </section>

                <div class="modal fade bd-example-modal-lg theme-modal cart-modal" id="addtocart" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-body modal1">
                                <div class="container-fluid p-0">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="modal-bg addtocart">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                                <div class="media">
                                                    <a href="#">
                                                        <img class="img-fluid blur-up lazyload pro-img" src="<?= $pictureURL?>" alt="">
                                                    </a>
                                                    <div class="media-body align-self-center text-center">
                                                        <a href="#">
                                                            <h6>
                                                                <i class="fa fa-check"></i>Sản phẩm
                                                                <span class="font-weight-bold"><?= $bookInfo['name'];?></span>
                                                                <span> đã được thêm vào giỏ hàng!</span>
                                                            </h6>
                                                        </a>
                                                        <div class="buttons">
                                                            <a href="<?= $linkCart?>" class="view-cart btn btn-solid">Xem giỏ hàng</a>
                                                            <a href="index.php" class="continue btn btn-solid" data-dismiss="modal">Tiếp tục mua sắm</a>
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
            </div>
        </div>
    </div>
</section>