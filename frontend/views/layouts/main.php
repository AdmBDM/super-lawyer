<?php
/**
 * @var yii\web\View $this
 * @var string       $content
 */

use frontend\assets\AppAsset;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/** @var common\models\City        $currentCity  (из beforeAction) */
/** @var common\models\City[]|null $cityList     (из beforeAction) */

AppAsset::register($this);

/* — данные для селектора — */
$currentCity = Yii::$app->view->params['currentCity'] ?? null;
$cityList    = Yii::$app->view->params['cityList']   ?? [];

/* если почему‑то пусто — подстраховка */
if (!$currentCity) {
    $currentCity = reset($cityList);           // первый активный город
}
$citySlug = $currentCity?->slug ?? 'msk';

$this->title = Yii::$app->params['name'];
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->params['language'] ?>">
<head>
	<meta charset="<?= Yii::$app->charset ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
	<title><?= Html::encode($this->title) ?></title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<!-- ===== Header & Navbar ===== -->
<header>
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->params['name'],
        'brandUrl'   => Yii::$app->homeUrl,
        'options'    => ['class' => 'navbar navbar-expand-lg navbar-dark bg-dark fixed-top'],
    ]);

    /* — селектор города — */
    echo Html::beginTag('div', ['class' => 'navbar-city-selector mx-3']);
    echo '<div class="input-group input-group-sm">';
    echo '<span class="input-group-text bg-light text-dark"><i class="bi bi-geo-alt-fill"></i></span>';
    echo Html::dropDownList(
        'city',
        $citySlug,
        ArrayHelper::map($cityList, 'slug', 'name'),
        ['class' => 'form-select', 'id' => 'citySelectNav']
    );
    echo '</div>';
    echo Html::endTag('div');

    /* — пункты меню — */
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav ms-auto align-items-lg-center'],
        'items'   => [
            ['label' => 'Услуги',   'url' => ['/site/index#services']],
            ['label' => 'Города',   'url' => ['/site/index#cities']],
            ['label' => 'О нас',    'url' => ['/site/about']],
            ['label' => 'Контакты', 'url' => ['/site/contact']],
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

<!-- ===== Хлебные крошки ===== -->
<?php if (!empty($this->params['breadcrumbs'])): ?>
	<div class="container mt-3">

        <?= \yii\widgets\Breadcrumbs::widget([
            'links'    => $this->params['breadcrumbs'],
            'options'  => ['class' => 'breadcrumb small'],
        ]) ?>

        <?php
        /* JSON‑LD для поисковиков */
        $items = [];
        foreach ($this->params['breadcrumbs'] as $pos => $crumb) {
            $items[] = [
                '@type'    => 'ListItem',
                'position' => $pos + 1,
                'name'     => $crumb['label'],
                'item'     => Url::to($crumb['url'] ?? Yii::$app->request->url, true),
            ];
        }
        $json = [
            '@context'        => 'https://schema.org',
            '@type'           => 'BreadcrumbList',
            'itemListElement' => $items,
        ];
        $this->registerJs(
            "window.__breadcrumbLD = " . json_encode($json, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
            \yii\web\View::POS_BEGIN
        );
        ?>
	</div>
<?php endif; ?>

<!-- ===== Main content ===== -->
<main class="mt-5 pt-4">
    <?= $content ?>
</main>

<!-- ===== Footer ===== -->
<footer class="footer-section py-4 bg-dark text-white mt-5">
	<div class="container text-center small">
		<p class="mb-1">&copy; <?= date('Y') ?> Super‑Lawyer. Все права защищены.</p>
		<p class="mb-0">ООО «Супер‑Юрист» · info@super-lawyer.ru</p>
	</div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
