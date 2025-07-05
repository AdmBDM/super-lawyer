<?php

use common\models\City;
use common\models\PageBlock;
use common\models\Service;
use common\models\ServiceCity;
use yii\helpers\Html;
use yii\helpers\Markdown;
use yii\web\View;

/**
 * @var View        $this
 * @var City        $city
 * @var Service     $service
 * @var ServiceCity $serviceCity
 * @var PageBlock[] $blocks
 */

$cityName     = Html::encode($city->name);
$cityDative   = Html::encode($city->dative ?: $city->name);
$cityGenitive = Html::encode($city->genitive ?: $city->name);

$title     = $serviceCity->meta_title ?? $service->meta_title ?? "{$service->title} в {$cityName}";
$h1        = $serviceCity->h1 ?? $service->h1 ?? "{$service->title} в {$cityDative}";
$lead      = $serviceCity->lead ?? $service->lead ?? '';
$price     = $serviceCity->price_from ?? $service->price_from ?? null;
$bodyData  = $serviceCity->body ?: $service->body ?: [];
?>

<?php
$this->title = $title;
$this->registerMetaTag(['name' => 'description', 'content' => $serviceCity->meta_desc ?? $service->meta_desc ?? '']);
$this->registerMetaTag(['name' => 'keywords',    'content' => $serviceCity->meta_keywords ?? $service->meta_keywords ?? '']);
?>

<section class="py-5 bg-light">
    <div class="container">
        <h1 class="mb-3"><?= Html::encode($h1) ?></h1>

        <?php if ($lead): ?>
            <p class="lead"><?= Html::encode($lead) ?></p>
        <?php endif; ?>

        <?php if ($price): ?>
            <p class="text-success fw-semibold mb-4">от <?= Yii::$app->formatter->asCurrency($price, 'RUB') ?></p>
        <?php endif; ?>

        <?php if (!empty($bodyData['text'])): ?>
            <div class="mb-4"><?= Markdown::process($bodyData['text'], 'gfm') ?></div>
        <?php endif; ?>

        <?php if (!empty($bodyData['list'])): ?>
            <h5 class="mt-4">Что входит в услугу:</h5>
            <ul>
                <?php foreach (explode("\n", trim($bodyData['list'])) as $item): ?>
                    <li><?= Html::encode($item) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <?php if (!empty($bodyData['advantages'])): ?>
            <div class="mt-4">
                <h5>Почему выбирают нас:</h5>
                <p><?= Html::encode($bodyData['advantages']) ?></p>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php if (!empty($blocks)): ?>
    <section class="py-5 bg-white border-top">
        <div class="container">
            <h2 class="mb-4">Дополнительная информация</h2>

            <?php foreach ($blocks as $block): ?>
                <div class="mb-4">
                    <h5><?= Html::encode($block->title ?: strtoupper($block->type)) ?></h5>
                    <p><?= nl2br(Html::encode($block->content)) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
<?php endif; ?>
