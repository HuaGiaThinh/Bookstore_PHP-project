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

    public static function createInput($type, $name, $value)
    {
        return sprintf('<input type="%s" name="%s" value="%s">', $type, $name, $value);
    }

    public static function select($name, $id, $arrOptions, $keySelected = null)
    {
        $options = '<option> - Sắp xếp - </option>';
        foreach ($arrOptions as $key => $value) {
            $selected = $key == $keySelected ? 'selected' : '';
            $options .= sprintf('<option %s value="%s">%s</option>', $selected, $key, $value);
        }

        $xhtml = sprintf('
            <select class="form-select" id="%s" name="%s">
                %s
            </select>', $id, $name, $options);
        return $xhtml;
    }

    public static function createInputHidden($name, $value, $id = '')
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

    // public static function createBreadcrumb($value, $params)
    // {
    //     $nameCategoryURL = URL::filterURL($value['category_name']);
    //     $linkCategory = URL::createLink($params['module'], 'book', 'list', ['category_id' => $value['category_id']], "$nameCategoryURL-{$value['id']}.html");
    //     $xhtml = '<div class="breadcrumb-section">
    //                 <div class="container">
    //                     <div class="row">
    //                         <div class="col-12">
    //                             <div class="page-title">
    //                                 <h2 class="py-2"><a href="">'.$value['category_name'].'</a></h2>
    //                                 <h2 class="py-2">  / ' . $value['name'] . '</h2>
    //                             </div>
    //                         </div>
    //                     </div>
    //                 </div>
    //             </div>';
    //     return $xhtml;
    // }

    public static function createBreadcrumb($text)
    {
        $xhtml = '<div class="breadcrumb-section">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title">
                                    <h2 class="py-2">' . $text . '</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>';
        return $xhtml;
    }

    public static function createXhtmlBooks($listBooks, $params, $hasSize = false, $classSize = '', $hasDescription = false)
    {
        $xhtml = '';
        foreach ($listBooks as $item) {
            $linkItem = URL::createLinkBookForUser($item, $params);

            $saleOff        = self::showItemSaleOff($item['sale_off']);
            $name           = (strlen($item['name']) > 45) ? (substr($item['name'], 0, 45) . '...') : $item['name'];
            $description    = (strlen($item['description']) > 1000) ? (substr($item['description'], 0, 1000) . '...') : $item['description'];
            $xhtmlDescription = $hasDescription ? '<p>' . $description . '</p>' : '';

            $price = number_format($item['price'], 0, ',', '.');
            $price = ($saleOff != null) ? $price = '<del>' . $price . ' đ</del>' : '';
            $priceAfterSaleOff = self::priceAfterSaleOff($item['price'], $item['sale_off']);

            $linkOrder = URL::createLink($params['module'], 'index', 'order', ['book_id' => $item['id'], 'price' => $priceAfterSaleOff]);

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
            $link = URL::createLinkBookForUser($book, $params);

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

    public static function createQueryBooks()
    {
        $query[]     = "SELECT `b`.`id`, `b`.`name`, `b`.`description`, `b`.`picture`, `b`.`price`, `b`.`sale_off`, `b`.`category_id`, `c`.`name` as `category_name`";
        $query[]     = "FROM `" . TBL_BOOK . "` as `b`, `" . TBL_CATEGORY . "` as `c`";
        $query[]     = "WHERE `b`.`category_id` = `c`.`id`";

        $query        = implode(" ", $query);
        return $query;
    }
}
