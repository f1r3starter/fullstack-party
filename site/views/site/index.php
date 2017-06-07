<?php

/* @var $this yii\web\View */

$this->title = 'Test Assignment';
?>
<div class="site-index">
    <div class="body-content">

        <div class="row">
            <div class="col-md-2 col-md-offset-5" align="center">
                <?= yii\authclient\widgets\AuthChoice::widget([
                    'baseAuthUrl' => ['site/auth'],
                    'popupMode' => false,
                ]) ?>
            </div>
        </div>

    </div>
</div>
