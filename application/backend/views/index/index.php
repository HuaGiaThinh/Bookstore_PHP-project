<?php
$linkGroup  = URL::createLink($this->params['module'], 'group', 'index');
$linkUser   = URL::createLink($this->params['module'], 'user', 'index');

$xhtml = '';
foreach ($this->items as $key => $item) {
    $linkItem  = URL::createLink($this->params['module'], $key, 'index');
    $xhtml .= sprintf('
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>%s</h3><p>%s</p>
                </div>
                <div class="icon"><i class="ion %s"></i></div>
                <a href="%s" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>', $item['count'], ucfirst($key), $item['icon'], $linkItem);
}
?>
<div class="row">
    <?= $xhtml;?>
</div>