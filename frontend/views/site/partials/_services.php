<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\StringHelper;
use common\models\City;

/**
 * @var City  $currentCity
 * @var string $slug        // slug текущего города
 * @var array $services     // массив услуг (asArray)
 */

$cityDative = Html::encode($currentCity->dative ?: $currentCity->name);
?>

<section class="py-5 bg-light" id="services">
	<div class="container">
		<h2 class="mb-4 text-center">Юридические услуги в <?= $cityDative ?></h2>

		<div class="row g-4">
            <?php foreach ($services as $srv): ?>
				<div class="col-12 col-md-6 col-lg-4">
					<div class="card h-100 shadow-sm border-0">
						<div class="card-body d-flex flex-column">
                            <?php if (!empty($srv['icon'])): ?>
								<div class="mb-3 text-primary fs-1">
									<i class="<?= Html::encode($srv['icon']) ?>"></i>
								</div>
                            <?php endif; ?>

							<h5 class="card-title"><?= Html::encode($srv['title']) ?></h5>

                            <?php if (!empty($srv['lead'])): ?>
								<p class="card-text text-muted">
                                    <?= Html::encode(StringHelper::truncate($srv['lead'], 100)) ?>
								</p>
                            <?php endif; ?>

                            <?php if (!empty($srv['price_from'])): ?>
								<p class="text-success fw-semibold mb-2">
									от <?= Yii::$app->formatter->asCurrency($srv['price_from'], 'RUB') ?>
								</p>
                            <?php endif; ?>

							<div class="mt-auto">
								<a href="<?= Url::to("/{$slug}/{$srv['slug']}") ?>" class="btn btn-outline-primary w-100">
									Подробнее
								</a>
							</div>
						</div>
					</div>
				</div>
            <?php endforeach; ?>
		</div>
	</div>
</section>
