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
<div class="container-fluid postMin">
    <div class="row">
        <div class="col-md-12 text-center">
            <a href="/post/<?php echo $post['id']; ?>"><h3><?php echo $post['title']; ?></h3></a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 text-center">
            <h4><?php echo $post['content'] ?></h4>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 text-center">
            <h5><?php echo $post['creation_time'] ?></h5>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 text-center">
            <?php if($post->isLiked($currentUser->getId())): ?>
                <button class="btn btn-success btn-unlike" data-id="<?php echo $post['id'];?>"><i class="fas fa-heart">&nbsp;</i><?php echo $post->countLikes();?></button>
                <button style="display:none;" class="btn btn-danger btn-like" data-id="<?php echo $post['id'];?>"><i class="fas fa-heart">&nbsp;</i><?php echo $post->countLikes();?></button>
            <?php else:?>
                <button style="display:none;" class="btn btn-success btn-unlike" data-id="<?php echo $post['id'];?>"><i class="fas fa-heart">&nbsp;</i><?php echo $post->countLikes();?></button>
                <button class="btn btn-danger btn-like" data-id="<?php echo $post['id'];?>"><i class="fas fa-heart">&nbsp;</i><?php echo $post->countLikes();?></button>
            <?php endif;?>
            <hr>
            <?php $form = ActiveForm::begin(['options' => ['class' => 'add-comment', 'data-id' => $post['id']],]);?>
                <?php
                    echo $form->field($modelComment, 'content')->textInput(['data-id'=>$post['id']]);
                    echo Html::input('submit',null,'Add comment', [
                        'name' => 'submit',
                        'class' => 'btn btn-primary add-comment',
                        'data-id' => $post['id'],
                    ]);
                ?>
            <?php $form = ActiveForm::end();?>
            <hr>
            <div class="container-fluid">
                <h4>Comments:</h4>
                <hr>
                <div class="row row-comments" data-id="<?php echo $post['id'];?>">
                    <?php foreach ($comments = $post->comments as $comment): ?>
                        <div class="comment" data-id="<?php echo $comment->id ?>">
                            <a href="<?php echo Url::toRoute(['profile/view', 'nickname' => $comment->nickname])?>"><h4><?php echo $comment->nickname; ?></h4></a>
                            <p><?php echo $comment->content; ?></p>
                            <small><?php echo $comment->creation_time; ?></small>
                            <?php if($currentUser->getNickname() == $comment->nickname): ?>
                                <button class="btn btn-xs btn-warning delete-comment" data-id="<?php echo $comment->id ?>">Delete comment</button>
                            <?php endif; ?>
                            <hr>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<hr>