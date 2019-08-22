<?php
/* @var $this yii\web\View */
/* @var $currentUser frontend\models\User */
/* @var $posts frontend\models\Post*/
/* @var $user frontend\models\User*/

use yii\helpers\Html;
use dosamigos\fileupload\FileUpload;
use frontend\assets\PostAsset;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = Html::encode($user->username);
PostAsset::register($this);
?>

<div class="container-fluid header mb-md-4">
    <div class="mx-auto col-md-6 pb-sm-1">
        <div class="row">
            <div class="mx-auto col-md-5 text-center">
                <img src="<?php echo Html::encode($user->getProfileImg()); ?>" alt="" id="profile-img" class="img-thumbnail">
            </div>
        </div>
    </div>

    <div class="mx-auto col-md-6 py-sm-1 px-0 ">
        <hr class="mx-auto mt-sm-1 border-bottom-1 border-danger mb-sm-0">
        <div class="row">
            <div class="col-md-5 text-left pt-sm-2">
                <h2 class="text-capitalize"><?php echo Html::encode($user->username); ?></h2>
            </div>
            <div class="col-lg-7 d-flex flex-row justify-content-end py-sm-2">
                <?php if($user->getId() != $currentUser->getId()): ?>
                    <?php if($currentUser->isSubscriber($user->getId())): ?>
                        <button class="btn btn-danger btn-unsub">Unsubscribe</button>
                        <button style="display:none;" class="btn btn-danger btn-sub">Subscribe</button>
                    <?php else: ?>
                        <button class="btn btn-danger btn-sub" >Subscribe</button>
                        <button style="display:none;" class="btn btn-danger btn-unsub">Unsubscribe</button>
                    <?php endif; ?>
                <?php endif;?>
                <?php if($user->getId() == $currentUser->getId()): ?>
                    <button class="btn btn-danger ml-sm-2" data-toggle="modal" data-target="#subscriptionsModal">Your subscriptions: <?php echo Html::encode($user->countSubscriptions()); ?></button>
                <?php endif;?>
                <button class="btn btn-info ml-sm-2" data-toggle="modal" data-target="#followModal">Followers: <?php echo Html::encode($user->countFollowers()); ?></button>
                <div class="dropdown ml-sm-2">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-cog">&nbsp;</i>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="<?php echo Url::toRoute('/user/default/settings') ?>">Settings</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="followModal" tabindex="-1" role="dialog" aria-labelledby="followModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="followModalLongTitle">Followers <?php echo Html::encode($user->getNickname()); ?>:</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <ul class="list-group list-group-flush">
                <?php foreach($followers = $user->getFollowers() as $follower): ?>
                    <li class="list-group-item"><?php echo Html::encode($follower->getNickname()); ?></li>
                <?php endforeach;?>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="subscriptionsModal" tabindex="-1" role="dialog" aria-labelledby="subscriptionsModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="subscriptionsModalLongTitle">Subscriptions <?php echo Html::encode($user->getNickname()); ?>:</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <ul class="list-group list-group-flush">
                    <?php foreach($subscriptions = $user->getSubscriptions() as $subscription): ?>
                        <li class="list-group-item"><?php echo Html::encode($subscription->getNickname()); ?></li>
                    <?php endforeach;?>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<?php foreach ($posts as $item): ?>

