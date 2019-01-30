<?php
/* @var $this yii\web\View */
/* @var $currentUser frontend\models\User */
/* @var $feeds frontend\models\Feed*/

use yii\helpers\Html;
use frontend\assets\PostAsset;
use yii\helpers\Url;

$this->title = Html::encode('Feed');
PostAsset::register($this);
?>
<?php if($feeds): ?>
    <?php foreach ($feeds as $item): ?>
        <div class="container-fluid main mb-md-2">
            <div class="mx-auto col-md-6 py-sm-2 row-content" post-id="<?php echo Html::encode($item->post_id); ?>">
                <div class="row border px-sm-1" style="background-color: #f2e1ff">
                    <img src="<?php echo Html::encode($item['author_photo']); ?>" class="float-left p-sm-1" style="width: 50px; height: 50px">
                    <div class="col my-auto pl-sm-2">
                        <h5 class="my-auto font-weight-light"><a href="<?php echo Url::toRoute(['/user/profile/view', 'nickname' => $item->author_nickname]); ?>" class="text-capitalize m-0 text-danger" style="text-decoration: none;"><?php echo Html::encode($item->author_nickname); ?></a> <a href="<?php echo Url::toRoute(['/post/default/view', 'id' => $item->post_id]);?>" class="text-dark" style="text-decoration: none;">posted on <?php echo Html::encode($item['post_created_at']); ?></a></h5>
                    </div>
                </div>
                <div class="row border border-top-0">
                    <div class="col-md-12 px-sm-2">
                        <p class="h3 p-sm-2 font-weight-light"><?php echo Html::encode($item['post_title']); ?></p>
                    </div>
                    <div class="col-md-12 px-sm-2">
                        <p class="p-sm-2 font-weight-light mb-sm-1 mt-sm-1"><?php echo Html::encode($item['post_content']); ?></p>
                    </div>
                    <div class="row mx-auto col-md-12 p-sm-1 border-top" style="border-color:#f2e1ff">
                        <div class="col px-0">
                            <?php if($item->post->isLiked($currentUser->getId())): ?>
                                <button class="btn btn-success btn-unlike" data-id="<?php echo Html::encode($item['post_id']);?>"><i class="fas fa-heart">&nbsp;&nbsp;</i><?php echo Html::encode($item->post->countLikes());?></button>
                                <button style="display:none;" class="btn btn-danger btn-like" data-id="<?php echo Html::encode($item['post_id']);?>"><i class="fas fa-heart">&nbsp;&nbsp;</i><?php echo Html::encode($item->post->countLikes());?></button>
                            <?php else:?>
                                <button style="display:none;" class="btn btn-success btn-unlike" data-id="<?php echo Html::encode($item['post_id']);?>"><i class="fas fa-heart">&nbsp;&nbsp;</i><?php echo Html::encode($item->post->countLikes());?></button>
                                <button class="btn btn-danger btn-like" data-id="<?php echo Html::encode($item['post_id']);?>"><i class="fas fa-heart">&nbsp;&nbsp;</i><?php echo Html::encode($item->post->countLikes());?></button>
                            <?php endif;?>
                        </div>
                        <div class="col text-right px-0">
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-cog">&nbsp;</i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <?php if($currentUser->getId() == $item->author->getId()):?>
                                        <a class="dropdown-item" href="#">Delete post</a>
                                    <?php else: ?>
                                        <a class="dropdown-item" href="#">Report post</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <div class="container-fluid main mb-md-2">
        <div class="mx-auto col-md-6 py-sm-2 row-content text-center">
            <h1>No posts here :(</h1>
        </div>
    </div>
<?php endif; ?>
