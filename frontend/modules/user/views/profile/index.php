<?php
/* @var $this yii\web\View */
/* @var $user frontend\models\User */
use yii\helpers\Html;
$this->title = Html::encode($user->username);
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
        <h5>Hi, I'am <?php echo Html::encode($user->username); ?></h5>
    </div>
</div>