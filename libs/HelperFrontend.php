<?php
class HelperFrontend
{
    public static function createButton($type, $name, $value, $id, $text, $class)
    {
        return sprintf('<button type="%s" id="%s" name="%s" value="%s" class="btn %s">%s</button>', $type, $id, $name, $value, $class, $text);
    }

    public static function createMenu($arrMenu, $classMenu = '')
    {
        $xhtml = '<ul class="' . $classMenu . '">';

        foreach ($arrMenu as $value) {
            $xhtml .= sprintf('<li><a href="%s">%s</a></li>', $value['link'], $value['text']);
        }

        $xhtml .= '</ul>';
        return $xhtml;
    }

    public static function createNav($arrNav, $params)
    {
        $xhtml = '';
        foreach ($arrNav as $key => $value) {
            $classActive = $key == $params['action'] ? 'active' : '';
            $xhtml .= sprintf('<li class="%s"><a href="%s">%s</a></li>', $classActive, $value['link'], $value['text']);
        }
        return $xhtml;
    }

    public static function showItemSaleOff($saleOff)
    {
        $xhtml = '';
        if ($saleOff != 0) {
            $xhtml = '
                <div class="lable-block">
                    <span class="lable4 badge badge-danger"> -' . $saleOff . '%</span>
                </div>';
        }
        return $xhtml;
    }

    public static function createPictureURL($picture, $params)
    {
        $folder = ($params['controller'] == 'index' || $params['controller'] == 'user') ? 'book' : $params['controller'];

        $picturePath    = UPLOAD_PATH . $folder . DS . $picture;

        $pictureURL     = UPLOAD_URL . '/default' . '/defaultImage.jpg';
        if (file_exists($picturePath)) {
            $pictureURL = UPLOAD_URL . $folder . DS . $picture;
        }
        return $pictureURL;
    }

    public static function priceSaleOff($originalPrice, $saleOff)
    {
        $priceAfterSaleOff = $originalPrice - (($originalPrice * $saleOff) / 100);
        return number_format($priceAfterSaleOff, 0, ',', '.');
    }

    public static function priceAfterSaleOff($originalPrice, $saleOff)
    {
        $priceAfterSaleOff = $originalPrice - (($originalPrice * $saleOff) / 100);
        return $priceAfterSaleOff;
    }

    public static function createInputHidden($name, $value, $id)
    {
        return sprintf('<input type="hidden" name="form[%s][]" value="%s" id="input_%s">', $name, $value, $id);
    }

    public static function ratingStar()
    {
        return '<div class="rating">
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                </div>';
    }

    public static function createXhtmlBooks($listBooks, $params, $hasSize = false, $classSize = '', $hasDescription = false)
    {
        $xhtml = '';
        foreach ($listBooks as $item) {
            $linkItem = URL::createLink($params['module'], $params['controller'], 'detail', ['book_id' => $item['id']]);

            $saleOff        = self::showItemSaleOff($item['sale_off']);
            $name           = (strlen($item['name']) > 36) ? (substr($item['name'], 0, 36) . '...') : $item['name'];
            $description    = (strlen($item['description']) > 1000) ? (substr($item['description'], 0, 1000) . '...') : $item['description'];
            $xhtmlDescription = $hasDescription ? '<p>' . $description . '</p>' : '';

            $price = number_format($item['price'], 0, ',', '.');
            $price = ($saleOff != null) ? $price = '<del>' . $price . ' đ</del>' : '';
            $priceAfterSaleOff = self::priceAfterSaleOff($item['price'], $item['sale_off']);

            $linkOrder = URL::createLink($params['module'], 'user', 'order', ['book_id' => $item['id'], 'price' => $priceAfterSaleOff]);

            $priceAfterSaleOff = number_format($priceAfterSaleOff, 0, ',', '.');
            $pictureURL = self::createPictureURL($item['picture'], $params);

            $linkQuickView = URL::createLink($params['module'], $params['controller'], 'ajaxQuickView', ['book_id' => $item['id']]);

            $rating = self::ratingStar();
            
            if ($hasSize) $xhtml .= sprintf('<div class="%s">', $classSize);
            $xhtml .= '
                <div class="product-box">
                    <div class="img-wrapper">' . $saleOff . '
                        <div class="front">
                            <a href="' . $linkItem . '">
                                <img src="' . $pictureURL . '" class="img-fluid blur-up lazyload bg-img" alt="">
                            </a>
                        </div>
                        <div class="cart-info cart-wrap">
                            <a href="' . $linkOrder . '" class="add-to-cart" title="Add to cart"><i class="ti-shopping-cart"></i></a>
                            <a href="' . $linkQuickView . '" title="Quick View" class="quick-view"><i class="ti-search" data-toggle="modal" data-target="#quick-view"></i></a>
                        </div>
                    </div>
                    <div class="product-detail">' . $rating . '
                        <a href="' . $linkItem . '" title="' . $item['name'] . '">
                            <h6>' . $name . '</h6>
                        </a>
                        ' . $xhtmlDescription . '
                        <h4 class="text-lowercase">' . $priceAfterSaleOff . ' đ ' . $price . '</h4>
                    </div>
                </div>     
            ';
            if ($hasSize) $xhtml .= '</div>';
        }
        return $xhtml;
    }

    public static function createSliderBooks($listBooks, $params, $title, $itemInSlider = 4, $classStyle = '')
    {
        $i = 0;
        $xhtmlSliderBooks = '<div>';
        foreach ($listBooks as $book) {
            $link = URL::createLink($params['module'], $params['controller'], 'detail', ['book_id' => $book['id']]);

            $picture = self::createPictureURL($book['picture'], $params);
            $name = (strlen($book['name']) > 50) ? (substr($book['name'], 0, 50) . '...') : $book['name'];
            $priceAfterSaleOff = self::priceSaleOff($book['price'], $book['sale_off']);

            $rating = self::ratingStar();
            if (($i % $itemInSlider == 0) && $i != 0) $xhtmlSliderBooks .= '</div><div>';
            $xhtmlSliderBooks .= '
                <div class="media">
                    <a href="' . $link . '">
                        <img style="width: 116px;height: 160px;"class="img-fluid blur-up lazyload" src="' . $picture . '" alt="' . $book['name'] . '">
                    </a>
                    <div class="media-body align-self-center">' . $rating . '
                        <a href="' . $link . '" title="' . $book['name'] . '">
                            <h6>' . $name . '</h6>
                        </a>
                        <h4 class="text-lowercase">' . $priceAfterSaleOff . ' đ</h4>
                    </div>
                </div>';
            $i++;
        }
        $xhtmlSliderBooks .= '</div>';

        $xhtml = sprintf('
            <div class="theme-card %s">
                <h5 class="title-border">%s</h5>
                <div class="offer-slider slide-1">
                    %s
                </div>
            </div>
        ', $classStyle, $title, $xhtmlSliderBooks);

        return $xhtml;
    }
}
