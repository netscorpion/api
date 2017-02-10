<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>
<div class="site-error">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </div>

    <p>
        Если у вас проблеммы с ображением с функционалом !?!?!
    </p>
    <p>
        Обратитесь к администратору сайта и опишите свою проблемму.
    </p>

</div>
