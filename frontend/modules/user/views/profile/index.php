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

<div class="row">
    <div class="col-md-12">
        <div class="text-center">
            <img src="<?php echo $user->getProfileImg(); ?>" alt="" id="profile-img" class="img-thumbnail">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 text-center">
        <h2><?php echo Html::encode($user->username); ?></h2>
    </div>
</div>
<div class="row">
    <div class="col-md-12 text-center">
        <h5>Welcome home, <?php echo Html::encode($user->username); ?></h5>
    </div>
</div>

<?php if($user->getId() != $currentUser->getId()): ?>
<div class="row">
    <div class="col-md-12 text-center">
        <?php if($currentUser->isSubscriber($user->getId())): ?>
            <button class="btn btn-info btn-unsub">Unsubscribe</button>
            <button style="display:none;" class="btn btn-info btn-sub">Subscribe</button>
        <?php else: ?>
            <button class="btn btn-info btn-sub" >Subscribe</button>
            <button style="display:none;" class="btn btn-info btn-unsub">Unsubscribe</button>
        <?php endif; ?>
    </div>
</div>
<?php endif;?>

<?php if($user->getId() == $currentUser->getId()): ?>
<div class="row">
    <div class="col-md-12">
        <br>
        <div class="text-center"><?= FileUpload::widget([
                'model' => $modelProfileImg,
                'attribute' => 'profileImg',
                'url' => ['profile/upload-profile-img', 'id' => $model->id],
                'options' => ['accept' => 'image/*'],
                'clientOptions' => [
                    'maxFileSize' => 2000000,
                ],
                // Also, you can specify jQuery-File-Upload events
                // see: https://github.com/blueimp/jQuery-File-Upload/wiki/Options#processing-callback-options
                'clientEvents' => [
                    'fileuploaddone' => 'function(e, data) {
                        if (data.result.success){
                                //$("#profile-image-success").show();
                                //$("#profile-image-fail").hide();
                                $("#profile-img").attr("src", data.result.ProfileImgUri);
                            }
                            /*else{
                                $("#profile-image-fail").html(data.result.errors.picture).show();
                                $("#profile-image-success").hide();
                            }*/
                }',
                ],
            ]); ?></div>
    </div>
</div>
<?php endif; ?>

<?php foreach ($posts as $item): ?>
<hr>
<div class="container-fluid postMin">
    <div class="row">
        <div class="col-md-12 text-center">
            <a href="/post/<?php echo $item['id']; ?>"><h3><?php echo $item['title']; ?></h3></a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 text-center">
            <h4><?php echo $item['content'] ?></h4>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 text-center">
            <h5><?php echo $item['creation_time'] ?></h5>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 text-center">
            <?php if($item->isLiked($currentUser->getId())): ?>
                <button class="btn btn-success btn-unlike" data-id="<?php echo $item['id'];?>"><i class="fas fa-heart">&nbsp;</i><?php echo $item->countLikes();?></button>
                <button style="display:none;" class="btn btn-danger btn-like" data-id="<?php echo $item['id'];?>"><i class="fas fa-heart">&nbsp;</i><?php echo $item->countLikes();?></button>
            <?php else:?>
                <button style="display:none;" class="btn btn-success btn-unlike" data-id="<?php echo $item['id'];?>"><i class="fas fa-heart">&nbsp;</i><?php echo $item->countLikes();?></button>
                <button class="btn btn-danger btn-like" data-id="<?php echo $item['id'];?>"><i class="fas fa-heart">&nbsp;</i><?php echo $item->countLikes();?></button>
            <?php endif;?>
            <hr>
            <?php $form = ActiveForm::begin(['options' => ['class' => 'add-comment', 'data-id' => $item['id']],]);?>
                <?php
                    echo $form->field($modelComment, 'content')->textInput(['data-id'=>$item['id']]);
                    echo Html::input('submit',null,'Add comment', [
                            'name' => 'submit',
                            'class' => 'btn btn-primary add-comment',
                            'data-id' => $item['id'],
                            ]);
                ?>
            <?php $form = ActiveForm::end();?>
            <hr>
            <div class="container-fluid">
                <h4>Comments:</h4>
                <hr>
                <div class="row row-comments" data-id="<?php echo $item['id'];?>">
                    <?php foreach ($comments = $item->comments as $comment): ?>
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
<?php endforeach; ?>