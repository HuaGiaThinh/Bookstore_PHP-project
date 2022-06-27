<?php
$linkIndex = URL::createLink($this->params['module'], $this->params['controller'], 'index');
$arrOptions = [
    'status'    => ['default' => '- Select Status -', 'active' => 'Active', 'inactive' => 'Inactive']
];

$elements = [
    'username' =>   [
        'label'     => Form::label('Username'),
        'element'   => Form::input('text', 'form[username]', @$this->data['username'], 'form-control'),
    ],
    'password' =>   [
        'label'     => Form::label('Password'),
        'element'   => Form::input('password', 'form[password]', @$this->data['password'], 'form-control'),
    ],
    'email' => [
        'label'     => Form::label('Email'),
        'element'   => Form::input('text', 'form[email]', @$this->data['email'], 'form-control'),
    ],
    'fullname' => [
        'label'     => Form::label('Fullname', false),
        'element'   => Form::input('text', 'form[fullname]', @$this->data['fullname'], 'form-control'),
    ],
    'status' => [
        'label'     => Form::label('Status'),
        'element'   => Form::select('form[status]', $arrOptions['status'], 'custom-select', @$this->data['status'])
    ],
    'group' => [
        'label'     => Form::label('Group'),
        'element'   => Form::select('form[group_id]', $this->groupSelect, 'custom-select', @$this->data['group_id'])
    ]
];

if (isset($this->params['id'])) {
    $elements['username']['element'] = Form::input('text', 'form[username]', @$this->data['username'], 'form-control', 'readOnly');
    unset($elements['password']);
    $elements['email']['element'] = Form::input('text', 'form[email]', @$this->data['email'], 'form-control', 'readOnly');
}
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <?= $this->errors ?? ''; ?>
            <form action="" method="POST" name="main-form">
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