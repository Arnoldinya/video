<?php
/* @var $this yii\web\View */
use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'My Yii Application';
?>
<h2>Видео</h2>
<p>
    <?= Html::a('Последние видео', ['index'], ['class' => 'btn btn-primary']) ?>
    <?= Html::a('Избранные видео', ['index', 'fav' => 'true'], ['class' => 'btn btn-primary']) ?>
    <?= Html::a('Мои видео', ['index', 'my' => 'true'], ['class' => 'btn btn-primary']) ?>
</p>

<?php foreach ($aVideo as $oVideo): ?>
	<div class="video">
		<p><?= $oVideo->title;?></p>
		<div><?= $oVideo->user->FIO; ?></div>
		<div class="fav">
		<?php if (!$oVideo->isFav()): ?>			
			<div class="btn btn-success add_fav" data-id="<?= $oVideo->id; ?>">
				Добавить в избранное
			</div>			
		<?php else:?>
			<div class="btn btn-success">
				В избранном
			</div>	
		<?php endif ?>
		</div>
		<div class="v" data-id="<?= $oVideo->id; ?>">
			<video width="500">
				<source src="<?= Yii::$app->getUrlManager()->baseUrl;?>/uploads/<?= $oVideo->file_name;?>" type="video/mp4">
			</video>
		</div>
		<div class="d">
			<?= $oVideo->description; ?>
		</div>			
	</div>
<?php endforeach ?>

<script type="text/javascript">
	$('.v').click(function(){
		id = $(this).attr('data-id');
		document.location.href = "<?= Url::toRoute(['/video/view', 'id' => '']);?>" + id;
	});

	$('.add_fav').click(function(){
		id = $(this).attr('data-id');
		$fav = $(this).parent('div.fav');
		$.post("<?= Url::toRoute(['/site/ajaxaddtofav'])?>", {'id': id}, function(data){			
			if(data)
			{
				//$(this).empty();
				$fav.html('<div class="btn btn-success">В избранном</div>');
			}
		});
	});
</script>