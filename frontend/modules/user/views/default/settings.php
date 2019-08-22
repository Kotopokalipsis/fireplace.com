<?php
/* @var $this yii\web\View */
/* @var $profileImgModel frontend\modules\user\models\forms\ProfileImgForm */

use dosamigos\fileupload\FileUpload;
?>

<div class="container-fluid header mb-md-4">
    <div class="row">
        <div class="mx-auto col-md-6 d-flex justify-content-center py-sm-1 mt-3 border border-light" style="background-color: rgba(255,233,5,0.16)">
            <img src="<?php echo $currentUser->getProfileImg() ?>" alt="" class="">
        </div>
    </div>
    <div class="row">
        <div class="mx-auto col-md-6 d-flex justify-content-center py-sm-1 mt-3 border border-light" style="background-color: rgba(255,233,5,0.16)">
            <h3 class="px-4 font-weight-light">Change your profile image:</h3>
            <?= FileUpload::widget([
                'model' => $profileImgModel,
                'attribute' => 'profileImg',
                'url' => ['/user/default/upload-profile-img'], // your url, this is just for demo purposes,
                'options' => ['accept' => 'image/*'],
                'clientOptions' => [
                    'maxFileSize' => 2000000
                ],
                // Also, you can specify jQuery-File-Upload events
                // see: https://github.com/blueimp/jQuery-File-Upload/wiki/Options#processing-callback-options
                'clientEvents' => [
                    'fileuploaddone' => 'function(e, data) {
                                    console.log(e);
                                    console.log(data);
                                }',
                    'fileuploadfail' => 'function(e, data) {
                                    console.log(e);
                                    console.log(data);
                                }',
                ],
            ]); ?>

        </div>
    </div>
</div>


