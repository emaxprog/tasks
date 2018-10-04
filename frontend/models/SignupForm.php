<?php

namespace frontend\models;

use yii\base\Model;
use common\models\User;
use common\models\enums\PersonType;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $email;
    public $password;
    public $is_businessman;
    public $person_type = PersonType::TYPE_INDIVIDUAL;
    public $name;
    public $last_name;
    public $middle_name;
    public $inn;
    public $organization_name;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['email', 'trim'],
            [['email', 'password', 'person_type', 'name', 'last_name', 'middle_name'], 'required'],
            ['is_businessman', 'boolean'],
            ['inn', 'integer'],
            [['inn'], 'required', 'when' => function () {
                return $this->is_businessman || $this->person_type == PersonType::TYPE_ENTITY;
            }, 'whenClient' => "function (attribute, value) { return $('#signupform-is_businessman').is(':checked') || $('#signupform-person_type').val()=='entity'"],
            ['email', 'email'],
            [['email', 'organization_name'], 'string', 'max' => 255],
            [['name', 'middle_name'], 'string', 'max' => 32],
            ['person_type', 'string', 'max' => 16],
            ['last_name', 'string', 'max' => 64],
            ['inn', 'string', 'min' => 10, 'max' => 12],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'email' => 'E-mail',
            'password' => 'Пароль',
            'person_type' => 'Тип Лица',
            'is_businessman' => 'ИП',
            'name' => 'Имя',
            'last_name' => 'Фамилия',
            'middle_name' => 'Отчество',
            'inn' => 'ИНН',
            'organization_name' => 'Имя организации'
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->email = $this->email;
        $user->person_type = $this->person_type;
        $user->name = $this->name;
        $user->last_name = $this->last_name;
        $user->middle_name = $this->middle_name;
        $user->inn = $this->inn;
        $user->organization_name = $this->organization_name;
        $user->setPassword($this->password);
        $user->generateAuthKey();

        return $user->save() ? $user : null;
    }
}
