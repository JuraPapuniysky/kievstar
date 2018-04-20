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
     * @return null|File
     * @throws NotFoundHttpException
     */
    public static function getFileByDate($month, $year)
    {
        if (($file = File::findOne(['month' => $month, 'year' => $year])) !== null) {
            return $file;
        } else {
            throw new NotFoundHttpException('Отчет не найден');
        }
    }

    /**
     * @param File $file
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function generateReport(File $file)
    {
        return Call::find()->select('distinct(phone), sum(cost_balance), sum(cost)')
            ->where(['file_id' => $file->id])
            ->groupBy('phone')
            ->asArray()->all();
    }
}