<?php
use yii\helpers\Html;
/** @var string $city */
?>
<section class="hero-section py-5 text-center text-white bg-primary">
	<div class="container">
		<h1 class="display-4 mb-3">
			Юрист онлайн в г.<?= Html::encode($city) ?>
		</h1>
		<p class="lead mb-4">
			Срочная помощь по всем видам права — круглосуточно, без визита в офис
		</p>
		<a href="#services" class="btn btn-warning btn-lg">
			Получить консультацию
		</a>
	</div>
</section>
