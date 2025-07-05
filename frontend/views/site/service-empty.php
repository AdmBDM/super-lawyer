<?php

use common\models\City;
use common\models\Service;
use yii\helpers\Html;

/** @var City    $city */
/** @var Service $service */

$this->title = "Услуга недоступна — {$service->title} в {$city->name}";
?>

<section class="py-5 text-center bg-light">
    <div class="container">
        <h1 class="mb-4">Пока не оказываем услугу в <?= Html::encode($city->dative ?: $city->name) ?></h1>
        <p class="lead">
            Мы еще не начинали работу по направлению <strong><?= Html::encode($service->title) ?></strong>
            в <?= Html::encode($city->dative ?: $city->name) ?>.
        </p>
        <p>
            Вы можете стать нашим первым клиентом в этом городе —
            просто свяжитесь с нами и получите <strong>бесплатную консультацию</strong>.
        </p>
        <a href="/site/contact" class="btn btn-warning mt-3 text-dark fw-semibold">Связаться с нами</a>
    </div>
</section>
