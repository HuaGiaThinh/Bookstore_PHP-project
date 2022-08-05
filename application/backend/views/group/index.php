<?php
$linkIndex  = URL::createLink($this->params['module'], $this->params['controller'], 'index');
$xhtmlFilterStatus = HelperBackend::showFilterStatus($this->countItemFilter, $this->params);

$items = $this->items;
$xhtml = '';
if (!empty($items)) {
    foreach ($items as $item) {
        $name       = HelperBackend::highlight(@$this->params['search'], $item['name']);
        $groupACP   = HelperBackend::showItemGroupACP_disable($item['group_acp']);
        $created    = HelperBackend::showItemHistory($item['created_by'], $item['created']);
        $modified   = HelperBackend::showItemHistory($item['modified_by'], $item['modified']);

        $xhtml .= '
            <tr>
                <td>' . $item['id'] . '</td>
                <td>' . $name . '</td>
                <td>' . $groupACP . '</td>
                <td>' . $created . '</td>
                <td>' . $modified . '</td>
            </tr>
        ';
    }
}

// filter group_acp
$arrGroupAcp = ['default' => 'All', 1 => 'Active', 0 => 'Inactive'];
$filterGroupAcp = HelperBackend::filterForm('filter-form', 'group_acp', @$this->params, $arrGroupAcp);

// pagination
$xhtmlPagination = $this->pagination->showPagination('');
?>
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
                        <div>
                            <?= $filterGroupAcp;?>
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
                    <div class="table-responsive">
                        <table class="table align-middle text-center table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Group ACP</th>
                                    <th>Created</th>
                                    <th>Modified</th>
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