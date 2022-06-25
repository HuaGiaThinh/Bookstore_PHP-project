<?php
$linkIndex = URL::createLink($this->params['module'], $this->params['controller'], 'index');


$arrOptions = [
    'status'    => ['default' => '- Select Status -', 'active' => 'Active', 'inactive' => 'Inactive']
];
$elements = [
    [
        'label'     => Form::label('Name'),
        'element'   => Form::input('text', 'form[name]', @$this->data['name'], 'form-control'),
    ],
    [
        'label'     => Form::label('Status'),
        'element'   => Form::select('form[status]', $arrOptions['status'], 'custom-select', @$this->data['status'])
    ]

];
?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <?= $this->errors ?? ''; ?>
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