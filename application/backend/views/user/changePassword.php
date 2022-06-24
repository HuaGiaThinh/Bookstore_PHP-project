<?php
$linkIndex  = URL::createLink($this->params['module'], $this->params['controller'], $this->params['action']);
$linkCancel = URL::createLink($this->params['module'], $this->params['controller'], 'index');

$elements = [
    [
        'label'     => Form::label('Mật khẩu hiện tại'),
        'element'   => Form::input('password', 'form[old_password]', '', 'form-control'),
    ],
    [
        'label'     => Form::label('Mật khẩu mới'),
        'element'   => Form::input('password', 'form[password]', '', 'form-control'),
    ],
    [
        'label'     => Form::label('Nhập lại mật khẩu mới'),
        'element'   => Form::input('password', 'form[confirm_password]', '', 'form-control'),
    ]
];
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <?= $this->errors ?? ''; ?>
            <form action="" method="POST" name="main-form">
                <div class="card card-outline card-info">
                    <div class="card-body">
                        <?= Form::showElements($elements)?>
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