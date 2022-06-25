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
    public static function showUserInfo($searchValue, $arrInfo)
    {
        $xhtml = '';
        foreach ($arrInfo as $key => $value) {
            $value = HelperBackend::highlight($searchValue, $value);
            $xhtml .= sprintf('<p class="mb-0">%s: %s</p>', ucfirst($key), $value);
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
}
