<?php
use common\models\City;
use yii\helpers\Html;

/** @var City $currentCity */
/** @var City[] $cities */
/** @var string $citySlug   */
/** @var array $services   */
/** @var array $cityOptions   */

$this->title = 'Юрист онлайн — ' . Html::encode($currentCity->name);
?>

<?= $this->render('partials/_hero', ['currentCity' => $currentCity]) ?>
<?= $this->render('partials/_services', ['currentCity' => $currentCity, 'slug' => $citySlug, 'services' => $services]) ?>
<?= $this->render('partials/_cities',  ['citySlug' => $citySlug, 'cityOptions' => $cityOptions, 'cities' => $cities]) ?>
<?= $this->render('partials/_trust') ?>
