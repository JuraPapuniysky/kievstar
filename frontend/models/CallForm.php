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
        if (count($files) != 0) {
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
        return Call::find()->select('distinct(catalog.phone) as phone, sum(call.cost_balance) as cost_balance, sum(call.cost) as cost, ')
            ->join('JOIN', 'catalog', 'call.catalog_id = catalog.id')
            ->where(['in', 'call.file_id', $fileIds])
            ->groupBy(['catalog.phone'])
            ->asArray()->all();
    }

    /**
     * @param array $calls
     */
    public static function exportExcel(array $calls)
    {
        $file = \Yii::createObject([
            'class' => 'codemix\excelexport\ExcelFile',
            'sheets' => [

                'Result' => [   // Name of the excel sheet
                    'data' => self::getValues($calls),

                    // Set to `false` to suppress the title row
                    'titles' => [
                        'Call_Phone',
                        'cost_balance',
                        'cost',
                    ],
                ],
            ]
        ]);
        $file->send('export.xlsx');
    }

    private static function getValues(array $calls)
    {
        $values = [];
        foreach ($calls as $call){
            array_push($values, array_values($call));
        }
        return $values;
    }
}