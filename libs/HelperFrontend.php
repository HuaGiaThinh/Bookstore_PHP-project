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

    public static function createInput($name, $value, $id)
    {
        return sprintf('<input type="hidden" name="form[%s][]" value="%s" id="input_%s">', $name, $value, $id);
    }
}
