<?php
/* @var $this yii\web\View */
/* @var $currentUser frontend\models\User */
/* @var $post frontend\models\Post*/
/* @var $user frontend\models\User*/

use yii\helpers\Html;
use dosamigos\fileupload\FileUpload;
use frontend\assets\PostAsset;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = Html::encode($user->username);
PostAsset::register($this);
?>

<div class="container-fluid main mb-md-4">
    <div class="mx-auto col-md-6 py-sm-2 row-content" post-id="<?php echo $post->id; ?>">
        <div class="row border px-sm-1" style="background-color: #f2e1ff">
            <img src="<?php echo $user->getProfileImg(); ?>" class="float-left p-sm-1" style="width: 50px; height: 50px">
            <div class="col my-auto pl-sm-2">
                <h5 class="my-auto font-weight-light"><a href="<?php echo Url::toRoute(['/user/profile/view', 'nickname' => $post->user->getNickname()]); ?>" class="text-capitalize m-0 text-danger" style="text-decoration: none;"><?php echo Html::encode($user->username); ?></a> <a href="<?php echo Url::toRoute(['/post/default/view', 'id' => $post->id]);?>" class="text-dark" style="text-decoration: none;">posted on <?php echo Html::encode($post['creation_time']); ?></a></h5>
            </div>
        </div>
        <div class="row border border-top-0">
            <div class="col-md-12 px-sm-2">
                <p class="h3 p-sm-2 font-weight-light"><?php echo Html::encode($post['title']); ?></p>
            </div>
            <div class="col-md-12 px-sm-2">
                <p class="p-sm-2 font-weight-light mb-sm-1 mt-sm-1"><?php echo Html::encode($post['content']); ?></p>
            </div>
            <div class="row mx-auto col-md-12 p-sm-1 border-top" style="border-color:#f2e1ff">
                <div class="col px-0">
                    <?php if($post->isLiked($currentUser->getId())): ?>
                        <button class="btn btn-success btn-unlike" data-id="<?php echo Html::encode($post['id']);?>"><i class="fas fa-heart">&nbsp;&nbsp;</i><?php echo Html::encode($post->countLikes());?></button>
                        <button style="display:none;" class="btn btn-danger btn-like" data-id="<?php echo Html::encode($post['id']);?>"><i class="fas fa-heart">&nbsp;&nbsp;</i><?php echo Html::encode($post->countLikes());?></button>
                    <?php else:?>
                        <button style="display:none;" class="btn btn-success btn-unlike" data-id="<?php echo Html::encode($post['id']);?>"><i class="fas fa-heart">&nbsp;&nbsp;</i><?php echo Html::encode($post->countLikes());?></button>
                        <button class="btn btn-danger btn-like" data-id="<?php echo Html::encode($post['id']);?>"><i class="fas fa-heart">&nbsp;&nbsp;</i><?php echo Html::encode($post->countLikes());?></button>
                    <?php endif;?>
                </div>
                <div class="col text-right px-0">
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-cog">&nbsp;</i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="#">Delete post</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php foreach ($comments = $post->comments as $comment): ?>
        <div class="row-comment" comment-id="<?php echo $comment->id;?>" post-id="<?php echo $post->id ?>">
            <div class="mx-auto col-md-6 border row-comment-title">
                <div class="row" style="background-color: #f2e1ff">
                    <div class="col-sm-11 px-sm-1">
                        <a href="<?php echo Url::toRoute(['profile/view', 'nickname' => $comment->user->getNickname()]); ?>"><img src="<?php echo $comment->user->getProfileImg(); ?>" class="float-left p-sm-1 mr-sm-2" style="width: 30px; height: 30px"></a>
                        <p class="my-auto px-sm-2 pt-sm-1"><?php echo Html::encode($comment->nickname); ?> commented on <?php echo Html::encode($comment->creation_time);?></p>
                    </div>
                    <?php if($currentUser->getNickname() == $comment->nickname): ?>
                        <div class="col-sm-1 text-right px-sm-2 my-auto">
                            <p class="mb-0"><a href="" class="my-auto text-right text-danger delete-comment" comment-id="<?php echo Html::encode($comment->id);?>"><i class="fas fa-times"></i></a></p>
                        </div>
                    <?php endif;?>
                </div>
            </div>
            <div class="mx-auto col-md-6 border row-comment-content mb-sm-2">
                <div class="row">
                    <p class="px-sm-2 pt-sm-2 mb-sm-2"><?php echo Html::encode($comment->content); ?></p>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

    <script type="text/template" class="template" post-id="<?php echo $post->id; ?>">
        <div class="row-comment" comment-id="<%-rc.comment.id%>" post-id="<%-rc.comment.post_id%>">
            <div class="mx-auto col-md-6 border row-comment-title">
                <div class="row" style="background-color: #f2e1ff">
                    <div class="col-sm-11 px-sm-1">
                        <a href="<?php echo Url::toRoute(['profile/view', 'nickname' => $currentUser->getNickname()]); ?>"><img src="<?php echo $currentUser->getProfileImg(); ?>" class="float-left p-sm-1" style="width: 30px; height: 30px"></a>
                        <p class="my-auto px-sm-2 pt-sm-1"><%-rc.comment.nickname%> commented on <%-rc.comment.creation_time%></p>
                    </div>
                    <div class="col-sm-1 text-right px-sm-2 my-auto">
                        <p class="mb-0"><a href="" class="my-auto text-right text-danger delete-comment" comment-id="<%-rc.comment.id%>"><i class="fas fa-times"></i></a></p>
                    </div>
                </div>
            </div>
            <div class="mx-auto col-md-6 border row-comment-content mb-sm-2">
                <div class="row">
                    <p class="px-sm-2 pt-sm-2 mb-sm-2"><%-rc.comment.content%></p>
                </div>
            </div>
        </div>
    </script>

    <div class="mx-auto col-md-6 mb-sm-2 border row-input-comment px-0">
        <?php $form = ActiveForm::begin(['options' => ['class' => 'add-comment p-sm-2 my-auto row', 'post-id' => $post->id]]);?>
        <?php
        echo $form->field($modelComment, 'content', ['options'=>['class'=>'col-md-8'], 'template' => "{input}"])->textInput(['placeholder'=>'Enter your comment here', 'class'=>'form-control']); ?>
        <div class="col-md-4 text-right">
            <?php
            echo Html::input('submit',null,'Add comment', [
                'name' => 'submit',
                'class' => 'btn btn-danger add-comment',
            ]);
            ?>
        </div>

        <?php $form = ActiveForm::end();?>
    </div>
</div>