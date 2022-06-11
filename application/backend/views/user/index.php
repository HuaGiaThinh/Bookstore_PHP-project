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
        $status      = HelperBackend::showItemStatus($id, $item['status'], $this->params['module'], $this->params['controller']);
        $created     = HelperBackend::showItemHistory($item['created_by'], $item['created']);
        $modified    = HelperBackend::showItemHistory($item['modified_by'], $item['modified']);

        $arrGroup    = ['default' => '- Select Group -', 1 => 'Admin', 2 => 'Manager', 3 => 'Member', 4 => 'Register'];
        $groupSelect = Form::select('', $arrGroup, 'form-control custom-select w-auto', $item['group_id']);

        $arrInfo     = ['username' => $item['username'], 'fullname' => $item['fullname'], 'email' => $item['email']];
        $info        = HelperBackend::showUserInfo(@$this->params['search'], $arrInfo);

        $linkEdit    = URL::createLink($this->params['module'], $this->params['controller'], 'form', ['id' => $id]);
        $linkDelete  = URL::createLink($this->params['module'], $this->params['controller'], 'delete', ['id' => $id]);
        $keyButton   = HelperBackend::createButton('#', 'secondary', '<i class="fas fa-key"></i>', true, true);
        $editButton  = HelperBackend::createButton($linkEdit, 'info', '<i class="fas fa-pen"></i>', true, true);
        $trashButton = HelperBackend::createButton('javascript:deleteItem(\'' . $linkDelete . '\')', 'danger', '<i class="fas fa-trash "></i>', true, true);

        $xhtml .= '
            <tr>
                <td><input type="checkbox" name="cid[]" value="' . $id . '"></td>
                <td>' . $id . '</td>
                <td class="text-left">' . $info . '</td>
                <td>' . $groupSelect . '</td>
                <td>' . $status . '</td>
                <td>' . $created . '</td>
                <td>' . $modified . '</td>
                <td> ' . $keyButton . $editButton . $trashButton . '</td>
            </tr>
        ';
    }
}

