<?php
echo '<pre style="color: red;">';
print_r($this->data);
echo '</pre>';
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
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-exclamation-triangle"></i> Lỗi!</h5>
                <ul class="list-unstyled mb-0">
                    <li class="text-white"><b>Username:</b> Phải từ 3 đến 50 ký tự</li>
                    <li class="text-white"><b>Email:</b> Email không hợp lệ!</li>
                    <li class="text-white"><b>Group:</b> Vui lòng chọn giá trị!</li>
                    <li class="text-white"><b>Password:</b> Giá trị này không được rỗng!</li>
                </ul>
            </div> -->
            <?= $this->errors ?? ''; ?>
            <form action="" method="POST" name="main-form">
                <div class="card card-outline card-info">
                    <div class="card-body">
                        <!-- <div class="form-group">
                            <label>Username <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="username">
                        </div>
                        <div class="form-group">
                            <label>Password <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="password">
                        </div>
                        <div class="form-group">
                            <label>Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" name="email">
                        </div>
                        <div class="form-group">
                            <label>FullName</label>
                            <input type="text" class="form-control" name="fullName">
                        </div>
                        <div class="form-group">
                            <label>Status <span class="text-danger">*</span></label>
                            <select class="custom-select">
                                <option selected> - Select Status - </option>
                                <option>Active</option>
                                <option>Inactive</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Group <span class="text-danger">*</span></label>
                            <select class="custom-select">
                                <option selected> - Select Group - </option>
                                <option>Admin</option>
                                <option>Manager</option>
                                <option>Member</option>
                                <option>Register</option>
                            </select>
                        </div> -->
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