<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property int $id_order
 * @property string $username
 * @property int $id_poster
 * @property int $tickets
 *
 * @property Poster $poster
 * @property User $username0
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'id_poster'], 'required'],
            [['id_poster', 'tickets'], 'integer'],
            [['username'], 'string', 'max' => 20],
            [['username'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['username' => 'username']],
            [['id_poster'], 'exist', 'skipOnError' => true, 'targetClass' => Poster::class, 'targetAttribute' => ['id_poster' => 'id_poster']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_order' => 'Id Order',
            'username' => 'Username',
            'id_poster' => 'Id Poster',
            'tickets' => 'Tickets',
        ];
    }

    /**
     * Gets query for [[Poster]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPoster()
    {
        return $this->hasOne(Poster::class, ['id_poster' => 'id_poster']);
    }

    /**
     * Gets query for [[Username0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsername0()
    {
        return $this->hasOne(User::class, ['username' => 'username']);
    }
}
