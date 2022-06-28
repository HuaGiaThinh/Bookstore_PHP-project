<?php
class HelperBackend
{
    // Lỗi
    public static function showItemStatus($id, $status, $params)
    {
        $activeClass = 'success';
        $activeIcon = 'check';

        if ($status == 'inactive') {
            $activeClass = 'danger';
            $activeIcon = 'minus';
        }

        $link = URL::createLink($params['module'], $params['controller'], 'changeStatus', ['id' => $id, 'status' => $status]);

        return sprintf('<a id="status-%s" href="%s" class="btn btn-%s rounded-circle btn-sm btn-ajax-status"><i class="fas fa-%s"></i></a>', $id, $link, $activeClass, $activeIcon);
    }

    public static function showItemGroupACP($id, $groupACP, $params)
    {
        $activeClass = 'success';
        $activeIcon = 'check';

        if ($groupACP == 0) {
            $activeClass = 'danger';
            $activeIcon = 'minus';
        }

        $link = URL::createLink($params['module'], $params['controller'], 'changeGroupAcp', ['id' => $id, 'group_acp' => $groupACP]);

        return sprintf('<a id="groupACP-%s" href="%s" class="btn btn-%s rounded-circle btn-sm btn-ajax-groupAcp"><i class="fas fa-%s"></i></a>', $id, $link, $activeClass, $activeIcon);
    }

    public static function showItemBookSpecial($id, $special, $params)
    {
        $activeClass = 'success';
        $activeIcon = 'check';

        if ($special == 0) {
            $activeClass = 'danger';
            $activeIcon = 'minus';
        }

        $link = URL::createLink($params['module'], $params['controller'], 'changeBookSpecial', ['id' => $id, 'special' => $special]);

        return sprintf('<a id="special-%s" href="%s" class="btn btn-%s rounded-circle btn-sm btn-ajax-bookSpecial"><i class="fas fa-%s"></i></a>', $id, $link, $activeClass, $activeIcon);
    }

    public static function showItemHistory($createdBy, $time)
    {
        $createdBy = $createdBy == 1 ? 'admin' : $createdBy;
        $time = date('d-m-Y', strtotime($time));

        return sprintf(
            '
            <p class="mb-0"><i class="far fa-user"></i>%s</p>
            <p class="mb-0"><i class="far fa-clock"></i>%s</p>',
            $createdBy,
            $time
        );
    }

    public static function input($type, $name, $value, $class = null, $require = null)
    {
        $xhtml = sprintf('<input type="%s" name="%s" value="%s" class="%s" %s />', $type, $name, $value, $class, $require);
        return $xhtml;
    }

    public static function label($for = null, $class = null, $text)
    {
        $xhtml = sprintf('<label for="%s" class="%s">%s</label>', $for, $class, $text);
        return $xhtml;
    }

    public static function select($name, $arrOptions, $keySelected = null)
    {
        $options = '<option>Select status</option>';
        foreach ($arrOptions as $key => $value) {
            $selected = $key == $keySelected ? 'selected' : '';
            $options .= sprintf('<option %s value="%s">%s</option>', $selected, $key, $value);
        }

        $xhtml = sprintf('
            <select class="form-select" name="%s">
                %s
            </select>', $name, $options);
        return $xhtml;
    }

    public static function showMessage()
    {
        $message = Session::get('message');
        Session::unset('message');

        if (!empty($message)) {
            $message = '
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Message!</strong> ' . $message . '
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">&times</button>
            </div>
            ';
        }
        return $message;
    }

    public static function highlight($searchValue, $item)
    {
        if (!empty($searchValue)) $item = str_replace($searchValue, "<mark>$searchValue</mark>", $item);
        return $item;
    }

    public static function showFilterStatus($arrFilter, $params)
    {
        $xhtml = '';
        $keySelected = $params['status'] ?? 'all';
        foreach ($arrFilter as $key => $value) {
            $classActive = $keySelected == $key ? 'info' : 'secondary';

            $paramsLink = ['status' => $key];
            if (isset($params['search'])) $paramsLink['search'] = $params['search'];
            if (isset($params['group_acp'])) $paramsLink['group_acp'] = $params['group_acp'];
            if (isset($params['group_id'])) $paramsLink['group_id'] = $params['group_id'];
            if (isset($params['category_id'])) $paramsLink['category_id'] = $params['category_id'];

            $link = URl::createLink($params['module'], $params['controller'], $params['action'], $paramsLink);
            $xhtml .= sprintf('<a href="%s" class="btn btn-%s">%s <span class="badge badge-pill badge-light">%s</span></a> ', $link, $classActive, ucfirst($key), $value);
        }
        return $xhtml;
    }

    public static function createButton($link, $color, $content, $isCircle = false, $isSmall = false, $class = '')
    {
        $isCircle   = $isCircle == true ? 'rounded-circle' : '';
        $isSmall    = $isSmall == true ? 'btn-sm' : '';

        return sprintf('<a href="%s" class="btn btn-%s %s %s %s">%s</a> ', $link, $color, $class, $isCircle, $isSmall, $content);
    }

    // USER =================================================================
    public static function showInfo($searchValue, $arrInfo)
    {
        $xhtml = '';
        foreach ($arrInfo as $key => $value) {
            $value = HelperBackend::highlight($searchValue, $value);
            $xhtml .= sprintf('<p class="mb-0">%s: <b>%s</b></p>', ucfirst($key), $value);
        }
        return $xhtml;
    }

    public static function randomString($n = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
      
        for ($i = 0; $i < $n; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }
      
        return $randomString;
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
