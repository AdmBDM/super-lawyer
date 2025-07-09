<?php
use yii\helpers\Html;
use yii\helpers\Url;
use common\models\City;

/** @var City[] $cities */
?>

<section id="cities" class="py-5 bg-white border-top">
	<div class="container">
		<h2 class="mb-4 text-center">Города, где мы работаем</h2>

		<div class="row g-4 justify-content-center">

            <?php foreach ($cities as $i => $city): ?>
                <?php
                // первые 8 показываем сразу; остальные в collapse
                $inCollapse = $i >= 8;
                $wrapClass  = $inCollapse ? 'collapse multi-collapse show-more-city' : '';
                ?>
				<div class="col-6 col-md-4 col-lg-3 <?= $wrapClass ?>">
					<div class="city-card p-3 text-center shadow-sm rounded bg-light h-100">
						<div class="card h-100 shadow-sm border-0">
							<div class="card-body d-flex flex-column">
                                <?php $coat = $city->coatUrl; // null или URL png ?>

								<div class="d-flex align-items-center gap-3 mb-3">
                                    <?php if ($coat): ?>
										<img src="<?= Html::encode($coat) ?>" alt="<?= Html::encode($city->name) ?>"
											 class="city-coat">
                                    <?php else: ?>
										<span class="icon-wrapper text-primary fs-3">
											<i class="bi bi-geo-alt-fill"></i>
										</span>
                                    <?php endif; ?>
									<h5 class="card-title mb-0"><?= Html::encode($city->name) ?></h5>
								</div>

								<div class="mt-auto">
									<a href="<?= Url::to("/{$city->slug}") ?>"
									   class="btn btn-outline-primary btn-sm w-100">
										Перейти
									</a>
								</div>

							</div>
						</div>

					</div>
				</div>
            <?php endforeach; ?>

		</div>

        <?php if (count($cities) > 8): ?>
			<div class="text-center mt-4">
				<button class="btn btn-outline-secondary"
						data-bs-toggle="collapse"
						data-bs-target=".show-more-city"
						aria-expanded="false"
						id="toggleCitiesBtn">
					Показать все города
				</button>
			</div>
        <?php endif; ?>
	</div>
</section>
