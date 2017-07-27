<?php

namespace app\controllers;

use yii\helpers\Json;
use RestClient;
use Yii;

class TaskController extends \yii\web\Controller {

    public function actionCreate() {
        $api = new RestClient([
            'base_url' => Yii::$app->params['urlAPI'],
        ]);
        $last = $api->get('/default/last');
        $last = Json::decode($last->response);

        if (isset($_POST['salvar'])) {
            $_POST['ordem'] = $last['ordem'] + 1;
            $novo = (boolean) $api->post('/default/create', $_POST);
            if ($novo) {
                $this->redirect('/');
            }
        }
        return $this->render('_form');
    }

    public function actionUpdate($id) {


        $api = new RestClient([
            'base_url' => Yii::$app->params['urlAPI'],
        ]);
        $reg = $api->get('/default/' . $id);
        $reg = Json::decode($reg->response);



        return $this->render('_form', ['registro' => $reg]);
    }

    public function actionAtualiza() {
        $api = new RestClient([
            'base_url' => Yii::$app->params['urlAPI'],
        ]);
        if (isset($_POST['salvar'])) {

            $upd = (boolean) $api->put('/default/' . $_POST['id'], $_POST);
            if ($upd) {
                $this->redirect('/');
            }
        }
    }

    public function actionDelete() {
        $api = new RestClient([
            'base_url' => Yii::$app->params['urlAPI'],
        ]);

        $del = (boolean) $api->delete('/default/' . $_GET['id']);
        if (!$del) {
            echo "Erro na exclusão";
            die();
        }
        $dados = $api->get('/default');
        $dados = Json::decode($dados->response);

        if ($dados) {
            foreach ($dados as $key => $dado) {
                $upd = (boolean) $api->put('/default/' . $dado['id'], ['ordem' => $key + 1]);
            }
        }
    }

    public function actionOrdena() {
        $api = new RestClient([
            'base_url' => Yii::$app->params['urlAPI'],
        ]);

        $id = $_GET['id'];
        $dados = $api->get('/default');
        $dados = Json::decode($dados->response);
        foreach ($dados as $key => $dado) {

            if (in_array($id, $dado)) {
                switch ($_GET['op']) {
                    case 'up': {
                            $atual = $dados[$key];
                            $abaixo = $dados[$key - 1];
                            $upd = (boolean) $api->put('/default/' . $atual['id'], ['ordem' => $abaixo['ordem']]);
                            $upd = (boolean) $api->put('/default/' . $abaixo['id'], ['ordem' => $atual['ordem']]);
                        }break;
                    case 'down': {
                            $atual = $dados[$key];
                            $abaixo = $dados[$key + 1];
                            $upd = (boolean) $api->put('/default/' . $atual['id'], ['ordem' => $abaixo['ordem']]);
                            $upd = (boolean) $api->put('/default/' . $abaixo['id'], ['ordem' => $atual['ordem']]);
                        }break;
                }
            }
        }
    }

}
