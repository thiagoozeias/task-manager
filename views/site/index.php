<?php
/* @var $this yii\web\View */

use yii\helpers\Url;

$this->title = 'My Yii Application';
?>
<div class="site-index">
    <div class="body-content">
        <div class="row">
            <div class="col-lg-12">
                <h1>Lista de Tarefas</h1>
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="col-lg-12">
                <a href="<?php echo Url::to('task/create'); ?>" class="btn btn-default"><span class="glyphicon glyphicon-plus"></span> Cadastrar Tarefa</a>
            </div>
        </div>
        <br/>
        <br/>
        <div class="row">
            <div class="col-lg-12 col-xs-12">
                <table class="table table-condensed table-hover table-responsive table-striped">
                    <tr>
                        <th>
                            <p>Id</p>
                        </th>
                        <th>
                            <p>Descrição</p>
                        </th>
                        <th>
                            <p>Ações</p>
                        </th>
                        <th>

                        </th>
                    </tr>

                    <?php
                    $i = 1;
                    $total = count($data);

                    foreach ($data as $task) {
                        ?>

                        <tr>
                            <td style="vertical-align: middle;">
                                <p><?= $i; ?></p>
                            </td>
                            <td style="vertical-align: middle;">
                                <p><?= $task['descricao']; ?></p>
                            </td>
                            <td style="width: 8%;vertical-align: middle;">
                                <a href="<?php echo Url::to(['task/update', 'id' => $task['id']]); ?>" class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-pencil"></span></a>
                                <a onclick="deleteTask(<?php echo $task['id']; ?>)" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-remove"></span></a>
                            </td>
                            <td style="width: 8%;
                                vertical-align: middle;
                                ">
                                <p>
                                    <?php if ($i != 1) { ?>
                                        <button onclick="alteraOrdenacao(<?php echo $task['id']; ?>, <?php echo ($i - 1); ?>,<?php echo $i; ?>, 'up')" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-arrow-up"></span></button>
                                    <?php } ?>
                                    <?php if ((($total) != $i)) { ?>
                                        <button onclick="alteraOrdenacao(<?php echo $task['id']; ?>,<?php echo ($i + 1); ?>,<?php echo $i; ?>, 'down')" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-arrow-down"></span></button>
                                        <?php } ?>
                                </p>
                            </td>
                        </tr>

                        <?php
                        $i++;
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>
</div>
<script>

    function alteraOrdenacao(id, novaOrdem, ordemAtual, op) {
        var data = "id=" + id + "&novaOrdem=" + novaOrdem + "&ordemAtual=" + ordemAtual + "&op=" + op;
        $.ajax({
            url: "<?php echo Url::to("/task/ordena"); ?>",
            data: data,
            type: 'GET',
            success: function (result) {
                location.reload();
            }
        });
    }

    function deleteTask(deleteTask) {
        var data = 'id=' + deleteTask;
        var r = confirm("Deseja excluir essa Tarefa?");
        if (r == true) {
            $.ajax({
                url: "<?php echo Url::to("/task/delete"); ?>",
                data: data,
                success: function (result) {

                    if (result != "") {
                        alert(result);
                    } else {
                        location.reload();
                    }
                }
            });
        }
    }
</script>
