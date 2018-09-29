<?php
/* @var $this yii\web\View */
/* @var $user frontend\models\User */
/* @var $currentUser frontend\models\User */

use yii\helpers\Html;
use frontend\assets\PostAsset;

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
        <h5>Hi, I'am <?php echo Html::encode($user->username); ?></h5>
    </div>
</div>

<?php foreach ($posts as $item): ?>
<hr>
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
        <i class="fas fa-heart"></i>
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
    </div>
</div>
<hr>
<?php endforeach; ?>