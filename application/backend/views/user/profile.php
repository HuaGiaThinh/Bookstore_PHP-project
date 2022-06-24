<?php
$linkIndex = URL::createLink($this->params['module'], $this->params['controller'], 'index');
$data = $this->data;
$elements = [
    'email' => [
        'label'     => Form::label('Email', false),
        'element'   => Form::input('text', 'form[email]', @$data['email'], 'form-control', 'readOnly'),
    ],
    'username' =>   [
        'label'     => Form::label('Username', false),
        'element'   => Form::input('text', 'form[username]', @$data['username'], 'form-control', 'readOnly'),
    ],
    'fullname' => [
        'label'     => Form::label('Fullname', false),
        'element'   => Form::input('text', 'form[fullname]', @$data['fullname'], 'form-control'),
    ],
    'phone' => [
        'label'     => Form::label('Phone', false),
        'element'   => Form::input('number', 'form[phone]', @$data['phone'], 'form-control'),
    ],
    'address' => [
        'label'     => Form::label('Address', false),
        'element'   => Form::input('text', 'form[address]', @$data['address'], 'form-control'),
    ],
];

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