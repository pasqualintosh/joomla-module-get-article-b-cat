<?php
// No direct access
defined('_JEXEC') or die; ?>
<div id="rssReader" class="row">

	<div class="custom_practicetitle" style="text-align:center">
		<h3><?php echo $buffer['introduction_text']?></h3>
	</div>

	<?php if($buffer['articles'] != NULL || $buffer['articles'] != '' ) { ?>

	<div class="article-result">
		<ul class="article-list">

			<?php foreach ($buffer['articles'] as $article) {?>
				<?php $images  = json_decode($article->images); ?>
				<div class="article col-lg-4 col-md-6 col-sm-6 col-xs-12">
					<a class="" href="index.php/component/content/article?id=<?php echo $article->id?>">
						<?php echo $article->title?>
					</a>
					<br>
					<div style="
						width:300px;
						height:200px;
						background-image: url(<?php if($images->image_intro != NULL) echo $images->image_intro; ?>);
						background-position: center;">

					</div>

					<p>
						<?php echo substr($article->introtext,0 , 300) . '...' ; ?>
						<a class="" rel="nofollow" href="index.php/component/content/article?id=<?php echo $article->id?>">
							Continua
						</a>
					</p>
				</div>
			<?php }?>

		</ul>
	</div>

	<?php } ?>

</div>
