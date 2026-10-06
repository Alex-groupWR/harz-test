<?php

namespace Analysis\Call\Orm\Entity;

use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\Application;
use Bitrix\Main\Type\DateTime;
use Bitrix\Main\ORM\Fields\{
    IntegerField,
    StringField,
    DatetimeField,
    BooleanField,
    ArrayField,
    TextField,
};

class CallReportTable extends DataManager
{
    public static function getTableName()
    {
        return 'b_call_report';
    }

    public static function getMap()
    {
        return [
            (new IntegerField('ID'))
                ->configurePrimary(true)
                ->configureAutocomplete(true),

            (new StringField('MANAGER'))
                ->configureTitle('Менеджер')
                ->configureSize(255)
                ->configureRequired(true),

            (new DatetimeField('CALL_DATETIME'))
                ->configureTitle('Дата и время звонка')
                ->configureRequired(true),

            (new BooleanField('GREETING'))
                ->configureTitle('Приветствие')
                ->configureValues('N', 'Y')
                ->configureDefaultValue('N'),

            (new BooleanField('EMPLOYEE_INTRODUCED'))
                ->configureTitle('Сотрудник представился')
                ->configureValues('N', 'Y')
                ->configureDefaultValue('N'),

            (new BooleanField('NO_MONOSYLLABIC_ANSWERS'))
                ->configureTitle('Отсутствие односложных ответов')
                ->configureValues('N', 'Y')
                ->configureDefaultValue('N'),

            (new BooleanField('POLITENESS'))
                ->configureTitle('Вежливость')
                ->configureValues('N', 'Y')
                ->configureDefaultValue('N'),

            (new BooleanField('INTERRUPTION'))
                ->configureTitle('Перебивание')
                ->configureValues('N', 'Y')
                ->configureDefaultValue('N'),

            (new BooleanField('FAREWELL'))
                ->configureTitle('Прощание')
                ->configureValues('N', 'Y')
                ->configureDefaultValue('N'),

            (new TextField('COMMENT'))
                ->configureTitle('Комментарий')
                ->configureNullable(true),

            (new DatetimeField('CALL_DATE'))
                ->configureTitle('Дата и время звонка')
                ->configureNullable(true),

            (new DatetimeField('DATE_CREATE'))
                ->configureTitle('Дата создания записи')
                ->configureDefaultValue(function () {
                    return new DateTime();
                }),

            (new DatetimeField('DATE_UPDATE'))
                ->configureTitle('Дата обновления записи')
                ->configureDefaultValue(function () {
                    return new DateTime();
                })
                ->configureRequired(true),
        ];
    }

    public static function createTable()
    {
        $connection = Application::getConnection();
        $tableName = self::getTableName();

        if (!$connection->isTableExists($tableName)) {
            self::getEntity()->createDbTable();
            return true;
        }
        return false;
    }
}