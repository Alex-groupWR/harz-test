<?php

use Bitrix\Main\Application;
use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

class analysis_call extends CModule
{
    public $MODULE_ID = 'analysis.call';
    public $MODULE_VERSION;
    public $MODULE_VERSION_DATE;
    public $MODULE_NAME;
    public $MODULE_DESCRIPTION;
    public $PARTNER_NAME;
    public $PARTNER_URI;

    private $composerInstalled = false;
    private $modulePath = '';

    public function __construct()
    {
        $arModuleVersion = [];
        include __DIR__ . '/version.php';
        $this->MODULE_VERSION = $arModuleVersion['VERSION'];
        $this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];
        $this->MODULE_NAME = Loc::getMessage('YOURCOMPANY_ANTIBOT_MODULE_NAME');
        $this->MODULE_DESCRIPTION = Loc::getMessage('YOURCOMPANY_ANTIBOT_MODULE_DESC');
        $this->PARTNER_NAME = Loc::getMessage('YOURCOMPANY_PARTNER_NAME');
        $this->PARTNER_URI = Loc::getMessage('YOURCOMPANY_PARTNER_URI');

        $this->modulePath = $_SERVER['DOCUMENT_ROOT'] . '/local/modules/' . $this->MODULE_ID;
        $this->composerInstalled = file_exists($this->modulePath . '/vendor/autoload.php');
    }

    public function DoInstall()
    {
        global $APPLICATION;

        if (!$this->isVersionD7()) {
            $APPLICATION->ThrowException(Loc::getMessage('YOURCOMPANY_INSTALL_ERROR_D7'));
            return false;
        }


        $this->InstallDB();
        RegisterModule($this->MODULE_ID);

        // Показываем сообщение об успешной установке
        echo '<div style="margin: 20px; padding: 15px; background: #d4edda; border: 1px solid #c3e6cb; color: #155724;">';
        echo '<p><strong>✅ Модуль "Анализ звонков" успешно установлен!</strong></p>';

        if ($this->composerInstalled) {
            echo '<p>✅ Зависимости Composer установлены</p>';
        } else {
            echo '<p>⚠️ Зависимости Composer не установлены. Модуль может работать некорректно.</p>';
        }

        echo '<p><a href="/bitrix/admin/module_admin.php?lang=ru">Вернуться к списку модулей</a></p>';
        echo '</div>';

        return true;
    }

    public function DoUninstall()
    {
        global $APPLICATION;
        $this->UnInstallDB();
        UnRegisterModule($this->MODULE_ID);

        // Показываем сообщение об удалении
        echo '<div style="margin: 20px; padding: 15px; background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24;">';
        echo '<p><strong>🗑️ Модуль "Анализ звонков" удален!</strong></p>';
        echo '<p><a href="/bitrix/admin/module_admin.php?lang=ru">Вернуться к списку модулей</a></p>';
        echo '</div>';
    }

    public function InstallDB()
    {
        // Подключаем автозагрузчик Composer перед подключением классов

        include_once $this->modulePath . '/lib/Orm/Entity/CallQueuesTable.php';
        include_once $this->modulePath . '/lib/Orm/Entity/CallReportTable.php';

        try {
            if (Analysis\Call\Orm\Entity\CallQueuesTable::createTable()
                && Analysis\Call\Orm\Entity\CallReportTable::createTable()) {
                return true;
            } else {
                // Таблицы уже существуют - это нормально
                return true;
            }
        } catch (Exception $e) {
            echo '<div style="color: red; margin: 10px 0;">Ошибка создания таблиц: ' . $e->getMessage() . '</div>';
            return false;
        }
    }

    public function UnInstallDB()
    {
        if (Loader::includeModule($this->MODULE_ID)) {
            $connection = Application::getConnection();

            try {
                $connection->dropTable(Analysis\Call\Orm\Entity\CallQueuesTable::getTableName());
                $connection->dropTable(Analysis\Call\Orm\Entity\CallReportTable::getTableName());
                return true;
            } catch (Exception $e) {
                // Игнорируем ошибки при удалении несуществующих таблиц
                return true;
            }
        }
        return false;
    }



    public function isVersionD7()
    {
        return CheckVersion(
            \Bitrix\Main\ModuleManager::getVersion('main'),
            '14.00.00'
        );
    }
}