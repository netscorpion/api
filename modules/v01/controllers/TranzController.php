<?php
/**
 * Created by PhpStorm.
 * User: a.gorshkov
 * Date: 17.01.2017
 * Time: 13:39
 */


namespace app\modules\v01\controllers;

use \app\models\User;
use app\common\models\cards;
use app\common\models\tranz;



use Faker\Provider\DateTime;
use Yii;
use yii\db\Expression;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use yii\rest\ActiveController;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;

class TranzController extends ActiveController
{

    // public $modelClass = null;
    public $modelClass = 'tranz';


    public $serializer = [
        // 'class' => 'yii\rest\Serializer',
        'class' => 'app\common\controllers\MySerializer',
        'collectionEnvelope' => 'tranzs',
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
            // 'update' => ['PUT'],
            // 'delete' => ['DELETE'],
            //  'view' => ['GET'],
            'index'=>['GET'],
        ];
    }

    public function actionIndex($sDate = '', $eDate = '', $card = '%', $perPage = 20)
    {
        // Производим анализ входных данных
        // Если не задана стартовая дата то выбирается текучая дана формата 'dd.mm.yyyy'
        if ($sDate == '') $sDate =  date("d.m.Y", strtotime("-1 day"));
        // Если не задана стартовая дата то выбирается текучая дана формата 'dd.mm.yyyy'
        if ($eDate == '') $eDate =  date("d.m.Y");

        // Проверка соотвествия дат
        if (date_create($sDate) > date_create($eDate)) $eDate = $sDate;

        return $this->prepareDataProvider($sDate, $eDate , $card  ,823, $perPage);
    }

    public  function prepareDataProvider($sDate, $eDate, $card , $idClient, $perPage)
    {
        // 648048015
        $ecp_count = new Expression('select count(*) FROM ECFIL139 c
                                      WHERE c.OPERATZIYA IN (0, 1)
                                        AND c.NOMER_TERMINALA > 0
                                        AND c.GR_NOMER <> 0
                                        AND c.GR_NOMER LIKE :card
                                        AND ID_KLIENTA = :idClient
                                        AND SUMMA_ZA_CHTO <> 0
                                        AND id_prinadl = 2
                                        AND DATA >= TO_DATE(:sDate,\'dd.mm.yyyy\') 
                                        AND DATA <= TO_DATE(:eDate,\'dd.mm.yyyy\')');
        $exp_Tranz = new Expression('SELECT CONCAT(CONCAT(TO_CHAR(c.DATA, \'DD.MM.YYYY\'), \' \'), TO_CHAR(TO_DATE(c.VREMYA, \'SSSSS\'), \'HH24:MI:SS\')) AS mDATA, 
                                        c.ID_KLIENTA, 
                                        c.GR_NOMER, 
                                        c.ID_KOSH_ZA_CHTO, 
                                        CASE WHEN (c.ID_KOSH_ZA_CHTO = 1) THEN 1 WHEN (c.ID_KOSH_ZA_CHTO = 3) THEN 14 WHEN (c.ID_KOSH_ZA_CHTO = 4) THEN 16 WHEN (c.ID_KOSH_ZA_CHTO = 5) THEN 17 WHEN (c.ID_KOSH_ZA_CHTO = 6) THEN 11 WHEN (c.ID_KOSH_ZA_CHTO = 7) THEN 12 WHEN (c.ID_KOSH_ZA_CHTO = 8) THEN 20 WHEN (c.ID_KOSH_ZA_CHTO = 9) THEN 18 WHEN (c.ID_KOSH_ZA_CHTO = 10) THEN 22 WHEN (c.ID_KOSH_ZA_CHTO = 12) THEN 83 WHEN (c.ID_KOSH_ZA_CHTO = 13) THEN 64 WHEN (c.ID_KOSH_ZA_CHTO = 14) THEN 63 WHEN (c.ID_KOSH_ZA_CHTO = 15) THEN 84 END AS ID_KOSH_Global,
                                        NVL((SELECT B.NAME_SERVICES
                                           FROM V_ECFIL001 B
                                           WHERE B.ID_SERVICES = c.ID_KOSH_ZA_CHTO), \' \') AS DESCRIPTION_KOSH_ZA_CHTO,
                                        CASE WHEN (c.OPERATZIYA = 0) THEN 1 WHEN (c.OPERATZIYA = 1) THEN -1 END AS OPERATZIYA,
                                        c.ID_PRICHINY,
                                        NVL((SELECT B.DESCRIPTION
                                           FROM V_ECFIL042 B
                                           WHERE B.ID = c.ID_PRICHINY), \' \') AS DESCRIPTION_PRICHINY,
                                        CASE WHEN (c.OPERATZIYA = 0) THEN SUMMA_ZA_CHTO WHEN (c.OPERATZIYA = 1) THEN 0 - SUMMA_ZA_CHTO END AS SUMMA_ZA_CHTO,
                                        ROUND(c.TZENA_TERMINALA / 100, 2) + ROUND(c.BASE_DELTA_PRICE / 100, 2) AS TERMINAL_COST,
                                        CASE WHEN (c.OPERATZIYA = 0) THEN c.SUMMA_ZAPROSHENAYA_CHEM WHEN (c.OPERATZIYA = 1) THEN 0 - c.SUMMA_ZAPROSHENAYA_CHEM END AS TERMINAL_SUMM,
                                        ROUND(c.TZENA_TERMINALA / 100, 2) AS DISCONT_COST,
                                        CASE WHEN (c.OPERATZIYA = 0) THEN SUMMA_CHEM_REALNO WHEN (c.OPERATZIYA = 1) THEN 0 - SUMMA_CHEM_REALNO END AS DISCONT_SUMM,
                                        ROUND(c.BASE_DELTA_PRICE / 100, 2) AS DELTA_PRICE,
                                        c.EM_GDE_OBSL,
                                        c.NOMER_TERMINALA,
                                        c.ID_TO,
                                        NVL((SELECT B.Name_TO
                                           FROM V_ECFIL037 B
                                           WHERE B.ID_TO = c.ID_TO
                                             AND B.ID_EMITENT = c.EM_GDE_OBSL), \' \') AS Name_TO,
                                        NVL((SELECT B.ADDRESS_TO
                                           FROM V_ECFIL037 B
                                           WHERE B.ID_TO = c.ID_TO
                                             AND B.ID_EMITENT = c.EM_GDE_OBSL), \' \') AS ADDRESS_TO,
                                        c.TRN_GUID
                                      FROM ECFIL139 c
                                      WHERE c.OPERATZIYA IN (0, 1) 
                                        AND c.NOMER_TERMINALA > 0 
                                        AND c.GR_NOMER <> 0
                                        AND c.GR_NOMER LIKE :card 
                                        AND ID_KLIENTA = :idClient 
                                        AND SUMMA_ZA_CHTO <> 0 
                                        AND id_prinadl = 2 
                                        AND DATA >= TO_DATE(:sDate,\'dd.mm.yyyy\') 
                                        AND DATA <= TO_DATE(:eDate,\'dd.mm.yyyy\')
                                        ORDER BY c.DATA, c.VREMYA');

        $count = Yii::$app->db->createCommand($ecp_count, [
            ':sDate' => $sDate,
            ':eDate' => $eDate,
            ':card' => $card,
            ':idClient' => $idClient,
        ])->queryScalar();

        $dataProvider = new SqlDataProvider([
                    'db' => 'db_oc1',
                    'sql' => $exp_Tranz,
                    'params' => [
                                    ':sDate' => $sDate,
                                    ':eDate' => $eDate,
                                    ':card' => $card,
                                    ':idClient' => $idClient
                    ],
                    'totalCount' => $count,
                    'pagination' => [
                        'pageSize' => $perPage,
                    ],
        ]);
        return $dataProvider;
    }
}
?>