<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "call".
 *
 * @property int $id
 * @property string $date_time
 * @property string $type
 * @property string $call_directions
 * @property string $phone
 * @property double $cost_balance
 * @property double $cost
 * @property int $catalog_id
 * @property int $created_at
 * @property int $updated_at
 * @property int $file_id
 * @property int duration
 *
 * @property Catalog $catalog
 * @property File $file
 */
class Call extends \yii\db\ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'call';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date_time'], 'safe'],
            [['cost_balance', 'cost'], 'number'],
            [['catalog_id', 'created_at', 'updated_at', 'file_id', 'duration'], 'integer'],
            [['type', 'call_directions', 'phone'], 'string', 'max' => 255],
            [['catalog_id'], 'exist', 'skipOnError' => true, 'targetClass' => Catalog::className(), 'targetAttribute' => ['catalog_id' => 'id']],
            [['file_id'], 'exist', 'skipOnError' => true, 'targetClass' => File::className(), 'targetAttribute' => ['file_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date_time' => 'Date Time',
            'type' => 'Type',
            'call_directions' => 'Call Directions',
            'phone' => 'Phone',
            'cost_balance' => 'Cost Balance',
            'cost' => 'Cost',
            'catalog_id' => 'Catalog ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'file_id' => 'File ID',
            'duration' => 'Тривалість'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatalog()
    {
        return $this->hasOne(Catalog::className(), ['id' => 'catalog_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFile()
    {
        return $this->hasOne(File::className(), ['id' => 'file_id']);
    }

    /**
     * @return bool|Catalog|null|static
     */
    private function getSavedCatalog()
    {
        if (($model = Catalog::findOne(['phone' => $this->phone])) !== null){
            return $model;
        } else {
            $model = new Catalog();
            $model->phone = $this->phone;
            if ($model->save()){
                return $model;
            }else{
                return false;
            }

        }
    }

    /**
     * @param $phone
     * @return Catalog|null
     */
    private function getSavedCatalogByPhone($phone)
    {
        if (($model = Catalog::findOne(['phone' => $phone])) !== null){
            return $model;
        } else {
            $model = new Catalog();
            $model->phone = $phone;
            if ($model->save()){
                return $model;
            }else{
                return null;
            }

        }
    }

    public function formatDate($date)
    {
        //01.02.2018 01:03:56
        // to 2018-02-01 01:03:56
        $dateTime = explode(' ', $date);
        $date = $dateTime[0];
        $time = $dateTime[1];
        $dmy = explode('.', $date);
        $year = $dmy[2];
        $month = $dmy[1];
        $day = $dmy[0];
        return $year.'-'.$month.'-'.$day.' '.$time;
    }

    public static function staticFormatDate($date)
    {
        //01.02.2018 01:03:56
        // to 2018-02-01 01:03:56
        $dateTime = explode(' ', $date);
        $date = $dateTime[0];
        $time = $dateTime[1];
        $dmy = explode('.', $date);
        $year = $dmy[2];
        $month = $dmy[1];
        $day = $dmy[0];
        return $year.'-'.$month.'-'.$day.' '.$time;
    }

    /**
     * @param File $file
     * @return Call[]
     */
    public static function saveData(File $file)
    {
        $fileArray = file($file->file_path);
        $calls = [];
        foreach ($fileArray as $string){
            $string = self::convertUtf8($string);
            $phoneNeedle = 'Тел./  ';
            $catalog = null;
            if (($str = stristr($string, $phoneNeedle)) !== false){
                $str = str_replace($phoneNeedle, '', $str);
                if (($catalog = Catalog::getCatalogByPhone($str)) === null){
                    $catalog = new Catalog();
                    $catalog->phone = $str;
                    $catalog->save();
                }
            }
            if  (isset($string{2}) && $string{2} == '.' && $catalog !== null){
                $fields = explode(';', $string);
                $fields[0] = self::staticFormatDate($fields[0]);
                $fields[7] = $catalog->id;
                $fields[8] = $file->id;
                array_push($calls, $fields);
            }

        }

        self::insertData($calls);

        return $calls;
    }

    /**
     * @param array $fields
     * @param File $file
     * @return bool|Call
     */
    private static function createCall(array $fields, File $file)
    {
        $call = new Call();
        $call->date_time = $call->formatDate($fields[0]);
        $call->type = $fields[1];
        $call->call_directions = $fields[2];
        $call->phone = $fields[3];
        $call->duration = $fields[4];
        $call->cost_balance = $fields[5];
        $call->cost = $fields[6];
        $catalog = $call->getSavedCatalog();
        $call->catalog_id = $catalog->id;
        $call->file_id = $file->id;
        if ($call->save()){
            return $call;
        } else {
            return $call;
        }

    }

    private static function insertData(array $data)
    {
        Yii::$app->db->createCommand()
            ->batchInsert('call', ['date_time', 'type', 'call_directions', 'phone', 'duration', 'cost_balance', 'cost', 'catalog_id', 'file_id'], $data)
        ->execute();
    }


    public static function convertUtf8($string)
    {
        return iconv('windows-1251', 'UTF-8', $string);
    }
}
