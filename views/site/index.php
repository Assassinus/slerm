<?php

/* @var $this yii\web\View */
/* @var $goods \app\models\Good[] */
/* @var $coins \app\models\Coin[] */
/* @var $machine_coins array */
/* @var $default_client_coins array */

$this->title = 'Аппарат';
?>
<div class="site-index">

    <div class="jumbotron" style="border: 1px solid #000; padding: 10px;">

        <div class="row">

            <div class="col-lg-8">
                <h1>Внесено - <?= Yii::$app->session->get('balance') ?></h1>
            </div>

            <?php if ( Yii::$app->session->get('balance') > 0 ) : ?>

                <div class="col-lg-4">

                    <a class="btn btn-success" href="/site/surrender" style="    margin-top: 25px;">Сдача</a>

                </div>

            <?php endif; ?>
        </div>

    </div>

    <div class="body-content">


        <div class="row" style="padding: 20px; border: 1px solid #000; margin: 0;">

            <?php foreach ( $goods as $item ) : ?>

                <div class="col-lg-3">

                    <div class="item" style="border: 1px solid #000; padding: 20px; margin: 20px;">

                        <h2><?= $item->title ?></h2>

                        <p>Осталось - <?= $item->amount ?></p>

                        <a class="btn btn-success" href="/site/buy?id=<?= $item->id ?>">Купить за <?= $item->price ?> руб.</a>

                    </div>


                </div>

            <?php endforeach; ?>

        </div>
        <div class="row" style="margin-top: 40px;">

            <div class="col-lg-6">

                <p>Кошелек пользователя</p>

            </div>

            <div class="col-lg-6">

                <p>Кошелек аппарата</p>

            </div>

        </div>

        <div class="row">

            <div class="col-lg-6">

                <?php foreach ( $coins as $coin ) : ?>

                    <div style="padding-top: 10px;">

                        <?= $coin->nominal ?> руб. - <?= $default_client_coins[$coin->id] ?? 0 ?> <a href="/site/pay?id=<?= $coin->id ?>">Внести</a>

                    </div>

                <?php endforeach; ?>

            </div>

            <div class="col-lg-6">


                <?php foreach ( $coins as $coin ) : ?>

                    <div style="padding-top: 10px;">

                        <?= $coin->nominal ?> руб. - <?= $machine_coins[$coin->id] ?? 0 ?>

                    </div>

                <?php endforeach; ?>

            </div>

        </div>
        <br>
        <br>
        <br>
        <br>
        <br>

        <div class="">

            <a class="btn btn-success" href="/site/reset-client">Обновить пользователя</a>
            <a class="btn btn-success" href="/site/reset-machine">Обновить аппарат</a>
        </div>
    </div>

</div>
