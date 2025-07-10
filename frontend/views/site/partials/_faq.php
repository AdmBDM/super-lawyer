<?php

use common\models\Faq;
use yii\helpers\Html;

/** @var Faq[] $faq */
?>

<?php if (!empty($faq)): ?>
	<section class="faq-section py-5 border-top bg-white">
		<div class="container">
			<h2 class="mb-4 text-center">Вопросы и ответы</h2>
			<div class="accordion" id="faqAccordion">
                <?php foreach ($faq as $i => $item): ?>
					<div class="accordion-item">
						<h2 class="accordion-header" id="heading<?= $i ?>">
							<button class="accordion-button <?= $i !== 0 ? 'collapsed' : '' ?>" type="button"
									data-bs-toggle="collapse"
									data-bs-target="#collapse<?= $i ?>"
									aria-expanded="<?= $i === 0 ? 'true' : 'false' ?>"
									aria-controls="collapse<?= $i ?>">
								<strong>Вопрос:</strong> <?= Html::encode($item->question) ?>
							</button>
						</h2>
						<div id="collapse<?= $i ?>" class="accordion-collapse collapse <?= $i === 0 ? 'show' : '' ?>"
							 aria-labelledby="heading<?= $i ?>" data-bs-parent="#faqAccordion">
							<div class="accordion-body">
								<p><strong>Ответ:</strong></p>
								<p><?= nl2br(Html::encode($item->answer)) ?></p>
							</div>
						</div>
					</div>
                <?php endforeach; ?>
			</div>
		</div>
	</section>
<?php endif; ?>
