<?php
$message    = HelperBackend::showMessage();

$linkIndex  = URL::createLink($this->params['module'], $this->params['controller'], 'index');
$linkAdd    = URL::createLink($this->params['module'], $this->params['controller'], 'form');
$addButton  = HelperBackend::createButton($linkAdd, 'info', '<i class="fas fa-plus"></i> Add New');
$xhtmlFilterStatus = HelperBackend::showFilterStatus($this->countItemFilter, $this->params, ($this->params['search'] ?? ''));

$items = $this->items;
$xhtml = '';
if (!empty($items)) {
    foreach ($items as $item) {
        $id          = $item['id'];
        $status      = HelperBackend::showItemStatus($id, $item['status'], $this->params);
        $created     = HelperBackend::showItemHistory($item['created_by'], $item['created']);
        $modified    = HelperBackend::showItemHistory($item['modified_by'], $item['modified']);

        $groupList = $this->groupSelect;
        unset($groupList['default']);
        $linkAjaxGroup = URL::createLink($this->params['module'], $this->params['controller'], 'changeGroup', ['id' => $id, 'group_id' => 'value_new']);
        $attrGroup = 'data-url="' . $linkAjaxGroup . '"';
        $groupSelect = Form::select('', $groupList, 'custom-select w-auto slb-group', $item['group_id'], $attrGroup);

        $arrInfo     = ['username' => $item['username'], 'fullname' => $item['fullname'], 'email' => $item['email']];
        $info        = HelperBackend::showInfo(@$this->params['search'], $arrInfo);

        $linkEdit    = URL::createLink($this->params['module'], $this->params['controller'], 'form', ['id' => $id]);
        $linkDelete  = URL::createLink($this->params['module'], $this->params['controller'], 'delete', ['id' => $id]);
        $linkResetPassword = URL::createLink($this->params['module'], $this->params['controller'], 'resetPassword', ['id' => $id]);
        $keyButton   = HelperBackend::createButton($linkResetPassword, 'secondary', '<i class="fas fa-key"></i>', true, true);
        $editButton  = HelperBackend::createButton($linkEdit, 'info', '<i class="fas fa-pen"></i>', true, true);
        $trashButton = HelperBackend::createButton($linkDelete, 'danger', '<i class="fas fa-trash "></i>', true, true, 'btn-delete');

        $xhtml .= '
            <tr>
                <td><input type="checkbox" name="cid[]" value="' . $id . '"></td>
                <td>' . $id . '</td>
                <td class="text-left">' . $info . '</td>
                <td class="position-relative">' . $groupSelect . '</td>
                <td class="position-relative">' . $status . '</td>
                <td>' . $created . '</td>
                <td>' . $modified . '</td>
                <td> ' . $keyButton . $editButton . $trashButton . '</td>
            </tr>
        ';
    }
}

// pagination
$xhtmlPagination = $this->pagination->showPagination();
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Search & Filter -->
            <div class="card card-outline card-info">
                <div class="card-header">
                    <h3 class="card-title">Search & Filter</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="container-fluid">
                        <div class="row justify-content-between align-items-center">
                            <div class="area-filter-status mb-2">
                                <?= $xhtmlFilterStatus; ?>
                            </div>
                            <div class="area-filter-attribute mb-2">
                                <form action="" method="GET" name="filter-form" id="filter-form">
                                    <?= HelperBackend::input('hidden', 'module', $this->params['module']); ?>
                                    <?= HelperBackend::input('hidden', 'controller', $this->params['controller']); ?>
                                    <?= HelperBackend::input('hidden', 'action', 'index'); ?>
                                    <?= Form::select('group_id', $this->groupSelect, 'custom-select filter-element', @$this->params['group_id']) ?>
                                </form>
                            </div>
                            <div class="area-search mb-2">
                                <form action="" method="GET" name="search-form">
                                    <div class="input-group">
                                        <?= HelperBackend::input('hidden', 'module', $this->params['module']); ?>
                                        <?= HelperBackend::input('hidden', 'controller', $this->params['controller']); ?>
                                        <?= HelperBackend::input('hidden', 'action', 'index'); ?>

                                        <input type="text" class="form-control" name="search" placeholder="Enter search keyword..." aria-label="Enter search keyword" value="<?= @$this->params['search'] ?>">
                                        <span class="input-group-append">
                                            <button type="submit" class="btn btn-info">Search</button>
                                            <a href="<?= $linkIndex; ?>" class="btn btn-danger">Clear</a>
                                        </span>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- List -->
            <div class="card card-outline card-info">
                <div class="card-header">
                    <h3 class="card-title">List</h3>

                    <div class="card-tools">
                        <a href="#" class="btn btn-tool" data-card-widget="refresh">
                            <i class="fas fa-sync-alt"></i>
                        </a>
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <form action="" method="POST" name="main-form" id="main-form">
                        <div class="container-fluid">
                            <div class="row align-items-center justify-content-between mb-2">
                                <div>
                                    <!-- BULK ACTION -->
                                    <?= HelperBackend::createBulkAction($this->params)?>
                                </div>
                                <div>
                                    <?= $addButton; ?>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <?= $message; ?>
                            <table class="table align-middle text-center table-bordered">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" name="checkall-toggle"></th>
                                        <th>ID</th>
                                        <th class="text-left">Info</th>
                                        <th>Group</th>
                                        <th>Status</th>
                                        <th>Created</th>
                                        <th>Modified</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?= $xhtml; ?>
                                </tbody>
                            </table>
                        </div>
                        <?= HelperBackend::input('hidden', 'filter_page', '1'); ?>
                    </form>
                </div>
                <div class="card-footer clearfix">
                    <?= $xhtmlPagination; ?>
                </div>
            </div>
        </div>
    </div>
</div>