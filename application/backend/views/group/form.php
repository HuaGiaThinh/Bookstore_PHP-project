<?php
$linkIndex = URL::createLink($this->params['module'], $this->params['controller'], 'index');

if (isset($this->errors)) {
    $errors = '';
    foreach ($this->errors as $key => $value) {
        $errors .= sprintf('<li class="text-white">%s</li>', $value);
    }
    $xhtmlError = '
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5><i class="icon fas fa-exclamation-triangle"></i> Lỗi!</h5>
            <ul class="list-unstyled mb-0">' . $errors . '</ul>
        </div>
    ';
}

$arrOptions = [
    'group_acp' => [1 => 'Active', 0 => 'Inactive'],
    'status'    => ['active' => 'Active', 'inactive' => 'Inactive']
];
$elements = [
    [
        'label'     => Form::label('Name', 'text-danger'),
        'element'   => Form::input('text', 'form[name]', @$this->data['name'], 'form-control'),
    ],
    [
        'label'     => Form::label('Group ACP', 'text-danger'),
        'element'   => Form::select('form[group_acp]', $arrOptions['group_acp'], 'Group ACP', @$this->data['group_acp'])
    ],
    [
        'label'     => Form::label('Status', 'text-danger'),
        'element'   => Form::select('form[status]', $arrOptions['status'], 'Status', @$this->data['status'])
    ]

];
?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <?= $xhtmlError ?? ''; ?>
                <form action="" method="POST">
                    <div class="card card-outline card-info">
                        <div class="card-body">
                            <?= Form::showElements($elements); ?>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success">Save</button>
                            <a href="<?= $linkIndex; ?>" class="btn btn-danger">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</div>