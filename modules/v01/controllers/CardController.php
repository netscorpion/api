<?php
/**********************************************************************************
 * User: a.gorshkov
 * Date: 17.01.2017
 * Time: 13:39
 * Version: 0.1
 * Контролер RestFull API для обработки апросов к базе данных Petrol+
 * Работа производится по следующим методам.
 * index    - вывод списка карт и их состояний
 * view     - отображение отдельной карты
 * update   - изменение состояния карты
 *********************************************************************************/
namespace app\modules\v01\controllers;

use app\models\User;

use app\common\models\PetrolLog;
use app\common\models\cards;


use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\rest\ActiveController;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;


class CardController extends ActiveController
{
    public $modelClass = 'cards';



    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'cards',
    ];


    public function behaviors()
    {
        $behaviors = parent::behaviors();

        // Авторизация пользователя

        $behaviors['authenticator']['class'] = HttpBasicAuth::className();
        $behaviors['authenticator']['class'] = QueryParamAuth::className();
        $behaviors['authenticator']['tokenParam'] = 'hash';


        $behaviors['corsFilter' ] = [
            'class' => \yii\filters\Cors::className(),
        ];

        // Перевод данных в JSON
        $behaviors['contentNegotiator'] = [
            'class' => \yii\filters\ContentNegotiator::className(),
            'formats' => [
                'application/json' => \yii\web\Response::FORMAT_JSON,
            ],
        ];
        return $behaviors;
    }

    /***
     * Переопределение методов для работы с карати все методы по умолчанию отключаются
     * @return array
     */
    public function actions()
    {
        $actions = parent::actions();
        unset($actions['create']);
        unset($actions['update']);
        unset($actions['delete']);
        unset($actions['view']);
        unset($actions['index']);
        return $actions;
    }

    /***
     * Переопределение методов доступа к данным по умолчаню
     * @return array
     */
    protected function verbs(){
        return [
            // 'create' => ['POST'],
            'update' => ['PUT'],
            // 'delete' => ['DELETE'],
            'view' => ['GET'],
            'index'=>['GET'],
        ];
    }
    /***
     * Обработка запроса PUT формата http://rest.test/cards/648051950?status=0
     * @param $id       Номер карты для которой необходимо поменять статус
     * @param $status   Статус карты может принимать значения   1 - В работе
     *                                                          5 - Заблокирована
     *                  В остальных случаях выдает сообщение об ошибке
     * @return Model
     */
    public function actionUpdate($id,$status)
    {
        Yii::info('Обновление статуса карты');
        $newStat = 0;
        // Проверка передаваемого статуса команды.
        if (is_numeric($status) && ($status == 0 || $status == 1) )
        {
            // Производим обновление записи в таблице.
            if (is_numeric($status) && ($status == 0)) {
                // Установка статуса в ЧС
                $newStat = 5;}
            elseif (is_numeric($status) && ($status == 1)) {
                // Установка статуса в работе
                $newStat = 1;}
            // Производим обновление записи
            // Yii::$app->db->createCommand()->update('user', ['status' => 1], 'age > 30')->execute();
            $result = Yii::$app->db->createCommand()->update('ECFIL012', ['ID_SOSTOYANYA' => $newStat],'GR_NOMER = '.$id.' and ID_VLADELTZA = 823')->execute();
        }
        // Производим запись в лог.
        $this->insertLog($id,$status,'web_user1');
        $model = array('result' => $result, 'card' => cards::findOne($id));
        // return $result;
        return $model;
        // return $this->insertLiog($id,$status,'web_user1');
    }
    /***
     * Обработка запроса GET формата    http://rest.test/cards/648051950
     * Вывод данных с кошельками        http://rest.test/cards/648034820?&expand=purses
     * @param $id
     * @return Model
     */
    public function actionView($id)
    {
        return $model = cards::findOne($id);
    }
    /***
     * Обработка запроса GET формата    http://rest.test/cards
     * Вывод данных по кошелькам        http://rest.test/cards?&expand=purses
     * Запрос с пагинацией  GET формата http://rest.test/cards?page=2&per-page=20
     * @return ActiveDataProvider
     */
    public function actionIndex()
    {
       return $this->prepareDataProvider();
    }
    public function prepareDataProvider()
    {
        // Предворительная подготовка списка карт для конкретного клиента.
        $provider = new ActiveDataProvider([
            'query' => cards::find()->where(['ID_CLIENT' => '823']) ,
        ]);
        return $provider;
    }
    /***
     * Запись данных в ,лог базы Petrol+
     * @param $id   Номер карты состояние которой ментяется
     * @param $status   Статуc карыт 0 в ЧС 1 в работе
     * @param $user Имя мользователя вносящего изменения
     * @return int  1 изменения внесены 0 не внесены
     */
    private function insertLog($id, $status, $user)
    {
        // Предподготовка данных
        $time = getdate();
        $second_passed = $time['seconds'] + 60*$time['minutes'] + 3600*$time['hours'];
        $date_passed  =  date("d.m.Y");
        $exp_RID = new Expression('SQ_ECFIL067.NEXTVAL');
        $exp_Date = new Expression('TO_DATE(\''.$date_passed.'\',\'dd.mm.yyyy\')');
        //$exp_Date = '2017-01-17';
        // Формирование строки лога
        if  ($status == 1)
        {
            $Str = iconv('UTF-8', 'windows-1251', 'Изменить состояние карты ' . $id . ' на В работе из RestFull API');
        }
        elseif ($status == 0)
        {
            $Str = iconv('UTF-8', 'windows-1251', 'Изменить состояние карты ' . $id . ' на В ЧС из RestFull API');
        }
        $command = Yii::$app->db->createCommand()->insert('ECFIL067',[
            'DATA' => $exp_Date,
            'VREMYA' => $second_passed,
            'STROKA' => $Str,
            //'STROKA' => 'Изменение состояния карт из RestFull API',
            'TIP_SOBUTIYA' => 1,
            'ID_KTO_RABOTAL' => 1,
            'RID' => $exp_RID,
            'NAME_COMP' => 'RestFull API',
            'USER_COMP' => $user,
            'SERTIF' => strtoupper(md5('Полная хуйня !!!!!')),
        ])->execute();
        return $command;
    }
}
?>