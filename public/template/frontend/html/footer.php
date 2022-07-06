<?php
function topCategory()
{
    $model = new Model();

    $query[]     = "SELECT `id`, `name`";
    $query[]     = "FROM `" . TBL_CATEGORY . "`";
    $query[]     = "WHERE `status` = 'active' AND `show_at_home` = 1";
    $query[]     = "ORDER BY `ordering` ASC";
    $query[]     = "LIMIT 0, 3";

    $query        = implode(" ", $query);
    $result       = $model->fetchAll($query);
    return $result;
}

// show category
$listCategory = topCategory();

$xhtmlCategory = '';
foreach ($listCategory as $value) {
    $linkCategory = URL::createLink($this->params['module'], 'book', 'list', ['category_id' => $value['id']]);
    $xhtmlCategory .= sprintf('<li><a href="%s">%s</a></li>', $linkCategory, $value['name']);
}
?>
<footer class="footer-light mt-5">
    <section class="section-b-space light-layout">
        <div class="container">
            <div class="row footer-theme partition-f">
                <div class="col-lg-4 col-md-6">
                    <div class="footer-title footer-mobile-title">
                        <h4>Giới thiệu</h4>
                    </div>
                    <div class="footer-contant">
                        <div class="footer-logo">
                            <h2 style="color: #ff9e3e">BookStore</h2>
                        </div>
                        <p>Tự hào là website bán sách trực tuyến lớn nhất Việt Nam, cung cấp đầy đủ các thể loại
                            sách, đặc biệt với những đầu sách độc quyền trong nước và quốc tế</p>
                    </div>
                </div>
                <div class="col offset-xl-1">
                    <div class="sub-title">
                        <div class="footer-title">
                            <h4>Danh mục nổi bật</h4>
                        </div>
                        <div class="footer-contant">
                            <ul><?= $xhtmlCategory;?></ul>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="sub-title">
                        <div class="footer-title">
                            <h4>Chính sách</h4>
                        </div>
                        <div class="footer-contant">
                            <ul>
                                <li><a href="#">Điều khoản sử dụng</a></li>
                                <li><a href="#">Chính sách bảo mật</a></li>
                                <li><a href="#">Hợp tác phát hành</a></li>
                                <li><a href="#">Phương thức vận chuyển</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="sub-title">
                        <div class="footer-title">
                            <h4>Thông tin</h4>
                        </div>
                        <div class="footer-contant">
                            <ul class="contact-list">
                                <li><i class="fa fa-phone"></i>Hotline 1: <a href="tel:0905744470">090 5744 470</a></li>
                                <li><i class="fa fa-phone"></i>Hotline 2: <a href="tel:0383308983">0383 308 983</a></li>
                                <li><i class="fa fa-envelope-o"></i>Email: <a href="mailto:training@zend.vn" class="text-lowercase">training@zend.vn</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="sub-footer">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 col-md-6 col-sm-12">
                    <div class="footer-end">
                        <p><i class="fa fa-copyright" aria-hidden="true"></i> 2022 ZendVN</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>