<?php
/** @var string $currentCity */
/** @var string $citySlug   */
/** @var array $services   */
/** @var array $cityOptions   */

use yii\helpers\Html;

$this->title = 'Юрист онлайн — ' . Html::encode($currentCity);
?>

<?= $this->render('partials/_hero', ['city' => $currentCity]) ?>
<?= $this->render('partials/_services', ['city' => $currentCity, 'slug' => $citySlug, 'services' => $services]) ?>
<?= $this->render('partials/_cities',  ['citySlug' => $citySlug, 'cityOptions' => $cityOptions]) ?>
<?= $this->render('partials/_trust') ?>
