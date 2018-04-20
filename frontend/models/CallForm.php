<?php

namespace frontend\models;


use common\models\Call;
use common\models\File;
use yii\base\Model;
use yii\web\NotFoundHttpException;

class CallForm extends Model
{
    public $month;
    public $year;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [

            ['month', 'string', 'min' => 2, 'max' => 2],
            ['year', 'string', 'min' => 4, 'max' => 4],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'month' => 'Місяць',
            'year' => 'Рік',
        ];
    }

    /**
     * @param $month
     * @param $year
     * @return File[]
     * @throws NotFoundHttpException
     */
    public static function getFileByDate($month, $year)
    {
        $files = File::findAll(['month' => $month, 'year' => $year]);
        if ( count($files) != 0) {
            return $files;
        } else {
            throw new NotFoundHttpException('Отчет не найден');
        }
    }

    /**
     * @param File[] $files
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function generateReport($files)
    {
        $fileIds = [];
        foreach ($files as $file){
            array_push($fileIds, $file->id);
        }
        return Call::find()->select('distinct(phone), sum(cost_balance) as cost_balance, sum(cost) as cost')
            ->where(['in', 'file_id', $fileIds])
            ->groupBy('phone')
            ->asArray()->all();
    }
}