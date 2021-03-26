<?php

                /** @var $model \app\models\OtherDevice */

use app\core\form\Form;
 ?>

<a href="/">Tillbaka</a>
<h1>BankID</h1>

<div class="row mt-20">
    <div class="d-grid gap-2">
        <div class="form-group">
            <form action="" method="post">
                <?php $form = Form::begin('', 'post') ?>
                <?php echo $form->field($model, 'personalNumber') ?>
                <button type="submit" class="btn btn-primary mt-10 float-end">Logga in</button>
                <?php Form::end() ?>
            </form>
        </div>
    </div>
</div>
