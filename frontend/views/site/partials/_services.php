<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\StringHelper;
use common\models\City;

/**
 * @var City   $currentCity
 * @var string $slug
 * @var array  $services
 */

$cityDative = Html::encode($currentCity->dative ?: $currentCity->name);
?>

<section class="py-5 bg-light" id="services">
	<div class="container">
		<h2 class="mb-4 text-center">Юридические услуги в <?= $cityDative ?></h2>

		<div class="row g-4">

            <?php foreach ($services as $i => $srv): ?>
                <?php
                // первые 6 карточек отображаем сразу, остальные помещаем в collapse
                $inCollapse = $i >= 6;
                $wrapperClasses = $inCollapse ? 'collapse multi-collapse show-more-target' : '';
                ?>

				<div class="col-12 col-md-6 col-lg-4 <?= $wrapperClasses ?>">
					<div class="card h-100 shadow-sm border-0">
						<div class="card-body d-flex flex-column">
							<div class="d-flex align-items-center gap-3 mb-3">
                                <?php if (!empty($srv['icon'])): ?>
									<span class="icon-wrapper text-primary fs-3" aria-label="<?= Html::encode($srv['title']) ?>">
                    <i class="<?= Html::encode($srv['icon']) ?>" aria-hidden="true"></i>
                  </span>
                                <?php endif; ?>
								<h5 class="card-title mb-0"><?= Html::encode($srv['title']) ?></h5>
							</div>

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

        <?php if (count($services) > 6): ?>
			<div class="text-center mt-4">
				<button class="btn btn-outline-secondary" type="button"
						data-bs-toggle="collapse"
						data-bs-target=".show-more-target"
						aria-expanded="false"
						aria-controls="servicesMore"
						id="toggleServicesBtn">
					Показать все услуги
				</button>
			</div>
        <?php endif; ?>
	</div>
</section>
