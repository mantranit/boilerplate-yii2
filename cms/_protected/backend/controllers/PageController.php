<?php

namespace backend\controllers;

use common\helpers\SlugHelper;
use common\models\ContentElement;
use Yii;
use common\models\Content;
use common\models\ContentSearch;
use yii\db\ActiveRecord;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * PageController implements the CRUD actions for Content model.
 */
class PageController extends BackendController
{
    /**
     * @param \yii\base\Action $action
     * @return bool
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    /**
     * Lists all Content models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ContentSearch();
        $params = Yii::$app->request->queryParams;
        $params['ContentSearch']['content_type'] = Content::TYPE_PAGE;
        $dataProvider = $searchModel->search($params);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Content model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Content model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @param string $name
     * @return mixed
     */
    public function actionCreate($name = '[name]')
    {
        $model = new Content();

        $model->name = $name;
        $model->slug = $model->getSlug(SlugHelper::makeSlugs($name));
        $model->summary = 'summary of ' . $name;
        $model->status = Content::STATUS_DRAFT;
        $model->content_type = Content::TYPE_PAGE;
        $model->created_date = time();
        $model->created_by = Yii::$app->user->identity->username;

        if($model->save()) {
            return $this->redirect(['update', 'id' => $model->id]);
        }
        else {
            return $this->redirect(['index']);
        }
    }

    /**
     * Updates an existing Content model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
            if(isset(Yii::$app->request->post()['Content']['slug'])) {
                $model->slug = $model->getSlug(SlugHelper::makeSlugs($model->slug), $id);
            }
            else {
                if(empty($model->slug) || $model->updated_date === 0) {
                    $model->slug = $model->getSlug(SlugHelper::makeSlugs($model->name), $id);
                }
            }
            if(intval(Yii::$app->request->post()['type-submit']) === 1) {
                if($model->status !== Content::STATUS_PUBLISHED) {
                    $model->status = Content::STATUS_PUBLISHED;
                    $model->published_date = time();
                }
            }

            if(empty($model->summary)) {
                $model->summary = 'summary of ' . $model->name;
            }

            $model->updated_date = time();
            if($model->save()) {
                return $this->redirect(['update', 'id' => $model->id]);
            }
        } else {
            if($model->status === Content::STATUS_DRAFT && !$model->updated_date) {
                $model->name = '';
                $model->slug = '';
            }
            return $this->render('update', [
                'model' => $model,
                'contentElement' => new ContentElement()
            ]);
        }
    }

    /**
     * Deletes an existing Content model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        //$this->findModel($id)->delete();
        $model = $this->findModel($id);
        $model->deleted = 1;

        $model->save(false);

        return $this->redirect(['index']);
    }

    /**
     * Finds the Content model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Content the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Content::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * @param string $name
     * @param int $id
     * @return bool
     */
    public function actionCheckingduplicated($name, $id = 0)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if ($id === 0) {
            $exist = Content::findOne(['name' => $name]);
        }
        else {
            $exist = Content::findOne(['name' => $name]);
            if(is_object($exist) && $exist->id === intval($id)) {
                $exist = null;
            }
        }
        return $exist === null;
    }

    /**
     * @param $id
     * @return Response
     * @throws NotFoundHttpException
     */
    public function actionShowInMenu($id)
    {
        $model = $this->findModel($id);
        $model->show_in_menu = !$model->show_in_menu;

        $model->save(false);

        return $this->redirect(['index']);
    }
}
