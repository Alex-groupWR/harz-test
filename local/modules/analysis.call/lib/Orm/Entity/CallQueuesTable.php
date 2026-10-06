<?php
namespace Analysis\Call\Orm\Entity;

use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\Application;
use Bitrix\Main\ORM\Fields\{
    IntegerField,
    StringField,
    DatetimeField,
    BooleanField,
    ArrayField,
    TextField
};

class CallQueuesTable extends DataManager
{
    public static function getTableName()
    {
        return 'b_call_queues';
    }

    public static function getMap()
    {
        return [
            (new IntegerField('ID'))
                ->configurePrimary(true)
                ->configureAutocomplete(true),

            (new StringField('CALL_ID'))
                ->configureTitle('id звонка')
                ->configureNullable(true),

            (new BooleanField('IN_WORK'))
                ->configureValues('N', 'Y')
                ->configureDefaultValue('N')
                ->configureTitle('В обработке'),

            (new TextField('RECORD_LINK'))
                ->configureTitle('Ссылка на запись звонка')
                ->configureNullable(true),

            (new StringField('USER_ID'))
                ->configureTitle('id менеджера')
                ->configureNullable(true),

            (new DatetimeField('CALL_DATE'))
                ->configureTitle('Дата и время звонка')
                ->configureNullable(true),

            (new DatetimeField('DATE_CREATE'))
                ->configureDefaultValue(function() {
                    return new \Bitrix\Main\Type\DateTime();
                }),

            (new DatetimeField('DATE_UPDATE'))
                ->configureDefaultValue(function() {
                    return new \Bitrix\Main\Type\DateTime();
                }),
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