<?php

use common\models\City;
use yii\helpers\Html;

/**
 * @var City   $city
 * @var string                $context  'service' | 'city'
 */

$cityPrep = Html::encode($city->dative ?: $city->name);
?>

<section class="cta-block py-5 bg-light border-top">
    <div class="container text-center">
        <?php if ($context === 'service'): ?>
            <h3 class="mb-3">Остались вопросы?</h3>
            <p class="mb-4">Проконсультируем по вашей ситуации. Первая консультация — бесплатно.</p>
        <?php else: ?>
            <h3 class="mb-3">Юрист в <?= $cityPrep ?> — рядом</h3>
            <p class="mb-4">Оставьте заявку — и специалист свяжется с вами в течение 15 минут.</p>
        <?php endif; ?>

        <a href="#contact" class="btn btn-warning text-dark fw-semibold me-2">
            Оставить заявку
        </a>
        <a href="tel:+78005553535" class="btn btn-outline-primary">
            Позвонить
        </a>
    </div>
</section>
