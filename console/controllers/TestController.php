<?php


namespace console\controllers;


use yii\console\Controller;

class TestController extends Controller
{

    public function actionIndex()
    {
        $string = 'Тел./  675441874';
        if (($str = stristr($string, 'Тел./')) !== false){
            $str = str_replace('Тел./  ', '', $str);
            echo $str."\n";
        }
    }

}