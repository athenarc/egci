<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\components\MagicSearchBox;
use kartik\date\DatePicker;
use app\components\Headers;

$this->title = "Edit cold storage project";

/* @var $this yii\web\View */
/* @var $model app\models\ServiceRequest */
/* @var $form ActiveForm */
echo Html::CssFile('@web/css/project/project-request.css');
$this->registerJsFile('@web/js/project/project-request.js', ['depends' => [\yii\web\JqueryAsset::className()]]);


$participating_label="Participating users  <i class='fas fa-question-circle' title='Type 3 or more characters of the desired ELIXIR-AAI username to get suggestions'></i>";
$storage_label="Maximum allowed storage (in GBs) * <span class='limits-label'> [upper limits: $autoacceptlimits->storage (automatically accepted), $upperlimits->storage (with RAC review)] </span>";

if (!empty($errors))
{
    echo '<div class="alert alert-danger row" role="alert">';
    echo $errors;
    echo '</div>';

}

Headers::begin() ?>
<?php echo Headers::widget(
['title'=>'Edit cold storage project',])
?>
<?Headers::end()?>




<div class="cold">

<div class="row"><div class="col-md-12">* All fields marked with asterisk are mandatory</div></div>
    <?php $form = ActiveForm::begin($form_params); ?>
    <?= $form->errorSummary($project) ?>
    <?= $form->errorSummary($details) ?>
        <div class="row box">
            <div class="col-md-12">
                <h3>Project details</h3>
           
        <?= $form->field($project, 'name') ?>
        <?= $form->field($project, 'user_num') ?>
        <?= $form->field($project, 'end_date')->textInput(['disabled'=>true]) ?>
        <?= Html::label($participating_label, 'user_search_box', ['class'=>'blue-label']) ?>
        <br/>
        <?= MagicSearchBox::widget(
            ['min_char_to_start' => 3, 
             'expansion' => 'both', 
             'suggestions_num' => 5, 
             'html_params' => [ 'id' => 'user_search_box', 
             'name'=>'participants', 
             'class'=>'form-control blue-rounded-textbox'],
             'ajax_action' => Url::toRoute('project/auto-complete-names'),
             'participating' => $participating,
            ]);
        ?>
        <br />

        
        <?= $form->field($details, 'description')->textarea(['rows'=>6]) ?>
         </div>
    </div>
        <div class="row">
            <div class="col-md-12">
                <h3>Requested resources</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h5>(Note that prototype resource limits are not indicative of the limits to be applied to the final, production-ready <?=$name=Yii::$app->params['name']?>.)</h5>
            </div>
        </div>
        <div class="row">&nbsp;</div>


        
        <?= $form->field($details, 'storage')-> label($storage_label) ?>

        <?php
        if($role=='gold')
        {?>
            <input type="checkbox" id="additional" name="additional">
            <label for="additional"> I need more resources than the maximum provided. </label><br>
            <div id='textarea' style="display: none;">
            <div class="row">&nbsp;</div>
            <?= $form->field($details, 'additional_resources')->textArea(['column'=>6,])-> label('Describe your requirements and the reason you need them.') ?>
            </div>
        <?php
        }?>
        
        
    
        <div class="form-group">
            <?= Html::submitButton('<i class="fas fa-check"></i> Submit', ['class' => 'btn btn-primary']) ?>
            <?= Html::a('<i class="fas fa-times"></i> Cancel', ['/project/index'], ['class'=>'btn btn-default']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- new_ondemand_project -->
