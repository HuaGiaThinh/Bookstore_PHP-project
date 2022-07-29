<?php
$message = HelperBackend::showMessage();

$linkIndex  = URL::createLink($this->params['module'], $this->params['controller'], 'index');
$linkAdd    = URL::createLink($this->params['module'], $this->params['controller'], 'form');
$xhtmlFilterStatus = HelperBackend::showFilterStatus($this->countItemFilter, $this->params);

$items = $this->items;
$xhtml = '';
if (!empty($items)) {
    foreach ($items as $item) {
        $id         = $item['id'];
        $name       = HelperBackend::highlight(@$this->params['search'], $item['name']);
        $status     = HelperBackend::showItemStatus($id, $item['status'], $this->params);
        $showAtHome = HelperBackend::showItemShowAtHome($id, $item['show_at_home'], $this->params);
        $ordering   = HelperBackend::showInputOrdering($id, $item['ordering'], $this->params);
        $created    = HelperBackend::showItemHistory($item['created_by'], $item['created']);
        $modified   = HelperBackend::showItemHistory($item['modified_by'], $item['modified']);
        $linkDelete = URL::createLink($this->params['module'], $this->params['controller'], 'delete', ['id' => $id]);
        $linkEdit   = URL::createLink($this->params['module'], $this->params['controller'], 'form', ['id' => $id]);

        // picture
        $picturePath    = UPLOAD_PATH . 'category/' . $item['picture'];
        $pictureURL     = TEMPLATE_URL . $this->params['module'] . '/images' . '/defaultImage.jpg';
        if (file_exists($picturePath)) {
            $pictureURL = UPLOAD_URL . 'category/' . $item['picture'];
        }
        // $picture = '<img style="height:90px; width:75px" src="' . $pictureURL . '">';
        $picture = '<img class="item-image w-100" src="' . $pictureURL . '">';

        $xhtml .= '
            <tr>
                <td><input type="checkbox" name="cid[]" value="' . $id . '"></td>
                <td>' . $id . '</td>
                <td>' . $name . '</td>
                <td>' . $picture . '</td>
                <td class="position-relative">' . $status . '</td>
                <td class="position-relative">' . $showAtHome . '</td>
                <td class="position-relative">' . $ordering . '</td>
                <td>' . $created . '</td>
                <td>' . $modified . '</td>
                <td>
                    <a href="' . $linkEdit . '" class="btn btn-info btn-sm rounded-circle"><i class="fas fa-pen"></i></a>
                    <a href="' . $linkDelete . '" class="btn-delete btn btn-danger btn-sm rounded-circle"><i class="fas fa-trash "></i></a>
                </td>
            </tr>
        ';
    }
}

// filter group_acp
$arrShowAtHome = ['default' => 'Select Show At Home', 1 => 'Yes', 0 => 'No'];
$filterShowAtHome = Form::select('show_at_home', $arrShowAtHome, 'filter-element', @$this->params['show_at_home']);

// pagination
$xhtmlPagination = $this->pagination->showPagination();
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
                            <?= $xhtmlFilterStatus; ?>
                        </div>

                        <div>
                            <form action="" method="GET" name="filter-form" id="filter-form">
                                <?= HelperBackend::input('hidden', 'module', $this->params['module']); ?>
                                <?= HelperBackend::input('hidden', 'controller', $this->params['controller']); ?>
                                <?= HelperBackend::input('hidden', 'action', 'index'); ?>
                                <?= $filterShowAtHome; ?>
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
                                <a href="<?= $linkAdd; ?>" class="btn btn-info"><i class="fas fa-plus"></i> Add New</a>
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
                                    <th style="width: 120px; padding: 5px">Picture</th>
                                    <th>Status</th>
                                    <th>Show at home</th>
                                    <th style="width: 90px">Ordering</th>
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