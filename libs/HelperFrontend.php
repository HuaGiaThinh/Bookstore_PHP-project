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
        $picturePath    = UPLOAD_PATH . $params['controller'] . DS . $picture;

        $pictureURL     = UPLOAD_URL . '/default' . '/defaultImage.jpg';
        if (file_exists($picturePath)) {
            $pictureURL = UPLOAD_URL . $params['controller'] . DS . $picture;
        }
        return $pictureURL;
    }
}
