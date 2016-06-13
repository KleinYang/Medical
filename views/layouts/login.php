/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
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

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => '医疗销售系统',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => '产品', 'url' => ['/site/index']],
            ['label' => '客户', 'url' => ['/site/client']],
            ['label' => '订单',
             'items' => [
               ['label' => '销售订单', 'url' => ['site/order']],
               ['label' => '采购订单', 'url' => ['site/purchase']],
               ['label' => '调度信息', 'url' => ['site/dispatch']],
             ],
            ],

            ['label' => '报表管理',
             'items' => [
               ['label' => '销售未到账', 'url' => ['site/notaccount']],
               ['label' => '已销账未结算', 'url' => ['site/notsettlement']],
               ['label' => '已到帐期尚未支付采购清单', 'url' => ['site/notpay']],
               ['label' => '采购发票号与批次不全', 'url' => ['site/notpurchasebatchandbill']],
               ['label' => '销售发票号与批次不全', 'url' => ['site/notorderbatchandbill']],
               ['label' => '采购批次库存清单', 'url' => ['site/orderinventory']],
               ['label' => '产品库存清单', 'url' => ['site/productinventory']],
                ],
               ],


            Yii::$app->user->isGuest ? (
                ['label' => 'Login', 'url' => ['/site/login']]
            ) : (
                '<li>'
                .Html::beginForm(['/site/logout'], 'post')
                .Html::submitButton(
                    'Logout ('.Yii::$app->user->identity->username.')',
                    ['class' => 'btn btn-link']
                )
                .Html::endForm()
                .'</li>'
            ),
        ],
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>
        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
