<?php
/** @var string $currentCity */
/** @var string $citySlug   */

use yii\helpers\Html;

$this->title = 'Юрист онлайн — ' . Html::encode($currentCity);
?>

<?= $this->render('partials/_hero', ['city' => $currentCity]) ?>
<?= $this->render('partials/_services', ['city' => $currentCity, 'slug'=>$citySlug]) ?>
<?= $this->render('partials/_cities',  ['city' => $currentCity]) ?>
<?= $this->render('partials/_trust') ?>
