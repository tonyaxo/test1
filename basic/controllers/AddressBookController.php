<?php

namespace app\controllers;

use app\models\User;
use Yii;
use app\models\AddressBook;
use app\models\AddressBookFinder;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AddressBookController implements the CRUD actions for AddressBook model.
 */
class AddressBookController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Creates a new AddressBook model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @param integer $userId
     * @return mixed
     */
    public function actionCreate($userId)
    {
        $user = $this->findUser($userId);
        $model = new AddressBook(['user_id' => $userId]);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', Yii::t('app', 'Address {addressLink} created success', [
                'addressLink' => Html::a($model->title, ['/address-book/update', 'id' => $model->id]),
            ]));
            return $this->redirect(['//user/update', 'id' => $userId]);
        }

        return $this->render('create', [
            'model' => $model,
            'user' => $user,
        ]);
    }

    /**
     * Updates an existing AddressBook model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', Yii::t('app', 'Address {addressLink} updated success', [
                'addressLink' => Html::a($model->title, ['/address-book/update', 'id' => $model->id]),
            ]));
            return $this->redirect(['//user/update', 'id' => $model->user_id]);
        }

        return $this->render('update', [
            'model' => $model,
            'user' => $model->user,
        ]);
    }

    /**
     * Deletes an existing AddressBook model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the AddressBook model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AddressBook the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AddressBook::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findUser($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
