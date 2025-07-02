<?php
use yii\helpers\Html;
use yii\web\JqueryAsset;

/** @var yii\web\View $this */
$this->title = 'Юридическая онлайн-помощь в вашем городе';
$this->registerCssFile('@web/dist/css/main.min.css');
$this->registerJsFile('@web/dist/js/main.min.js', ['depends' => [JqueryAsset::class]]);

?>

<?= $this->render('partials/_hero') ?>
<?= $this->render('partials/_services') ?>
<?= $this->render('partials/_cities') ?>
<?= $this->render('partials/_trust') ?>
<?= $this->render('partials/_footer') ?>
