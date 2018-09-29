<?php
/* @var $this yii\web\View */
/* @var $currentUser frontend\models\User */
/* @var $post frontend\models\Post*/

use yii\helpers\Html;
use dosamigos\fileupload\FileUpload;
use frontend\assets\PostAsset;
use yii\helpers\Url;

$this->title = Html::encode($user->username);
PostAsset::register($this);
?>

<div class="row">
    <div class="col-md-12">
        <div class="text-center">
            <img src="<?php echo $currentUser->getProfileImg(); ?>" alt="" id="profile-img" class="img-thumbnail">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 text-center">
        <h2><?php echo Html::encode($currentUser->username); ?></h2>
    </div>
</div>
<div class="row">
    <div class="col-md-12 text-center">
        <h5>Welcome home, <?php echo Html::encode($currentUser->username); ?></h5>
    </div>
</div>
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
            <button class="btn btn-success add-comment">Add new comment</button>
        </div>
    </div>
</div>
<hr>
<?php endforeach; ?>