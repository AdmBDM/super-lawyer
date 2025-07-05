<?php

use common\models\City;
use yii\helpers\Html;

/** @var City $currentCity */
/** @var array  $services */
/** @var string $slug */

?>
<section id="services" class="services-section py-5">
	<div class="container">
		<h2 class="mb-4 text-center">
			Наши юридические услуги в <?= $currentCity->dative ?>
		</h2>

		<div class="row gy-4">
            <?php foreach ($services as $sSlug => [$title, $desc]): ?>
				<div class="col-12 col-md-6 col-lg-4">
					<div class="card h-100 shadow-sm">
						<div class="card-body d-flex flex-column">
							<h5 class="card-title"><?= Html::encode($title) ?></h5>
							<p class="card-text flex-grow-1"><?= Html::encode($desc) ?></p>
							<a href="/<?= Html::encode($slug) ?>/<?= Html::encode($sSlug) ?>"
							   class="btn btn-outline-primary mt-2 w-100">
								Подробнее
							</a>
						</div>
					</div>
				</div>
            <?php endforeach; ?>
		</div>
	</div>
</section>
