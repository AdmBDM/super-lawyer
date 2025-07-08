<?php

namespace frontend\assets;

use yii\web\AssetBundle;
use yii\web\View;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot/dist';
    public $baseUrl = '@web/dist';
    public $css = ['css/main.min.css'];
    public $js = ['js/main.min.js'];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',
    ];

    public $jsOptions = ['position' => View::POS_END];

    /**
     * @param $view
     *
     * @return void
     */
    public static function register($view): void
    {
        parent::register($view);

        // выводим <script type="application/ld+json"> …
        $view->on(View::EVENT_END_BODY, function () use ($view) {
            if (isset($view->js[View::POS_BEGIN])) {
                foreach ($view->js[View::POS_BEGIN] as $code) {
                    $view->registerJs(
                        $code,
                        View::POS_END,
                        'breadcrumb-json-ld'
                    );
                }
            }
        });
    }

}
