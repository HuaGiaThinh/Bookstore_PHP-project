<?php
$linkIndex = URL::createLink($this->params['module'], $this->params['controller'], 'index');


$arrOptions = [
    'status'    => ['default' => '- Select Status -', 'active' => 'Active', 'inactive' => 'Inactive']
];
$elements = [
    'name' => [
        'label'     => Form::label('Name'),
        'element'   => Form::input('text', 'form[name]', @$this->data['name'], 'form-control'),
    ],
    'status' => [
        'label'     => Form::label('Status'),
        'element'   => Form::select('form[status]', $arrOptions['status'], 'custom-select', @$this->data['status'])
    ],
    'picture' => [
        'label'     => Form::label('Picture'),
        'element'   => Form::input('file', 'picture', '', 'input-group')
    ]
];

if (isset($this->params['id'])) {
    $pictureUrl = UPLOAD_URL . 'category/' . $this->data['picture'];

    $picture = sprintf('<img class="input-group" style="width:100px" src="%s" alt="%s" name="picture">', $pictureUrl, $this->data['name']);
}
?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <?= $this->errors ?? ''; ?>
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="card card-outline card-info">
                        <div class="card-body">
                            <?= Form::showElements($elements) . @$picture;?>
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