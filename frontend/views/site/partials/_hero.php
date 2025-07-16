<?php

use common\models\City;
use yii\helpers\Html;

/** @var City $currentCity */
?>
<section class="hero-section py-5 text-center text-white bg-primary">
	<div class="container">
		<h1 class="display-4 mb-3">
			Юрист онлайн в <?= ($currentCity->dative ?? $currentCity->name); ?>
		</h1>
		<p class="lead mb-4">
			Срочная помощь по всем видам права — круглосуточно, без визита в офис
		</p>
<!--		<a href="#services" class="btn btn-warning btn-lg">-->
<!--			Получить консультацию-->
<!--		</a>-->
		<div class="d-flex flex-column flex-md-row gap-3 mt-4">
			<!-- Кнопка звонка -->
			<a href="tel:+78005553535" class="btn btn-warning btn-lg text-dark fw-semibold shadow">
				<i class="bi bi-telephone-fill me-2"></i> Получить консультацию
			</a>

			<!-- Кнопка ВКонтакте -->
			<a href="https://vk.com/club231557224" target="_blank" rel="noopener"
			   class="btn btn-vk btn-lg fw-semibold">
				<i class="bi bi-vk me-2"></i> Мы ВКонтакте
			</a>
		</div>
	</div>
</section>
