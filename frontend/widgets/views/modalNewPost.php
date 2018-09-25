<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use frontend\assets\AppAsset;
use frontend\assets\BowerAsset;

AppAsset::register($this);
BowerAsset::register($this);
?>

<button id="myBtn" class="myBtn">New Post</button>

<div id="myModal" class="modal">
    <!-- Modal content -->
    <?php
    $form = ActiveForm::begin([]);
    ?>
    <div class="modal-content animated fadeInDown">
        <div class="modal-header">
            <span class="close">&times;</span>
            <?php echo $form->field($model, 'title'); ?>
        </div>
        <div class="modal-body">
            <?php echo $form->field($model, 'content')->textarea(); ?>
        </div>
        <div class="modal-footer">
            <?php echo Html::input('submit',null,'Add new post', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
    <?php $form = ActiveForm::end(); ?>
</div>';

<?php
$js = <<<JS
     $('form').on('beforeSubmit', function(){
	 var data = $(this).serialize();
	 $.ajax({
	    url: '/post/default/new-post',
	    type: 'POST',
	    data: data,
	    success: function(res){
	       console.log(res);
	    },
	    error: function(){
	       alert('Error!');
	    }
	 });
	 return false;
     });
JS;

$this->registerJs($js);
?>