<?php

namespace common\models;

use Yii;

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
 *
 * @property Catalog $catalog
 * @property File $file
 */
class Call extends \yii\db\ActiveRecord
{
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
            [['catalog_id', 'created_at', 'updated_at', 'file_id'], 'integer'],
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
}
