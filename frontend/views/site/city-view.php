<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\StringHelper;

/** @var \common\models\City     $city */
/** @var \common\models\Service[] $services */
/** @var int[] $activeIds */

$this->title = "Юридические услуги в {$city->name}";
?>

<section class="py-5">
    <div class="container">
        <h1 class="mb-4">Услуги в <?= Html::encode($city->dative ?: $city->name) ?></h1>

        <div class="row g-4">
            <?php foreach ($services as $srv): ?>
                <?php
                $enabled = in_array($srv->id, $activeIds);
                $cardClass = $enabled ? '' : 'disabled-card';
                ?>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm border-0 <?= $cardClass ?>">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex align-items-center gap-3 mb-3">
                <span class="icon-wrapper text-primary fs-3" aria-hidden="true">
                  <i class="<?= Html::encode($srv->icon ?: 'bi bi-journal') ?>"></i>
                </span>
                                <h5 class="card-title mb-0"><?= Html::encode($srv->title) ?></h5>
                            </div>

                            <?php if ($srv->lead): ?>
                                <p class="card-text text-muted">
                                    <?= Html::encode(StringHelper::truncate($srv->lead, 100)) ?>
                                </p>
                            <?php endif; ?>

                            <div class="mt-auto">
                                <?php if ($enabled): ?>
                                    <a href="<?= Url::to("/{$city->slug}/{$srv->slug}") ?>"
                                       class="btn btn-outline-primary w-100">
                                        Подробнее
                                    </a>
                                <?php else: ?>
                                    <button class="btn btn-outline-secondary w-100" disabled>
                                        Недоступно
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
