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
<hr>
<?php endforeach; ?>