<div class="container-fluid main mb-md-4">
    <div class="mx-auto col-md-6 py-sm-2 row-content" post-id="<?php echo Html::encode($item->id); ?>">
        <div class="row border px-sm-1" style="background-color: #f2e1ff">
            <img src="<?php echo Html::encode($user->getProfileImg()); ?>" class="float-left p-sm-1" style="width: 50px; height: 50px">
            <div class="col my-auto pl-sm-2">
                <h5 class="my-auto font-weight-light"><a href="<?php echo Url::toRoute(['/user/profile/view', 'nickname' => $item->user->getNickname()]); ?>" class="text-capitalize m-0 text-danger" style="text-decoration: none;"><?php echo Html::encode($user->username); ?></a> <a href="<?php echo Url::toRoute(['/post/default/view', 'id' => $item->id]);?>" class="text-dark" style="text-decoration: none;">posted on <?php echo Html::encode($item['creation_time']); ?></a></h5>
            </div>
        </div>
        <div class="row border border-top-0">
            <div class="col-md-12 px-sm-2">
                <p class="h3 p-sm-2 font-weight-light"><?php echo Html::encode($item['title']); ?></p>
            </div>
            <div class="col-md-12 px-sm-2">
                <p class="p-sm-2 font-weight-light mb-sm-1 mt-sm-1"><?php echo Html::encode($item['content']); ?></p>
            </div>
            <div class="row mx-auto col-md-12 p-sm-1 border-top" style="border-color:#f2e1ff">
                <div class="col px-0">
                    <?php if($item->isLiked($currentUser->getId())): ?>
                        <button class="btn btn-success btn-unlike" data-id="<?php echo Html::encode($item['id']);?>"><i class="fas fa-heart">&nbsp;&nbsp;</i><?php echo Html::encode($item->countLikes());?></button>
                        <button style="display:none;" class="btn btn-danger btn-like" data-id="<?php echo Html::encode($item['id']);?>"><i class="fas fa-heart">&nbsp;&nbsp;</i><?php echo Html::encode($item->countLikes());?></button>
                    <?php else:?>
                        <button style="display:none;" class="btn btn-success btn-unlike" data-id="<?php echo Html::encode($item['id']);?>"><i class="fas fa-heart">&nbsp;&nbsp;</i><?php echo Html::encode($item->countLikes());?></button>
                        <button class="btn btn-danger btn-like" data-id="<?php echo Html::encode($item['id']);?>"><i class="fas fa-heart">&nbsp;&nbsp;</i><?php echo Html::encode($item->countLikes());?></button>
                    <?php endif;?>
                </div>
                <div class="col text-right px-0">
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-cog">&nbsp;</i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <?php if($currentUser->getId() == $user->getId()):?>
                            <a class="dropdown-item delete-post" href="#" post-id="<?php echo Html::encode($item->id); ?>">Delete post</a>
                            <?php else: ?>
                            <a class="dropdown-item" href="#">Report post</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php foreach ($comments = $item->comments as $comment): ?>
    <div class="row-comment" comment-id="<?php echo Html::encode($comment->id);?>" post-id="<?php echo Html::encode($item->id); ?>">
        <div class="mx-auto col-md-6 border row-comment-title">
            <div class="row" style="background-color: #f2e1ff">
                <div class="col-sm-11 px-sm-1">
                    <a href="<?php echo Url::toRoute(['profile/view', 'nickname' => $comment->user->getNickname()]); ?>"><img src="<?php echo Html::encode($comment->user->getProfileImg()); ?>" class="float-left p-sm-1 mr-sm-2" style="width: 30px; height: 30px"></a>
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

    <script type="text/template" class="template" post-id="<?php echo Html::encode($item->id); ?>">
    <div class="row-comment" comment-id="<%-rc.comment.id%>" post-id="<%-rc.comment.post_id%>">
        <div class="mx-auto col-md-6 border row-comment-title">
            <div class="row" style="background-color: #f2e1ff">
                <div class="col-sm-11 px-sm-1">
                    <a href="<?php echo Url::toRoute(['profile/view', 'nickname' => $currentUser->getNickname()]); ?>"><img src="<?php echo Html::encode($currentUser->getProfileImg()); ?>" class="float-left p-sm-1" style="width: 30px; height: 30px"></a>
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

    <div class="mx-auto col-md-6 mb-sm-2 border row-input-comment px-0" post-id="<?php echo Html::encode($item->id); ?>">
        <?php $form = ActiveForm::begin(['options' => ['class' => 'add-comment p-sm-2 my-auto row', 'post-id' => $item->id]]);?>
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
<?php endforeach; ?>

<?php
$js = <<<JS
    $('.main').on('click', '.delete-post', function(){
        var post_id = {
            'id' : $(this).attr('post-id'),
        };
        $.ajax({
            url:'/post/default/delete-post',
            type: 'POST',
            data: post_id,
            success: function(res) {
                $('.row-content[post-id='+post_id['id']+']').hide();
                $('.row-comment[post-id='+post_id['id']+']').hide();
                $('.row-input-comment[post-id='+post_id['id']+']').hide();
            },
        });
        return false;
});
JS;

$this->registerJs($js);
?>
