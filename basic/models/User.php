<?php

namespace app\models;

use app\validators\DateValidator;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property int $id
 * @property string $name
 * @property string $last_name
 * @property string $birthday
 * @property string $birthDay
 * @property int $sex 1 - male, 0 - female
 * @property string $phone_number format: +7 (777) 777-7777
 * @property int $created_at
 *
 * @property AddressBook[] $addresses
 */
class User extends \yii\db\ActiveRecord
{
    const SEX_MALE = 1;
    const SEX_FEMALE = 0;

    const DB_DATE_FORMAT = 'Y-m-d H:i:s';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'updatedAtAttribute' => false
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'phone_number', 'sex'], 'required'],
            ['birthDay', DateValidator::class, 'format' => Yii::$app->formatter->dateFormat,
                'message' => Yii::t('app', 'Date example: {date}', ['date' => '12.03.1993']),
            ],
            ['sex', 'in', 'range' => [self::SEX_MALE, self::SEX_FEMALE]],
            [['name', 'last_name'], 'string', 'max' => 255],
            ['phone_number', 'string', 'max' => 17],
            ['phone_number', 'match', 'pattern' => '/^\+7\s\(\d{3}\)\s\d{3}\-\d{4}$/i'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'last_name' => Yii::t('app', 'Last Name'),
            'birthDay' => Yii::t('app', 'Birthday'),
            'sex' => Yii::t('app', 'Sex'),
            'phone_number' => Yii::t('app', 'Phone Number'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }

    /**
     * Дата рождения.
     * @return null|string
     * @throws \yii\base\InvalidConfigException
     */
    public function getBirthDay()
    {
        if (empty($this->birthday)) {
            return null;
        }

        $birthDay = \DateTime::createFromFormat(self::DB_DATE_FORMAT, $this->birthday);
        if ($birthDay === false) {
            return null;
        }
        return Yii::$app->formatter->asDate($birthDay);
    }

    /**
     * @param string $birthDay
     */
    public function setBirthDay(string $birthDay)
    {
        $format = str_replace('php:', '', Yii::$app->formatter->dateFormat);
        $birthDay = \DateTime::createFromFormat($format, $birthDay);
        if ($birthDay !== false) {
            $birthDay->setTime(0, 0 ,0);
            $this->birthday = $birthDay->format(self::DB_DATE_FORMAT);
        } else {
            $this->birthday = null;
        }
    }

    /**
     * Адреса.
     * @return \yii\db\ActiveQuery
     */
    public function getAddresses()
    {
        return $this->hasMany(AddressBook::className(), ['user_id' => 'id'])->inverseOf('user');
    }

    /**
     * Фильтр по полу.
     * @return array
     */
    public static function getSexFiler()
    {
        return [
            self::SEX_FEMALE => Yii::t('app', 'Female'),
            self::SEX_MALE => Yii::t('app', 'Male'),
        ];
    }
}
