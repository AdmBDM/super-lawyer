<?php
/** @var yii\web\View $this */
use yii\helpers\Url;

$this->title = 'О нас | Супер‑Юрист';
$this->params['breadcrumbs'][] = $this->title;

Yii::$app->view->params['meta_description'] = 'Проект «Супер Юрист» — Ваш надежный правовой помощник! Онлайн-консультации юристов по всем правовым вопросам.';
Yii::$app->view->params['meta_image'] = Url::to('@web/images/about-og.jpg', true);
?>

<section class="about-page py-5">
	<div class="container">
		<!-- Заголовок -->
		<div class="text-center mb-5 fade-in">
			<h1 class="fw-bold mb-3">Проект «Супер Юрист» — Ваш надежный правовой помощник!</h1>
			<p class="lead text-muted">
				Экспертная юридическая поддержка онлайн: консультации, разъяснения сложных ситуаций простым языком, помощь в оформлении документов и защите ваших прав.
			</p>
		</div>

		<!-- Преимущества -->
		<div class="mb-5 fade-in">
			<h2 class="h4 fw-semibold mb-4 text-center">Наши преимущества</h2>
			<div class="row g-4">
                <?php
                $advantages = [
                    ['Квалифицированные специалисты', 'Опытные юристы разных направлений, готовые прийти на помощь в любое время.'],
                    ['Доступность и удобство', 'Консультации онлайн, быстрая реакция на запросы, оптимальный формат общения.'],
                    ['Комплексная поддержка', 'От первичной консультации до полного сопровождения дела.'],
                    ['Индивидуальный подход', 'Учитываем особенности каждого случая и предлагаем оптимальные решения.'],
                ];
                foreach ($advantages as [$title, $text]): ?>
					<div class="col-md-6">
						<div class="d-flex align-items-start advantage-card p-3 h-100">
							<i class="bi bi-check-circle-fill text-success fs-3 me-3"></i>
							<div>
								<p class="fw-semibold mb-1"><?= $title ?></p>
								<p class="mb-0"><?= $text ?></p>
							</div>
						</div>
					</div>
                <?php endforeach; ?>
			</div>
		</div>

		<!-- Как проходит консультация -->
		<div class="mb-5 fade-in">
			<h2 class="h4 fw-semibold mb-4 text-center">Как проходит консультация с юристом</h2>
			<div class="card shadow-sm border-0 consultation-card">
				<div class="card-body">
					<ol class="ps-3 mb-0">
						<li class="mb-2">Позвоните нам или обратитесь любым удобным способом.</li>
						<li class="mb-2">Опытный юрист проконсультирует вас дистанционно, проанализирует ситуацию и предложит пути решения.</li>
						<li class="mb-0">Следуя нашим рекомендациям, вы успешно справитесь с ситуацией.</li>
					</ol>
				</div>
			</div>
		</div>

		<!-- CTA -->
		<div class="text-center mt-4 fade-in">
			<a href="<?= Url::to(['/site/index#services']) ?>" class="btn btn-warning btn-lg text-dark fw-semibold shadow">
				Получить консультацию онлайн
			</a>
		</div>
	</div>
</section>
