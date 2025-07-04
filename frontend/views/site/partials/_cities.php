<?php
use yii\helpers\Html;

/** @var array $cityOptions */
/** @var string $citySlug */

?>
<section id="cities" class="cities-grid py-5 bg-light">
	<div class="container">
		<h2 class="mb-4 text-center">Юридическая помощь в других городах</h2>
		<div class="row gy-3 justify-content-center text-center">
            <?php foreach ($cityOptions as $slug => $name): ?>
                <?php if ($slug === $citySlug) continue; // исключаем текущий город ?>
				<div class="col-6 col-sm-4 col-md-3">
					<a href="/<?= Html::encode($slug) ?>"
					   class="btn btn-outline-secondary w-100">
                        <?= Html::encode($name) ?>
					</a>
				</div>
            <?php endforeach; ?>
		</div>
	</div>
</section>
