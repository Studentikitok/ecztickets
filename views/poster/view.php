<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Poster $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Афиша', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="poster-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'tickets',
            [
                'format' => 'raw',
                'label' => 'Забронировать',
                'value' => function($model){
                    if (Yii::$app->user->isGuest) return 'Для бронирования авторизируйтесь';
                    return 
                    Html::beginForm(['/poster/order'], 'post')
                        .Html::hiddenInput('id_poster', $model->id_poster)
                        .Html::textInput('tickets', 0)
                    . Html::submitButton(
                        'Заказать билеты'
                    )
                    . Html::endForm();
                }
            ],
        ],
    ]) ?>

</div>
