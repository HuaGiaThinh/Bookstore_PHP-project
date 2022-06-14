<?php
$linkIndex = URL::createLink($this->params['module'], $this->params['controller'], 'index');


$arrOptions = [
    'group'     => ['default' => '- Select Group -', 1 => 'Admin', 2 => 'Manager', 3 => 'Member', 4 => 'Register'],
    'status'    => ['default' => '- Select Status -', 'active' => 'Active', 'inactive' => 'Inactive']
];

$elements = [
    [
        'label'     => Form::label('Username', 'text-danger'),
        'element'   => Form::input('text', 'form[username]', @$this->data['username'], 'form-control'),
    ],
    [
        'label'     => Form::label('Password', 'text-danger'),
        'element'   => Form::input('password', 'form[password]', @$this->data['password'], 'form-control'),
    ],
    [
        'label'     => Form::label('Email', 'text-danger'),
        'element'   => Form::input('text', 'form[email]', @$this->data['email'], 'form-control'),
    ],
    [
        'label'     => Form::label('Fullname', 'text-danger'),
        'element'   => Form::input('text', 'form[fullname]', @$this->data['fullname'], 'form-control'),
    ],
    [
        'label'     => Form::label('Status', 'text-danger'),
        'element'   => Form::select('form[status]', $arrOptions['status'], 'custom-select', @$this->data['status'])
    ],
    [
        'label'     => Form::label('Group', 'text-danger'),
        'element'   => Form::select('form[group_id]', $arrOptions['group'], 'custom-select', @$this->data['group_id'])
    ]
];

if (isset($this->params['id'])) {
    $elements[0]['element'] = Form::input('text', 'form[username]', @$this->data['username'], 'form-control','readOnly');
    unset($elements[1]);
    $elements[2]['element'] = Form::input('text', 'form[email]', @$this->data['email'], 'form-control', 'readOnly');
}
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <?= $this->errors ?? ''; ?>
            <form action="" method="POST" name="main-form">
                <div class="card card-outline card-info">
                    <div class="card-body">
                        <?= Form::showElements($elements);?>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success">Save</button>
                        <a href="<?= $linkIndex;?>" class="btn btn-danger">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>