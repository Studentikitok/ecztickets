<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "poster".
 *
 * @property int $id_poster
 * @property string $name
 * @property int $tickets
 *
 * @property Order[] $orders
 */
class Poster extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'poster';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'tickets'], 'required'],
            [['tickets'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_poster' => 'Id Poster',
            'name' => 'Наименование мероприятия',
            'tickets' => 'Количество свободных билетов',
        ];
    }

    /**
     * Gets query for [[Orders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::class, ['id_poster' => 'id_poster']);
    }
}