// pagination
$xhtmlPagination = $this->pagination->showPagination('');
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
                                <select class="form-control custom-select">
                                    <option> - Select Group - </option>
                                    <option>Admin</option>
                                    <option>Manager</option>
                                    <option>Member</option>
                                    <option>Register</option>
                                </select>
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
                                    <div class="input-group">
                                        <select class="form-control custom-select">
                                            <option>Bulk Action</option>
                                            <option>Delete</option>
                                            <option>Active</option>
                                            <option>Inactive</option>
                                        </select>
                                        <span class="input-group-append">
                                            <button type="button" class="btn btn-info">Apply</button>
                                        </span>
                                    </div>
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
                                    <!-- <tr>
                                    <td><input type="checkbox"></td>
                                    <td>1</td>
                                    <td class="text-left">
                                        <p class="mb-0">Username: admin01</p>
                                        <p class="mb-0">FullName: Nguyễn Văn A</p>
                                        <p class="mb-0">Email: admin01@example.com</p>
                                    </td>
                                    <td>
                                        <select class="form-control custom-select w-auto">
                                            <option> - Select Group - </option>
                                            <option selected>Admin</option>
                                            <option>Manager</option>
                                            <option>Member</option>
                                            <option>Register</option>
                                        </select>
                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-success rounded-circle btn-sm"><i class="fas fa-check"></i></a>
                                    </td>
                                    <td>
                                        <p class="mb-0"><i class="far fa-user"></i> admin</p>
                                        <p class="mb-0"><i class="far fa-clock"></i> 09/01/2021</p>
                                    </td>
                                    <td>
                                        <p class="mb-0"><i class="far fa-user"></i> admin</p>
                                        <p class="mb-0"><i class="far fa-clock"></i> 09/01/2021</p>
                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-secondary btn-sm rounded-circle"><i class="fas fa-key"></i></a>
                                        <a href="#" class="btn btn-info btn-sm rounded-circle"><i class="fas fa-pen"></i></a>
                                        <a href="#" class="btn btn-danger btn-sm rounded-circle"><i class="fas fa-trash "></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox"></td>
                                    <td>2</td>
                                    <td class="text-left">
                                        <p class="mb-0">Username: manager01</p>
                                        <p class="mb-0">FullName: Nguyễn Văn M</p>
                                        <p class="mb-0">Email: manager01@example.com</p>
                                    </td>
                                    <td>
                                        <select class="form-control custom-select w-auto">
                                            <option> - Select Group - </option>
                                            <option>Admin</option>
                                            <option selected>Manager</option>
                                            <option>Member</option>
                                            <option>Register</option>
                                        </select>
                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-success rounded-circle btn-sm"><i class="fas fa-check"></i></a>
                                    </td>
                                    <td>
                                        <p class="mb-0"><i class="far fa-user"></i> admin</p>
                                        <p class="mb-0"><i class="far fa-clock"></i> 09/01/2021</p>
                                    </td>
                                    <td>
                                        <p class="mb-0"><i class="far fa-user"></i> admin</p>
                                        <p class="mb-0"><i class="far fa-clock"></i> 09/01/2021</p>
                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-secondary btn-sm rounded-circle"><i class="fas fa-key"></i></a>
                                        <a href="#" class="btn btn-info btn-sm rounded-circle"><i class="fas fa-pen"></i></a>
                                        <a href="#" class="btn btn-danger btn-sm rounded-circle"><i class="fas fa-trash "></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox"></td>
                                    <td>3</td>
                                    <td class="text-left">
                                        <p class="mb-0">Username: member01</p>
                                        <p class="mb-0">FullName: Nguyễn Thị M</p>
                                        <p class="mb-0">Email: member01@example.com</p>
                                    </td>
                                    <td>
                                        <select class="form-control custom-select w-auto">
                                            <option> - Select Group - </option>
                                            <option>Admin</option>
                                            <option>Manager</option>
                                            <option selected>Member</option>
                                            <option>Register</option>
                                        </select>
                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-success rounded-circle btn-sm"><i class="fas fa-check"></i></a>
                                    </td>
                                    <td>
                                        <p class="mb-0"><i class="far fa-user"></i> admin</p>
                                        <p class="mb-0"><i class="far fa-clock"></i> 09/01/2021</p>
                                    </td>
                                    <td>
                                        <p class="mb-0"><i class="far fa-user"></i> admin</p>
                                        <p class="mb-0"><i class="far fa-clock"></i> 09/01/2021</p>
                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-secondary btn-sm rounded-circle"><i class="fas fa-key"></i></a>
                                        <a href="#" class="btn btn-info btn-sm rounded-circle"><i class="fas fa-pen"></i></a>
                                        <a href="#" class="btn btn-danger btn-sm rounded-circle"><i class="fas fa-trash "></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox"></td>
                                    <td>4</td>
                                    <td class="text-left">
                                        <p class="mb-0">Username: register01</p>
                                        <p class="mb-0">FullName: Trần Cao R</p>
                                        <p class="mb-0">Email: register01@example.com</p>
                                    </td>
                                    <td>
                                        <select class="form-control custom-select w-auto">
                                            <option> - Select Group - </option>
                                            <option>Admin</option>
                                            <option>Manager</option>
                                            <option>Member</option>
                                            <option selected>Register</option>
                                        </select>
                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-danger rounded-circle btn-sm"><i class="fas fa-check"></i></a>
                                    </td>
                                    <td>
                                        <p class="mb-0"><i class="far fa-user"></i> admin</p>
                                        <p class="mb-0"><i class="far fa-clock"></i> 09/01/2021</p>
                                    </td>
                                    <td>
                                        <p class="mb-0"><i class="far fa-user"></i> admin</p>
                                        <p class="mb-0"><i class="far fa-clock"></i> 09/01/2021</p>
                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-secondary btn-sm rounded-circle"><i class="fas fa-key"></i></a>
                                        <a href="#" class="btn btn-info btn-sm rounded-circle"><i class="fas fa-pen"></i></a>
                                        <a href="#" class="btn btn-danger btn-sm rounded-circle"><i class="fas fa-trash "></i></a>
                                    </td>
                                </tr> -->
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