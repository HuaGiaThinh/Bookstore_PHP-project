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
        foreach ($arrNav as $value) {
            $classActive = (ucfirst($params['controller']) == $value['name']) ? 'active' : '';
            if (!isset($value['navChild'])) {
                $xhtml .= sprintf('
                    <li class="nav-item">
                        <a href="%s" class="nav-link %s">
                            <i class="nav-icon fas %s"></i>
                            <p>%s</p>
                        </a>
                    </li>', $value['linkNav'], $classActive, $value['icon'], $value['name']);
            } else {
                $xhtml .= '
                    <li class="nav-item">
                        <a href="#" class="nav-link '.$classActive.'">
                            <i class="nav-icon fas '.$value['icon'].'"></i>
                            <p>'.$value['name'].'<i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="'.$value['navChild']['linkList'].'" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>List</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="'.$value['navChild']['linkAdd'].'" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Add</p>
                                </a>
                            </li>
                        </ul>
                    </li>';
            }
        }    
        return $xhtml;
    }
}
