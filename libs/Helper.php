<?php
class Helper
{
    public static function status($id, $status, $module = 'backend', $controller = 'group')
    {
        $activeClass = 'success';
        $activeIcon = 'check';

        if ($status == 'inactive') {
            $activeClass = 'danger';
            $activeIcon = 'minus';
        }

        $linkStatus = URL::createLink($module, $controller, 'changeStatus', ['id' => $id, 'status' => $status]);

        return sprintf('<a href="%s" class="btn btn-%s rounded-circle btn-sm"><i class="fas fa-%s"></i></a>', $linkStatus, $activeClass, $activeIcon);
    }

    public static function groupAcp($status)
    {
        $activeClass = 'success';
        $activeIcon = 'check';

        if ($status == 0) {
            $activeClass = 'danger';
            $activeIcon = 'minus';
        }
        return sprintf('<a href="#" class="btn btn-%s rounded-circle btn-sm"><i class="fas fa-%s"></i></a>', $activeClass, $activeIcon);
    }

    public static function formatDate($format, $value)
    {
        return date($format, strtotime($value));
    }
}
