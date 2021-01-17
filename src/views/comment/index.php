<?php

use yagiztr\movie\models\Movie;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\comment\models\CommentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Comments';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comment-index">
    <a href="<?php echo Url::toRoute(['/movie/movie/index']); ?>" style="font-size:2em; margin-right:2em;">Movies</a>
    <a href="<?php echo Url::toRoute(['/watchlist/watchlist/index']); ?>" style="font-size:2em; margin-right:2em;">My Watchlists</a>
    <a href="<?php echo Url::toRoute(['/comment/comment/index']); ?>" style="font-size:2em;">My Comments</a>
    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <?php
    if (Yii::$app->user->isGuest) {
        echo '<h4 style="color: red;">You can only view comments posted by you. Please login.</h4>';
    } else {
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                [
                    "attribute"=> "Movie Title",
                    'format' => 'raw',
                    'value' => function ($data) {
                        $movie_url = Url::toRoute(['/movie/movie/view', 'id' => $data->movie_id]);
                        $movie_name = Movie::findOne($data->movie_id)->title;
                        return "<a href=\"$movie_url\">$movie_name</a>";
                    }
                ],
                'title:ntext',
                'content:ntext',
                'created_at',

                [
                    'class' => 'yii\grid\ActionColumn',
                    "buttons" => [
                        "update" => function ($data) {
                            return "<div style=\"display: \"none\"\"/>";
                        },
                        "view" => function ($data) {
                            return "<div style=\"display: \"none\"\"/>";
                        }
                    ]
                ],
            ],
        ]);
    }
    ?>


</div>