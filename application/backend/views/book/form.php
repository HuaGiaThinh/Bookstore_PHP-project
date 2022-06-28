<?php
$linkIndex = URL::createLink($this->params['module'], $this->params['controller'], 'index');


$arrOptions = [
    'status'    => ['default' => '- Select Status -', 'active' => 'Active', 'inactive' => 'Inactive'],
    'special'    => ['default' => '- Select Special -', 1 => 'Yes', 0 => 'No']
];

$elements = [
    'name' =>   [
        'label'     => Form::label('Tên sách'),
        'element'   => Form::input('text', 'form[name]', @$this->data['name'], 'form-control'),
    ],
    // 'description' =>   [
    //     'label'     => Form::label('Mô tả', false),
    //     'element'   => Form::input('text', 'form[description]', @$this->data['description'], 'form-control'),
    // ],
    'description' =>   [
        'label'     => Form::label('Mô tả', false),
        'element'   => '<textarea name="form[description]" rows="3" class="form-control">'.@$this->data['description'].'</textarea>',
    ],
    'price' => [
        'label'     => Form::label('Giá bán'),
        'element'   => Form::input('number', 'form[price]', @$this->data['price'], 'form-control'),
    ],
    'sale_off' => [
        'label'     => Form::label('Sale off', false),
        'element'   => Form::input('number', 'form[sale_off]', @$this->data['sale_off'], 'form-control'),
    ],
    'special' => [
        'label'     => Form::label('Special'),
        'element'   => Form::select('form[special]', $arrOptions['special'], 'custom-select', @$this->data['special'])
    ],
    'status' => [
        'label'     => Form::label('Status'),
        'element'   => Form::select('form[status]', $arrOptions['status'], 'custom-select', @$this->data['status'])
    ],
    'category' => [
        'label'     => Form::label('Category'),
        'element'   => Form::select('form[category_id]', $this->categorySelect, 'custom-select', @$this->data['category_id'])
    ],
    'picture' => [
        'label'     => Form::label('Picture'),
        'element'   => Form::input('file', 'picture', '', 'input-group')
    ]
];

if (isset($this->params['id'])) {
    if (isset($this->data['picture'])) {
        $picturePath    = UPLOAD_PATH . 'book/' . $this->data['picture'];
        if (file_exists($picturePath)) {
            $pictureUrl = UPLOAD_URL . 'book/' . $this->data['picture'];
        }
        $picture = sprintf('<img class="input-group" style="width:100px" src="%s" name="picture">', @$pictureUrl);
    }
}
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <?= $this->errors ?? ''; ?>
            <form action="" method="POST" name="main-form" enctype="multipart/form-data">
                <div class="card card-outline card-info">
                    <div class="card-body">
                        <?= Form::showElements($elements) . @$picture ?>
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