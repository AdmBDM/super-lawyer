<?php

use common\models\City;
use common\models\Faq;
use common\models\PageBlock;
use common\models\Service;
use common\models\ServiceCity;
use yii\helpers\Html;
use yii\helpers\Markdown;
use yii\helpers\Url;

/** @var yii\web\View	$this */
/** @var City       	$city */
/** @var Service    	$service */
/** @var ServiceCity 	$serviceCity */
/** @var PageBlock[] 	$blocks */
/** @var Faq 			$faq */

$cityDative   = Html::encode($city->dative   ?: $city->name);
$cityGenitive = Html::encode($city->genitive ?: $city->name);

$title   = $serviceCity->meta_title ?? $service->meta_title ?? "{$service->title} в {$cityGenitive}";
$h1      = $serviceCity->h1         ?? $service->h1         ?? "{$service->title} в {$cityDative}";
$lead    = $serviceCity->lead       ?? $service->lead       ?? '';
$price   = $serviceCity->price_from ?? $service->price_from ?? null;
$body    = $serviceCity->body       ?: $service->body       ?: [];

$this->title = $title;
$metaDesc = $serviceCity->meta_desc ??
	$service->meta_desc ??
    "Юридическая помощь по {$service->title} в {$city->name}. Онлайн‑консультации, представительство, подготовка документов.";
$this->registerMetaTag(['name' => 'description','content' =>  $metaDesc]);
$this->registerMetaTag(['name' => 'robots', 'content' => 'index,follow']);
?>

<!-- HERO -->
<section class="service-hero py-3 text-white">
	<div class="container text-center">
		<h1 class="display-5 fw-bold mb-3"><?= Html::encode($h1) ?></h1>
        <?php if ($lead): ?>
			<p class="lead lh-base"><?= Html::encode($lead) ?></p>
        <?php endif; ?>
<!--		<a href="#consult" class="btn btn-warning btn-lg text-dark fw-semibold mt-3">-->
<!--			Получить консультацию-->
<!--		</a>-->
		<div class="d-flex flex-column flex-md-row gap-3 justify-content-center mt-4">
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

<!-- MAIN CONTENT -->
<section class="service-body py-5">
	<div class="container">

		<!-- ОПИСАНИЕ -->
        <?php if (!empty($body['text'])): ?>
			<div class="mb-4"><?= Markdown::process($body['text'], 'gfm') ?></div>
        <?php endif; ?>

		<!-- СПИСОК УСЛУГ -->
        <?php if (!empty($body['list'])): ?>
			<h2 class="h5 mb-3">Что входит в услугу</h2>
			<ul class="service-list">
                <?php foreach (explode("\n", trim($body['list'])) as $item): ?>
					<li><?= Html::encode($item) ?></li>
                <?php endforeach; ?>
			</ul>
        <?php endif; ?>

		<!-- ПРЕИМУЩЕСТВА -->
        <?php if (!empty($body['advantages'])): ?>
			<div class="mt-5 p-4 advantages-box">
				<h2 class="h5 mb-3">Преимущества работы с нами</h2>
				<ul class="list-unstyled ps-3">
                    <?php foreach (preg_split('/\r\n|\r|\n/', $body['advantages']) as $adv): ?>
                        <?php if (trim($adv)): ?>
							<li>• <?= Html::encode(trim($adv)) ?></li>
                        <?php endif; ?>
                    <?php endforeach; ?>
				</ul>
			</div>
        <?php endif; ?>

		<!-- ЦЕНА -->
        <?php if ($price): ?>
			<p class="price-label text-success fw-semibold fs-4 mb-4">
				Стоимость услуги: от <?= Yii::$app->formatter->asCurrency($price, 'RUB') ?>
			</p>
        <?php else: ?>
			<p class="price-label text-success fw-semibold fs-4 mb-4">
				Стоимость услуги: по договорённости.
			</p>
        <?php endif; ?>

	</div>
</section>

<!-- БЛОКИ FAQ / кейсы -->
<?php if ($blocks): ?>
	<section class="service-blocks py-5 bg-light border-top">
		<div class="container">
            <?php foreach ($blocks as $block): ?>
				<div class="mb-4">
					<h3 class="h6 fw-bold"><?= Html::encode($block->title ?: strtoupper($block->type)) ?></h3>
					<div><?= nl2br(Html::encode($block->content)) ?></div>
				</div>
            <?php endforeach; ?>
		</div>
	</section>
<?php endif; ?>

<!-- FAQ -->
<?= $this->render('partials/_faq', [
    'faq' => $faq,
]) ?>

<!-- Block for SEO -->
<?php if (!empty($faq)): ?>
    <?php
    $faqJson = [
        '@context' => 'https://schema.org',
        '@type' => 'FAQPage',
        'mainEntity' => [],
    ];

    foreach ($faq as $item) {
        $faqJson['mainEntity'][] = [
            '@type' => 'Question',
            'name' => strip_tags($item->question),
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text' => strip_tags(nl2br($item->answer)),
            ]
        ];
    }
    ?>
	<script type="application/ld+json">
<?= json_encode($faqJson, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) ?>
</script>
<?php endif; ?>

<!-- CTA -->
<?= $this->render('partials/_cta', [
    'city' => $city,
    'context' => 'service',
]) ?>
