<?php
    use yii\helpers\Html;
    use yii\helpers\Url;
?>
<h1>Личный кабинет</h1>

<p>
    <?= Html::a('Редактирвоать профиль', ['update'], ['class' => 'btn btn-primary']) ?>
    <?= Html::a('Загрузить видео', ['video'], ['class' => 'btn btn-primary']) ?>
</p>

<?php foreach ($oUser->attributeLabels() as $sAttribute=>$sTitle): ?>
    <div>
        <?php if ($sAttribute=='passRepeat') continue;?>
        <span style="font-weight: bold;"><?= $sTitle; ?>: </span> <?= $oUser->$sAttribute; ?>
    </div>    
<?php endforeach ?>

<?php if ($oUser->videos): ?>
	<h2>Видео</h2>
	<?php foreach ($oUser->videos as $oVideo): ?>
		<div class="video">
			<p><?= $oVideo->title;?></p>
			<div class="v" data-id="<?= $oVideo->id?>">
				<video width="200">
					<source src="<?= Yii::$app->getUrlManager()->baseUrl;?>/uploads/<?= $oVideo->file_name;?>" type="video/mp4">
				</video>
			</div>
			<div class="d">
				<?= $oVideo->description; ?>
			</div>			
		</div>
	<?php endforeach ?>
<?php endif ?>

<script type="text/javascript">
	$('.v').click(function(){
		id = $(this).attr('data-id');
		document.location.href = "<?= Url::toRoute(['/video/view', 'id' => '']);?>" + id;
	});
</script>