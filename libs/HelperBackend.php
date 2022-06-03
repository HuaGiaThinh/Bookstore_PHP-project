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

        $linkStatus = URL::createLink($module, $controller, 'changeStatus', ['id' => $id, 'status' => $status]);

        return sprintf('<a href="%s" class="btn btn-%s rounded-circle btn-sm"><i class="fas fa-%s"></i></a>', $linkStatus, $activeClass, $activeIcon);
    }

    public static function showItemGroupACP($status)
    {
        $activeClass = 'success';
        $activeIcon = 'check';

        if ($status == 0) {
            $activeClass = 'danger';
            $activeIcon = 'minus';
        }
        return sprintf('<a href="#" class="btn btn-%s rounded-circle btn-sm"><i class="fas fa-%s"></i></a>', $activeClass, $activeIcon);
    }

    public static function showItemHistory($createdBy, $time)
    {
        $time = date('d-m-Y', strtotime($time));

        return sprintf(
            '
            <p class="mb-0"><i class="far fa-user"></i>%s</p>
            <p class="mb-0"><i class="far fa-clock"></i>%s</p>',
            $createdBy,
            $time
        );
    }
}
