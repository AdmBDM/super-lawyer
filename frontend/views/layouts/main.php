<?php
/**
 * @var yii\web\View $this
 * @var string       $content
 */

use frontend\assets\AppAsset;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);

// текущий город (по cookie или значению по умолчанию)
$city = Yii::$app->request->cookies->getValue('city', 'Москва');
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
	<meta charset="<?= Yii::$app->charset ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
	<title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<!-- ===== Header & Navbar ===== -->
<header>
    <?php
    NavBar::begin([
        'brandLabel' => 'Super‑Lawyer',
        'brandUrl'   => Yii::$app->homeUrl,
        'options'    => ['class' => 'navbar navbar-expand-lg navbar-dark bg-dark fixed-top'],
    ]);

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav ms-auto align-items-lg-center'],
        'items'   => [
            ['label' => 'Услуги',   'url' => ['/site/index#services']],
            ['label' => 'Города',   'url' => ['/site/index#cities']],
            ['label' => 'О нас',    'url' => ['/site/about']],
            ['label' => 'Контакты', 'url' => ['/site/contact']],
            '<li class="nav-item d-none d-lg-block">'
            .Html::dropDownList(
                'city',
                $city,
                ['Москва' => 'Москва', 'Санкт‑Петербург' => 'Санкт‑Петербург', 'Екатеринбург' => 'Екатеринбург', 'Казань' => 'Казань'],
                ['class' => 'form-select form-select-sm', 'id' => 'citySelectNav']
            )
            .'</li>',
            [
                'label'       => 'Онлайн‑консультация',
                'url'         => ['/site/index#hero'],
                'linkOptions' => ['class' => 'btn btn-warning ms-lg-3 text-dark fw-semibold']
            ],
        ],
    ]);
    NavBar::end();
    ?>
</header>

<!-- ===== Main content (partials come here) ===== -->
<main class="mt-5 pt-4">
    <?= $content ?>
</main>

<!-- ===== Footer ===== -->
<footer class="footer-section py-4 bg-dark text-white mt-5">
	<div class="container text-center small">
		<p class="mb-1">&copy; <?= date('Y') ?> Super‑Lawyer. Все права защищены.</p>
		<p class="mb-0">ООО «Супер-Юрист» · info@super-lawyer.ru</p>
	</div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
