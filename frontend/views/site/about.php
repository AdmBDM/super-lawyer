<?php

/** @var yii\web\View $this */

use yii\helpers\Url;

$this->title = 'О нас';
$this->params['breadcrumbs'][] = $this->title;

//$this->registerMetaTag([
//    'name' => 'description',
//    'content' => 'Официальная информация о сервисе Super‑Lawyer и команде юристов.'
//]);
//Yii::$app->view->params['meta_description'] = 'Официальная информация о сервисе Super‑Lawyer и команде юристов.';
//Yii::$app->view->params['meta_image'] = Url::to('@web/images/about-og.jpg', true);

?>

<section class="about-page py-5">
	<div class="container">
		<h1 class="mb-4">О нас</h1>
		<p class="lead mb-3">
			Super-Lawyer — юридический онлайн-сервис нового поколения. Мы помогаем людям решать правовые задачи быстро и профессионально.
		</p>

		<p>
			Мы работаем с 2024 года, объединив экспертов в области трудового, семейного, финансового, уголовного и потребительского права.
			Онлайн‑консультации, представительство, разработка документов — всё это доступно в один клик.
		</p>

		<p>
			Наши юристы работают в крупнейших городах России. Команда расширяется — а качество консультаций остаётся эталонным.
		</p>
	</div>
</section>
