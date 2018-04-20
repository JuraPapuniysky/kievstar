<?php


namespace frontend\models;


use common\models\File;
use yii\base\Model;

class ReportForm extends Model
{
    public $month;
    public $year;
    public $file;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [

            ['month', 'string', 'min' => 2, 'max' => 2],
            ['year', 'string', 'min' => 4, 'max' => 4],
            [['file'], 'file', 'skipOnEmpty' => false, 'extensions' => 'txt'],
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
            'file' => 'Файл'
        ];
    }

    /**
     * @return bool|File
     */
    public function uploadFile()
    {
        $uploadsPath = '';
        if ($this->validate()) {
            $path = 'files/uploads/' . $this->file->baseName . time() . '.' . $this->file->extension;
            $this->file->saveAs($uploadsPath.$path);
            $file = new File();
            $file->file_path = $uploadsPath.$path;
            $file->month = $this->month;
            $file->year = $this->year;
            if ($file->save()) {
                return $file;
            }
        } else {
            return false;
        }
    }
}