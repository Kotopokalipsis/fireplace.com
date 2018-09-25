<?php
/* @var $this yii\web\View */
/* @var $user frontend\models\User */
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
</div>
<hr>
<?php endforeach; ?>
