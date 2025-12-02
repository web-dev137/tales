<?php

namespace app\modules\story\models;

use Exception;
use Yii;
use yii\base\Model;
use yii\httpclient\Client;

class Story extends Model
{
    const Characters = [
        'knight'=>'рыцарь',
        'king' => 'король',
        'princess' => 'принцесса',
        'wizzard' => 'волшебник',
        'scientist' => 'ученый',
    ];

    const Languages = [
        'ru' => 'Русский',
        'kk' => 'Казахский',
    ];
    public ?int $age = null;
    public string $lang = 'ru';   

    /**
     * Summary of characters
     * @var string[]
     */
    public array $characters = [];
    public function rules()
    {
        return [
            [['age', 'lang', 'characters'], 'required'],
            ['age', 'integer', 'min' => 3, 'max' => 16 ],
            ['lang', 'in', 'range' => ['ru', 'kk']],
            ['characters', 'each', 'rule' => ['string']],
        ];
    }

    public function attributeHints()
    {
        return ['age'=>'Возраст от 3 до 16'];
    }

    public function getStory(): string
    {
        if (!$this->validate()) {
            Yii::error('Validation error');
        }

        $client = new Client([
            'requestConfig' => [
                'format' => Client::FORMAT_JSON
            ],
            'responseConfig' => [
                'format' => Client::FORMAT_JSON
            ],
        ]);

       $response  = $client->createRequest()
                ->setMethod('POST')
                ->setUrl('http://api:8000/generate_story/')
                ->setData([
                    'age' => $this->age,
                    'lang' => $this->lang,
                    'characters' => $this->characters,
                ])
                ->send();
        if(!$response->isOk) {
            Yii::error('HTTP request error to story API'. $response->statusCode);
            return 'Ошибка при получении сказки'.$response->statusCode;
        }
        
        $text = $this->formatText($response->data["story"]);

        return $text;
    } 

    public function formatText($text):string
    {
        $text = preg_replace('/([.!?])\s+/', '$1</br>', $text);
        return trim($text);
    }
}