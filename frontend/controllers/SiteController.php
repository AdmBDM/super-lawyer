<?php

namespace frontend\controllers;

use common\models\Service;
use common\models\ServiceCity;
use Yii;
use common\models\City;
use common\models\LoginForm;
use frontend\models\ContactForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResendVerificationEmailForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\VerifyEmailForm;
use yii\base\InvalidArgumentException;
use yii\captcha\CaptchaAction;
use yii\db\Expression;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\Cookie;
use yii\web\ErrorAction;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @return array[]
     */
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @param $action
     *
     * @return bool
     * @throws BadRequestHttpException
     */
    public function beforeAction($action): bool
    {
        /* 1. Получаем slug из cookies */
        $slug = Yii::$app->request->cookies->getValue('city', null);

        /* 2. Достаём город из БД */
        $currentCity = City::find()
            ->where(['slug' => $slug, 'is_active' => true])
            ->one();

        /* 3. Если куки нет или город неактивен — выбираем первый город по умолчанию */
        if (!$currentCity) {
            $currentCity = City::find()
                ->where(['is_active' => true])
                ->orderBy(['id' => SORT_ASC])
                ->one();
            // кладём корректную куку, чтобы больше не было «пусто»
            Yii::$app->response->cookies->add(new yii\web\Cookie([
                'name'   => 'city',
                'value'  => $currentCity->slug,
                'path'   => '/',
                'domain' => '.'.Yii::$app->request->hostName,
                'expire' => time() + 30*24*60*60,
            ]));
        }

        /* 4. Передаём в представления */
        Yii::$app->view->params['currentCity'] = $currentCity;
        Yii::$app->view->params['cityList']    = City::find()
            ->where(['in_location' => true, 'is_active' => true])
            ->orderBy(['name' => SORT_ASC])
            ->all();

        return parent::beforeAction($action);
    }


    /**
     * @return array
     */
    public function actions(): array
    {
        return [
            'error' => [
                'class' => ErrorAction::class,
            ],
            'captcha' => [
                'class' => CaptchaAction::class,
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex(): string
    {
        /* 1.  Берём текущий город и список городов
               (они уже положены в beforeAction) */
        /** @var City   $currentCity */
        /** @var City[] $cityList   */
        $currentCity = Yii::$app->view->params['currentCity'];
        $cityList    = Yii::$app->view->params['cityList'];   // для блока «другие города»

        /* 2.  Берём все активные услуги */
//        $servicesAR = Service::find()
//            ->where(['is_active' => true])
//            ->orderBy(['title' => SORT_ASC])
//            ->all();
//        $cid = $currentCity->id;

        $servicesAR = Service::find()
            ->alias('s')
            ->leftJoin(
                ['sc' => ServiceCity::tableName()],
                'sc.service_id = s.id AND sc.city_id = :cid',
                [':cid' => $currentCity->id]
            )
            ->select([
                'id'         => 's.id',
                'slug'       => 's.slug',
                'title'      => 's.title',
                'icon'       => 's.icon',
                // приоритет: sc.*  →  s.*
                new Expression('COALESCE(sc.h1,           s.h1)           AS h1'),
                new Expression('COALESCE(sc.lead,         s.lead)         AS lead'),
                new Expression('COALESCE(sc.body,         s.body)         AS body'),
                new Expression('COALESCE(sc.price_from,   s.price_from)   AS price_from'),
                new Expression('COALESCE(sc.meta_title,   s.meta_title)   AS meta_title'),
                new Expression('COALESCE(sc.meta_desc,    s.meta_desc)    AS meta_desc'),
                new Expression('COALESCE(sc.meta_keywords,s.meta_keywords)AS meta_keywords'),
                new Expression('COALESCE(sc.is_fiz,       s.is_fiz)       AS is_fiz'),
                new Expression('COALESCE(sc.is_jur,       s.is_jur)       AS is_jur'),
            ])
            ->where(['s.is_active' => true])
            ->andWhere('(sc.is_active IS NULL OR sc.is_active = true)')
            ->orderBy(['title' => SORT_ASC])
//            ->asArray()          // получаем массивы, а не AR‑объекты; удобно для списка
//            ->all()
        ;

        /* 3.  Приводим к массиву ['slug' => [title, lead]] — если нужно,
               либо прямо передаём AR‑объекты во view */
//        $services = ArrayHelper::map(
//            $servicesAR,
//            'slug',
//            function (Service $s) {
//                return [$s->title, $s->lead ?: ''];
//            }
//        );
        $services = $servicesAR->asArray()->all();   // ← готовый ассоциативный список

        return $this->render('index', [
            'currentCity' => $currentCity,
            'citySlug'    => $currentCity->slug,
            'services'    => $services,
            'cityOptions' => ArrayHelper::map($cityList, 'slug', 'name'), // для блока grid
        ]);
    }

    /**
     * Logs in a user.
     *
     * @return string|Response
     */
    public function actionLogin(): Response|string
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logs out the current user.
     *
     * @return Response
     */
    public function actionLogout(): Response
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return string|Response
     */
    public function actionContact(): Response|string
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        }

        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout(): string
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return string|Response
     */
    public function actionSignup(): Response|string
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
            return $this->goHome();
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return string|Response
     */
    public function actionRequestPasswordReset(): Response|string
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            }

            Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     *
     * @return string|Response
     * @throws BadRequestHttpException
     */
    public function actionResetPassword(string $token): Response|string
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Verify email address
     *
     * @param string $token
     *
     * @return Response
     * @throws BadRequestHttpException
     */
    public function actionVerifyEmail(string $token): Response
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if ($model->verifyEmail()) {
            Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
            return $this->goHome();
        }

        Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
        return $this->goHome();
    }

    /**
     * Resend verification email
     *
     * @return string|Response
     */
    public function actionResendVerificationEmail(): Response|string
    {
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', 'Sorry, we are unable to resend verification email for the provided email address.');
        }

        return $this->render('resendVerificationEmail', [
            'model' => $model
        ]);
    }

    /**
     * @param string $slug
     *
     * @return Response
     */
    public function actionSetCity(string $slug = 'msk'): Response
    {
        $city = City::findOne(['slug' => $slug, 'is_active' => true]);
        if ($city) {
            Yii::$app->response->cookies->add(new yii\web\Cookie([
                'name'   => 'city',
                'value'  => $slug,
                'path'   => '/',
                'domain' => '.'.Yii::$app->request->hostName,
                'expire' => time() + 30*24*60*60,
            ]));
        }
        // 💡 Независимо от того, где был пользователь — ведём его на главную
        return $this->redirect(['/']);
    }

    /**
     * @param $city
     * @param $service
     *
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionServiceView($city, $service): string
    {
        // Город
        $cityModel = City::find()
            ->where(['slug' => $city, 'is_active' => true])
            ->one();

        if (!$cityModel) {
            throw new NotFoundHttpException('Город не найден');
        }

        // Услуга
        $serviceModel = Service::find()
            ->where(['slug' => $service, 'is_active' => true])
            ->one();

        if (!$serviceModel) {
            throw new NotFoundHttpException('Услуга не найдена');
        }

        // Привязка город-услуга (service_city)
        $serviceCity = ServiceCity::find()
            ->where(['city_id' => $cityModel->id, 'service_id' => $serviceModel->id])
            ->andWhere(['is_active' => true])
            ->with('blocks')
            ->one();

        // Если связки нет — показываем лендинг «пока нет»
        if (!$serviceCity) {
            return $this->render('service-empty', [
                'city'    => $cityModel,
                'service' => $serviceModel,
            ]);
        }

        // Всё найдено — полноценный лендинг
        return $this->render('service-view', [
            'city'        => $cityModel,
            'service'     => $serviceModel,
            'serviceCity' => $serviceCity,
            'blocks'      => $serviceCity->blocks,
        ]);
    }

}
