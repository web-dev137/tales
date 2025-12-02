<?php
/** @var yii\web\View $this */
/** @var ?string $response */
/** @var app\modules\story\models\Story $model */

use app\modules\story\models\Story;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Stories';
?>

<div class="story">
    <div class="row">
        <div class="col-md-7">
            <?php $form = ActiveForm::begin(); ?>
            <?=  $form->field($model,'age') ?>
            <?= $form->field($model,'lang')
                    ->dropDownList(Story::Languages)
            ?>
            <?= $form->field($model,'characters') 
                    ->dropDownList(Story::Characters, ['multiple' => true, 'size' => 1])
            ?>
            <div class="form-group">
                <div>
                    <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary', 'name' => 'send-button']) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-7">
            Сказка:
            <p><?= $response ?></p>
        </div>
    </div>
</div>