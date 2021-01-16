<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\comment\models\CommentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Comments';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comment-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'user_id',
            'movie_id',
            'title:ntext',
            'content:ntext',
            //'created_at',

            ['class' => 'yii\grid\ActionColumn',
            "buttons" => [
                "update" => function ($data) {
                    return "<div style=\"display: \"none\"\"/>";
                },
                "view" => function ($data) {
                    return "<div style=\"display: \"none\"\"/>";
                }
            ]],
        ],
    ]); ?>


</div>
