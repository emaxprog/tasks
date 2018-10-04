<?php
/**
 * Файл класса PersonType
 */

namespace common\models\enums;

/**
 * Справочник типов лица
 */
class PersonType
{
    /**
     * Тип лица - Физическое лицо
     */
    const TYPE_INDIVIDUAL = 'individual';
    /**
     * Тип лица - Юридическое лицо
     */
    const TYPE_ENTITY = 'entity';

    /**
     * @var array Расшифровка
     */
    public static $labels = [
        self::TYPE_INDIVIDUAL => 'Физическое лицо',
        self::TYPE_ENTITY => 'Юридическое лицо',
    ];

    /**
     * @var string Дефолтное именование расшифроки типа
     */
    public static $defaultLabel = '(не задано)';

    /**
     * Получение расшифровки
     *
     * @param string $status
     * @return string
     */
    public static function getLabel($status)
    {
        return isset(self::$labels[$status])
            ? self::$labels[$status]
            : self::$defaultLabel;
    }

    /**
     * Получение кодов
     *
     * @return array
     */
    public static function getTypes()
    {
        return array_keys(static::$labels);
    }
}
