<?php
class HelperBackend
{
    public static function showItemStatus($id, $status, $module = 'backend', $controller = 'group')
    {
        $activeClass = 'success';
        $activeIcon = 'check';

        if ($status == 'inactive') {
            $activeClass = 'danger';
            $activeIcon = 'minus';
        }

        $link = URL::createLink($module, $controller, 'changeStatus', ['id' => $id, 'status' => $status]);

        return sprintf('<a id="status-%s" href="%s" class="btn btn-%s rounded-circle btn-sm"><i class="fas fa-%s"></i></a>', $id, $link, $activeClass, $activeIcon);
    }

    public static function showItemGroupACP($id, $groupACP, $module = 'backend', $controller = 'group')
    {
        $activeClass = 'success';
        $activeIcon = 'check';

        if ($groupACP == 0) {
            $activeClass = 'danger';
            $activeIcon = 'minus';
        }

        $link = URL::createLink($module, $controller, 'changeGroupAcp', ['id' => $id, 'group_acp' => $groupACP]);

        return sprintf('<a id="groupACP-%s" href="%s" class="btn btn-%s rounded-circle btn-sm"><i class="fas fa-%s"></i></a>', $id, $link, $activeClass, $activeIcon);
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

    public static function highlight($searchValue, $name)
    {
        if (!empty($searchValue)) $name = str_replace($searchValue, "<mark>$searchValue</mark>", $name);
        return $name;
    }

    public static function showFilterStatus($arrFilter, $params, $searchKeyword = '')
    {
        $xhtml = '';
        $keySelected = $params['status'] ?? 'all';
        foreach ($arrFilter as $key => $value) {
            $classActive = $keySelected == $key ? 'info' : 'secondary';

            $link = URl::createLink($params['module'], $params['controller'], $params['action'], ['status' => $key, 'search' => $searchKeyword]);
            $xhtml .= sprintf('<a href="%s" class="btn btn-%s">%s <span class="badge badge-pill badge-light">%s</span></a> ', $link, $classActive, ucfirst($key), $value);
        }
        return $xhtml;
    }

    // USER =================================================================
    public static function showUserInfo($arrInfo)
    {
        $xhtml = '';
        foreach ($arrInfo as $key => $value) {
            $xhtml .= sprintf('<p class="mb-0">%s: %s</p>', ucfirst($key), $value);
        }
        return $xhtml;
    }
}
