<?php
$xhtmlCart = '';
if (!empty($this->items)) {
    $tableHeader = '<tr style="color:#ff9e3e"><td>Hình ảnh</td><td>Tên sách</td><td>Giá</td><td>Số lượng</td><td>Thành tiền</td></tr>';
    foreach ($this->items as $item) {
        $date = date('d/m/Y H:i', strtotime($item['date']));

        $arrBookID      = json_decode($item['books']);
        $arrPrice       = json_decode($item['prices']);
        $arrName        = json_decode($item['names']);
        $arrQuantity    = json_decode($item['quantities']);
        $arrPicture     = json_decode($item['pictures']);
        $totalPrice     = 0;
        $tableContent   = '';

        foreach ($arrBookID as $key => $value) {
            $pictureURL = HelperFrontend::createPictureURL($arrPicture[$key], $this->params);
            $totalPrice += $arrPrice[$key] * $arrQuantity[$key];
            $tableContent .= '
                <tr>
                    <td><a href="#"><img src="'.$pictureURL.'" alt="'.$arrName[$key].'" style="width: 80px"></a></td>
                    <td style="min-width: 200px">'.$arrName[$key].'</td>
                    <td style="min-width: 100px">'.number_format($arrPrice[$key]).' đ</td>
                    <td>'.$arrQuantity[$key].'</td>
                    <td style="min-width: 150px">'.number_format($arrPrice[$key] * $arrQuantity[$key]).' đ</td>
                </tr>';
        }

        $xhtmlCart .= '
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <button style="text-transform: none;" class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#'.$item['id'].'">Mã đơn hàng: '.$item['id'].'</button>&nbsp;&nbsp;Thời gian: '.$date.'
                    </h5>
                </div>
                <div id="'.$item['id'].'" class="collapse" data-parent="#accordionExample" style="">
                    <div class="card-body table-responsive">
                        <table class="table btn-table">

                            <thead>'.$tableHeader.'</thead>

                            <tbody>
                                '.$tableContent.'
                                <tr></tr>
                            </tbody>
                            <tfoot>
                                <tr class="my-text-primary font-weight-bold">
                                    <td colspan="4" class="text-right">Tổng: </td>
                                    <td>'.number_format($totalPrice).' đ</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>';
    }
} else {
    $xhtmlCart .= '<div class="card-header">';
    $xhtmlCart .= '<h2 style="color:#ff9e3e; font-size: 22px;" class="text-center">:(( Bạn chưa có đơn hàng nào</h2></div>';
}
?>
<div class="breadcrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="page-title">
                    <h2 class="py-2">Lịch sử mua hàng</h2>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="faq-section section-b-space">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <?php require_once 'html/account-sidebar.php';?>
            </div>
            <div class="col-lg-9">
                <div class="accordion theme-accordion" id="accordionExample">
                    <div class="accordion theme-accordion" id="accordionExample">
                        <?= $xhtmlCart;?>
                        <!-- <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <button style="text-transform: none;" class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#rIgdYJf">Mã đơn hàng:
                                        rIgdYJf</button>&nbsp;&nbsp;Thời gian: 03/09/2020 10:07:21
                                </h5>
                            </div>
                            <div id="rIgdYJf" class="collapse" data-parent="#accordionExample" style="">
                                <div class="card-body table-responsive">
                                    <table class="table btn-table">

                                        <thead>
                                            <tr>
                                                <td>Hình ảnh</td>
                                                <td>Tên sách</td>
                                                <td>Giá</td>
                                                <td>Số lượng</td>
                                                <td>Thành tiền</td>
                                            </tr>
                                        </thead>

                                        <tbody>

                                            <tr>
                                                <td><a href="#"><img src="images/product.jpg" alt="Kiến Trúc Hướng Dòng Thông Gió Tự Nhiên (Tái Bản)" style="width: 80px"></a></td>
                                                <td style="min-width: 200px">Kiến Trúc Hướng Dòng Thông Gió Tự Nhiên
                                                    (Tái Bản)</td>
                                                <td style="min-width: 100px">70,550 đ</td>
                                                <td>1</td>
                                                <td style="min-width: 150px">70,550 đ</td>
                                            </tr>
                                            <tr></tr>
                                        </tbody>
                                        <tfoot>
                                            <tr class="my-text-primary font-weight-bold">
                                                <td colspan="4" class="text-right">Tổng: </td>
                                                <td>70,550 đ</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0"><button style="text-transform: none;" class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#Kv4z8GH">Mã đơn hàng:
                                        Kv4z8GH</button>&nbsp;&nbsp;Thời gian: 30/08/2020 21:56:20</h5>
                            </div>
                            <div id="Kv4z8GH" class="collapse" data-parent="#accordionExample" style="">
                                <div class="card-body table-responsive">
                                    <table class="table btn-table">

                                        <thead>
                                            <tr>
                                                <td>Hình ảnh</td>
                                                <td>Tên sách</td>
                                                <td>Giá</td>
                                                <td>Số lượng</td>
                                                <td>Thành tiền</td>
                                            </tr>
                                        </thead>

                                        <tbody>

                                            <tr>
                                                <td><a href="#"><img src="images/product.jpg" alt="Giáo Trình Hán Ngữ 1 - Tập 1 - Quyển Thượng (Phiên Bản Mới)" style="width: 80px"></a></td>
                                                <td style="min-width: 200px">Giáo Trình Hán Ngữ 1 - Tập 1 - Quyển
                                                    Thượng
                                                    (Phiên Bản Mới)</td>
                                                <td style="min-width: 100px">53,400 đ</td>
                                                <td>1</td>
                                                <td style="min-width: 150px">53,400 đ</td>
                                            </tr>

                                            <tr>
                                                <td><a href="#"><img src="images/product.jpg" alt="Giải Thích Ngữ Pháp Tiếng Anh (Bài Tập Và Đáp Án)" style="width: 80px"></a></td>
                                                <td style="min-width: 200px">Giải Thích Ngữ Pháp Tiếng Anh (Bài Tập
                                                    Và
                                                    Đáp Án)</td>
                                                <td style="min-width: 100px">139,500 đ</td>
                                                <td>1</td>
                                                <td style="min-width: 150px">139,500 đ</td>
                                            </tr>

                                            <tr>
                                                <td><a href="#"><img src="images/product.jpg" alt="Hackers Ielts: Writing" style="width: 80px"></a>
                                                </td>
                                                <td style="min-width: 200px">Hackers Ielts: Writing</td>
                                                <td style="min-width: 100px">162,520 đ</td>
                                                <td>1</td>
                                                <td style="min-width: 150px">162,520 đ</td>
                                            </tr>
                                            <tr></tr>
                                        </tbody>
                                        <tfoot>
                                            <tr class="my-text-primary font-weight-bold">
                                                <td colspan="4" class="text-right">Tổng: </td>
                                                <td>355,420 đ</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0"><button style="text-transform: none;" class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#kqxfDul">Mã đơn hàng:
                                        kqxfDul</button>&nbsp;&nbsp;Thời gian: 30/08/2020 21:20:14</h5>
                            </div>
                            <div id="kqxfDul" class="collapse" data-parent="#accordionExample" style="">
                                <div class="card-body table-responsive">
                                    <table class="table btn-table">

                                        <thead>
                                            <tr>
                                                <td>Hình ảnh</td>
                                                <td>Tên sách</td>
                                                <td>Giá</td>
                                                <td>Số lượng</td>
                                                <td>Thành tiền</td>
                                            </tr>
                                        </thead>

                                        <tbody>

                                            <tr>
                                                <td><a href="#"><img src="images/product.jpg" alt="Giáo Trình Kỹ Thuật Lập Trình C Căn Bản Và Nâng Cao" style="width: 80px"></a></td>
                                                <td style="min-width: 200px">Giáo Trình Kỹ Thuật Lập Trình C Căn Bản
                                                    Và
                                                    Nâng Cao</td>
                                                <td style="min-width: 100px">101,250 đ</td>
                                                <td>1</td>
                                                <td style="min-width: 150px">101,250 đ</td>
                                            </tr>

                                            <tr>
                                                <td><a href="#"><img src="images/product.jpg" alt="Kiến Trúc Hướng Dòng Thông Gió Tự Nhiên (Tái Bản)" style="width: 80px"></a></td>
                                                <td style="min-width: 200px">Kiến Trúc Hướng Dòng Thông Gió Tự Nhiên
                                                    (Tái Bản)</td>
                                                <td style="min-width: 100px">70,550 đ</td>
                                                <td>1</td>
                                                <td style="min-width: 150px">70,550 đ</td>
                                            </tr>

                                            <tr>
                                                <td><a href="#"><img src="images/product.jpg" alt="Cẩm Nang Cấu Trúc Tiếng Anh" style="width: 80px"></a>
                                                </td>
                                                <td style="min-width: 200px">Cẩm Nang Cấu Trúc Tiếng Anh</td>
                                                <td style="min-width: 100px">48,020 đ</td>
                                                <td>1</td>
                                                <td style="min-width: 150px">48,020 đ</td>
                                            </tr>
                                            <tr></tr>
                                        </tbody>
                                        <tfoot>
                                            <tr class="my-text-primary font-weight-bold">
                                                <td colspan="4" class="text-right">Tổng: </td>
                                                <td>219,820 đ</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>