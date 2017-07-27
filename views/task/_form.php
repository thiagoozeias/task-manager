<?php
/* @var $this yii\web\View */

use yii\helpers\BaseHtml;
use yii\helpers\Url;
?>

<div class="site-index">
    <div class="body-content">
        <div class="row">
            <div class="col-lg-12 col-xs-12">
                <h1>Inclusão/Alteração de Tarefas</h1>
                <br/>

                <form action="<?php echo (!isset($registro) ? Url::to('create') : Url::to('atualiza')); ?>" method="post">
                    <?php if (isset($registro)) { ?>
                        <input type="hidden" name="id" value="<?php echo $registro['id']; ?>"/>
                        <?php
                    } else {
                        $registro['descricao'] = "";
                    }
                    ?>
                    <input type="hidden" name="_csrf" value="<?= Yii::$app->request->getCsrfToken() ?>" />
                    <div class="row">
                        <div class="col-lg-9 col-xs-9">
                            <label for="descricao">
                                Descrição
                            </label>
                            <input type="text" value="<?= $registro['descricao']; ?>" name="descricao" id="descricao" class="form-control"/>
                        </div>
                        <div class="col-lg-3 col-xs-3">
                            <label>
                                <br/>
                            </label>
                            <input type="submit" name="salvar" value="Salvar" class="btn btn-success form-control"/>
                        </div>
                </form>
            </div>
        </div>
    </div>
</div>
