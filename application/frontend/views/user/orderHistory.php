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
            $price = number_format($arrPrice[$key] * $arrQuantity[$key]);
            $totalPrice += $arrPrice[$key] * $arrQuantity[$key];
            $tableContent .= '
                <tr>
                    <td><a href="#"><img src="'.$pictureURL.'" alt="'.$arrName[$key].'" style="width: 80px"></a></td>
                    <td style="min-width: 200px">'.$arrName[$key].'</td>
                    <td style="min-width: 100px">'.number_format($arrPrice[$key]).' đ</td>
                    <td>'.$arrQuantity[$key].'</td>
                    <td style="min-width: 150px">'.$price.' đ</td>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>