<?php
/* @var $this yii\web\View */
/* @var $currentUser frontend\models\User */
/* @var $model frontend\modules\post\models\forms\PostForm*/
/* @var $user frontend\models\User*/

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$this->title = Html::encode('New Post');
?>
<div class="row" id="row-new-post">
    <div class="success"></div>
    <div class="mx-auto col-md-6">
        <div class="p-4 border border-dark">
            <?php
            $form = ActiveForm::begin([
                'id' => 'form-new-post',
            ]);
            ?>
                <?php echo $form->field($model, 'title', ['template' => "{label}{input}"])->textInput(['placeholder' => 'Enter title your post', 'class'=>'form-control']); ?>
                <?php echo $form->field($model, 'content', ['template' => "{label}{input}"])->textarea(['placeholder' => 'Enter text your post', 'class'=>'form-control']); ?>
                <?php echo Html::input('submit',null,'Add new post', ['class' => 'btn btn-primary mt-sm-2']); ?>

            <?php
            $form = ActiveForm::end();
            ?>
        </div>
    </div>
</div>


<?php
$js = <<<JS
     $('#form-new-post').on('beforeSubmit', function(){
	 var data = $(this).serialize();
	 $.ajax({
	    url: '/post/default/new-post',
	    type: 'POST',
	    data: data,
	    success: function(res){
	        $('<div>', {class:'alert-success'}).prependTo('#row-new-post').append('<p>Post has been created</p>');
	        $('#postform-title').val('');
	        $('#postform-content').val('');
	    },
	 });
	 return false;
     });
JS;

$this->registerJs($js);
?>
