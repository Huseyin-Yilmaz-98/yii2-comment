<?php

use common\models\User;
use yii\helpers\Html;
use yii\widgets\DetailView;
use huseyinyilmaz\comment\models\Comment;
use huseyinyilmaz\comment\models\CommentLike;
use Yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model frontend\modules\comment\models\Comment */

/*$this->title = $model->title;*/

\yii\web\YiiAsset::register($this);
?>
<style>
    .comment-container {
        border: 1px solid black;
        margin: 5%;
    }

    .comment-text {
        margin-left: 10px;
    }

    .like-container {
        display: flex;

    }

    .liked {
        color: blue;
    }

    .like-button {
        font-size: 1.2em;
        cursor: pointer;
        font-weight: bold;
    }
</style>
<h1>Comments</h1>
<div class="comment-view">

    <?php
    $comments = Comment::find()->where("movie_id=$movie_id")->all();
    if(sizeof($comments)==0){
        echo "<p>No comments were posted for this title.</p>";
    }
    foreach ($comments as $result) {
        $comment_id = $result["id"];
        $title = $result["title"];
        $content = $result["content"];
        $created_at = $result["created_at"];
        $likes = CommentLike::find()->where("comment_id=$comment_id")->all();
        $like_count = sizeof($likes);
        $username = User::findOne($result->user_id)->username;
        $url = Url::to(["/comment/comment/like", "comment_id" => $comment_id, "user_id" => Yii::$app->user->id]);
        echo "<div class=\"comment-container\"><h3 class=\"comment-text\">$title</h3>
    <p class=\"comment-text\">$content </p>
    <p class=\"comment-text\">Posted on $created_at</p>
    <p class=\"comment-text\">Posted by $username</p>
    <div class=\"like-container\" comment-id=\"$comment_id\">
    <p class=\"comment-text like-count\">$like_count Likes</p>"; ?>
        <?php
        if (!Yii::$app->user->isGuest) {
            $getUserID = function ($el) {
                return $el->user_id;
            };
            if (in_array(Yii::$app->user->id, array_map($getUserID, $likes))) {
                $button_class = "liked";
            } else {
                $button_class = "";
            }
            echo "<p onclick=\"changeLike('$url',$comment_id)\" class=\"comment-text like-button $button_class\">Like</p>";
            if ($result->user_id == Yii::$app->user->id) {
                echo Html::a('Delete', ['/comment/comment/delete', 'id' => $comment_id], [
                    'class' => 'comment-text comment-delete',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this comment?',
                        'method' => 'post',
                    ],
                ]);
            }
            else{
                echo "<p class=\"comment-text\">You can only delete comments posted by you.</p>";
            }
        } else {
            echo "<p class=\"comment-text\">Login To Like</p>";
            echo "<p class=\"comment-text\">You can only delete comments posted by you.</p>";
        }
        ?>

    <?php echo "</div>
    </div>";
    }
    ?>
</div>

<script>
    const changeLike = (url, comment_id) => {
        fetch(url, {
                headers: {
                    'Accept': 'application/json',
                }
            }).then(res => res.json())
            .then(data => {
                if (data.success) {
                    const likeContainer = document.querySelector("div[comment-id=\"" + comment_id + "\"]");
                    const likeButton = likeContainer.getElementsByClassName("like-button")[0];
                    const wasLiked = likeButton.classList.contains("liked");
                    const likeText = likeContainer.getElementsByClassName("like-count")[0];
                    likeButton.classList.toggle("liked");
                    likeText.innerHTML = (parseInt(likeText.innerHTML.split(" ")[0]) + (wasLiked ? -1 : 1)) + " Likes"

                } else {
                    throw "Gelen yanitta success yok!"
                }
            }).catch(err => {
                alert("Begenirken hata oldu, giris yaptiginizdan emin olun, hata kodu: " + err);
            })

    }
</script>