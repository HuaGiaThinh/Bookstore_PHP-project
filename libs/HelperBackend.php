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

        $link = URL::createLink($module, $controller, 'ajaxStatus', ['id' => $id, 'status' => $status]);

        return sprintf('<a id="status-%s" href="javascript:changeStatus(\'%s\');" class="btn btn-%s rounded-circle btn-sm"><i class="fas fa-%s"></i></a>', $id, $link, $activeClass, $activeIcon);
    }

    public static function showItemGroupACP($id, $groupACP, $module = 'backend', $controller = 'group')
    {
        $activeClass = 'success';
        $activeIcon = 'check';

        if ($groupACP == 0) {
            $activeClass = 'danger';
            $activeIcon = 'minus';
        }

        $link = URL::createLink($module, $controller, 'ajaxACP', ['id' => $id, 'group_acp' => $groupACP]);

        return sprintf('<a id="groupACP-%s" href="javascript:changeGroupACP(\'%s\');" class="btn btn-%s rounded-circle btn-sm"><i class="fas fa-%s"></i></a>', $id, $link, $activeClass, $activeIcon);
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
