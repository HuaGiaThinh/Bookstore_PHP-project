<?php
echo '<pre style="color: red;">';
print_r($this->params);
echo '</pre>';
$message = HelperBackend::showMessage();

$linkIndex = URL::createLink($this->params['module'], $this->params['controller'], $this->params['action']);

$items = $this->items;
$xhtml = '';
if (!empty($items)) {
    foreach ($items as $item) {
        $id         = $item['id'];
        $name       = HelperBackend::highlight(@$this->params['search'], $item['name']);
        $groupACP   = HelperBackend::showItemGroupACP($id, $item['group_acp']);
        $status     = HelperBackend::showItemStatus($id, $item['status']);
        $created    = HelperBackend::showItemHistory($item['created_by'], $item['created']);
        $modified   = HelperBackend::showItemHistory($item['modified_by'], $item['modified']);
        $linkDelete = URL::createLink($this->params['module'], $this->params['controller'], 'delete', ['id' => $id]);
        $xhtml .= '
            <tr>
                <td><input type="checkbox" name="cid[]" value="'.$id.'"></td>
                <td>' . $id . '</td>
                <td>' . $name . '</td>
                <td>' . $groupACP . '</td>
                <td>' . $status . '</td>
                <td>' . $created . '</td>
                <td>' . $modified . '</td>
                <td>
                    <a href="#" class="btn btn-info btn-sm rounded-circle"><i class="fas fa-pen"></i></a>
                    <a href="javascript:deleteItem(\'' . $linkDelete . '\')" class="btn btn-danger btn-sm rounded-circle"><i class="fas fa-trash "></i></a>
                </td>
            </tr>
        ';
    }
}

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
                        <div class="area-filter-status mb-2">
                            <a href="#" class="btn btn-info">All <span class="badge badge-pill badge-light">8</span></a>
                            <a href="#" class="btn btn-secondary">Active <span class="badge badge-pill badge-light">3</span></a>
                            <a href="#" class="btn btn-secondary">Inactive <span class="badge badge-pill badge-light">5</span></a>
                        </div>
                        <div class="area-search mb-2">
                            <form action="" method="GET" name="search-form">
                                <div class="input-group">       
                                    <?= HelperBackend::input('hidden', 'module', $this->params['module']); ?>
                                    <?= HelperBackend::input('hidden', 'controller', $this->params['controller']); ?>
                                    <?= HelperBackend::input('hidden', 'action', 'index');?>

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
                <div class="container-fluid">
                    <div class="row align-items-center justify-content-between mb-2">
                        <div>
                            <div class="input-group">
                                <select class="form-control custom-select">
                                    <option selected disabled>Bulk Action</option>
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                    <option value="delete">Delete</option>
                                </select>
                                <span class="input-group-append">
                                    <button type="submit" class="btn btn-info">Apply</button>
                                </span>
                            </div>
                        </div>
                        <div>
                            <a href="group-form.php" class="btn btn-info"><i class="fas fa-plus"></i> Add New</a>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table align-middle text-center table-bordered">
                        <?= $message; ?>
                        <thead>
                            <tr>
                                <th><input type="checkbox" name="checkall-toggle"></th>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Group ACP</th>
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
            </div>
            <div class="card-footer clearfix">
                <ul class="pagination m-0 float-right">
                    <li class="page-item disabled"><a class="page-link" href="#"><i class="fas fa-angle-double-left"></i></a></li>
                    <li class="page-item disabled"><a class="page-link" href="#"><i class="fas fa-angle-left"></i></a></li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item"><a class="page-link" href="#"><i class="fas fa-angle-right"></i></a></li>
                    <li class="page-item"><a class="page-link" href="#"><i class="fas fa-angle-double-right"></i></a></li>
                </ul>
            </div>
        </div>
    </div>
</div>