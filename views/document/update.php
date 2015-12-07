<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\widgets\FileInput;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Document */

$this->title = 'Update Document: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Documents', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['update', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="document-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

    <?= FileInput::widget([
        'name' => 'files[]',
        'options'=>[
            'multiple'=>true,
        ],
        'pluginOptions' => [
            'showPreview'=>false,
            'showRemove'=>false,
            'uploadUrl' => Url::to(['/document/upload']),
            'uploadExtraData' => [
                'id' => $model->id,
            ],
            'maxFileCount' => 10
        ],
        'pluginEvents' => [
            'fileuploaded' => 'function() { $.pjax.reload({container:"#attachments-list-pjax"}); }',
        ]
    ]) ?>

    <?php \yii\widgets\Pjax::begin([
        'id' => 'attachments-list-pjax',
    ]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'class' => \kotchuprik\sortable\grid\Column::className(),
            ],
            [
                'attribute' => 'original_name',
                'enableSorting' => false,
            ],
            [
                'attribute' => 'size',
                'enableSorting' => false,
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}',
                'buttons' => [
                    'delete' => function ($url, $model) {
                        return Html::tag('span', Html::a('<span class="glyphicon glyphicon-trash"></span>',
                            ['delete-attachment', 'id' => $model->id]));
                    },
                ]
            ],
        ],
        'options' => [
            'data' => [
                'sortable-widget' => 1,
                'sortable-url' => \yii\helpers\Url::toRoute(['sorting']),
            ]
        ],
    ]); ?>
    <?php \yii\widgets\Pjax::end(); ?>
</div>
