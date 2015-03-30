<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Video */

$this->title = $oVideo->title;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="video">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        Автор: <?= $oVideo->user->FIO;?>
    </p>

    <div class="v">
        <video controls width="500">
            <source src="<?= Yii::$app->getUrlManager()->baseUrl;?>/uploads/<?= $oVideo->file_name;?>" type="video/mp4">
        </video>
    </div>

    <div class="d">
        <?= $oVideo->description;?>
    </div>

</div>
