<?php
$linkIndex = URL::createLink($this->params['module'], $this->params['controller'], $this->params['action']);
$linkCancel = URL::createLink($this->params['module'], $this->params['controller'], 'index');


$arrOptions = [
    'group'     => ['default' => '- Select Group -', 1 => 'Admin', 2 => 'Manager', 3 => 'Member', 4 => 'Register'],
    'status'    => ['default' => '- Select Status -', 'active' => 'Active', 'inactive' => 'Inactive']
];

$elements = [
    'id' =>   [
        'label'     => Form::label('ID', false),
        'element'   => Form::input('text', 'form[id]', @$this->data['id'], 'form-control', 'readOnly'),
    ],
    'username' =>   [
        'label'     => Form::label('Username', false),
        'element'   => Form::input('text', 'form[username]', @$this->data['username'], 'form-control', 'readOnly'),
    ],
    'email' => [
        'label'     => Form::label('Email', false),
        'element'   => Form::input('text', 'form[email]', @$this->data['email'], 'form-control', 'readOnly'),
    ]
];

$lblPassword    = Form::label('Password');
$buttonGenerate = HelperBackend::createButton($linkIndex, 'info', '<i class="fas fa-sync-alt"></i> Generate', false, false, 'btn-generate');
$inputPassword  = Form::input('text', 'form[password]', '', 'form-control input-password');
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <?= $this->errors ?? ''; ?>
            <form action="" method="POST" name="main-form">
                <div class="card card-outline card-info">
                    <div class="card-body">
                        <?= Form::showElements($elements)?>
                        <div class="form-group">
                            <?= $lblPassword ?>
                            <div class="input-group">
                                <?= $buttonGenerate . $inputPassword ?>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success">Save</button>
                        <a href="<?= $linkCancel; ?>" class="btn btn-danger">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>