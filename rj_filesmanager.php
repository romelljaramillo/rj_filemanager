<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License version 3.0
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License version 3.0
 */
declare(strict_types=1);

use Roanja\Rjfilesmanager\Database\RjfileInstaller;

if (!defined('_CAN_LOAD_FILES_')) {
    exit;
}

if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require_once __DIR__ . '/vendor/autoload.php';
}

/**
 * Class Rj_Filesmanager.
 */
class Rj_Filesmanager extends Module
{

    /**
     * Names of ModuleAdminController used
     */
    const RJ_MODULE_ADMIN_CONTROLLERS = [
        'AdminParentTabRoanja' => [
            'name' => 'Roanja',
            'visible' => true,
            'class_name' => 'AdminParentTabRoanja'
        ],
        'AdminFilesManager' => [
            'name' => 'Files manager',
            'visible' => true,
            'class_name' => 'AdminFilesManager',
            'parent_class_name' => 'AdminParentTabRoanja',
            'route_name' => 'admin_rjfilesmanager_list',
            'icon' => 'settings'
        ]
    ];


    public function __construct()
    {
        $this->name = 'rj_filesmanager';
        $this->author = 'Roanja';
        $this->version = '1.0.0';
        $this->need_instance = 0;
        $this->tab = 'front_office_features';

        $this->bootstrap = true;
        parent::__construct();

        $this->displayName = $this->trans('Roanja Files Manager', array(), 'Modules.RjFilesManager.Admin');
        $this->description = $this->trans('file manager for management.', array(), 'Modules.RjFilesManager.Admin');
        $this->secure_key = Tools::encrypt($this->name);

        $this->ps_versions_compliancy = ['min' => '1.7.7', 'max' => _PS_VERSION_];
    }

    public function install()
    {
        if ($this->installTables() 
        && parent::install() 
        && $this->registerHook('displayFooter')
        && $this->installTabs()) {
            return true;
        }

        $this->uninstall();

        return false;
    }

    /**
     * Install all Tabs.
     *
     * @return bool
     */
    public function installTabs()
    {
        foreach (static::RJ_MODULE_ADMIN_CONTROLLERS as $adminTab) {
            if (false === $this->installTab($adminTab)) {
                return false;
            }
        }

        return true;
    }

        /**
     * Function executed at the uninstall of the module
     *
     * @return bool
     */
    public function uninstall()
    {
        return $this->removeTables() && parent::uninstall() && $this->uninstallTabs();
    }

    /**
     * Install Tab.
     * Used in upgrade script.
     *
     * @param array $tabData
     *
     * @return bool
     */
    public function installTab(array $tabData)
    {
        if (Tab::getIdFromClassName($tabData['class_name'])) {
            return true;
        }

        $tab = new Tab();
        $tab->module = $this->name;
        $tab->class_name = $tabData['class_name'];
        $tab->id_parent = empty($tabData['parent_class_name']) ? 0 : Tab::getIdFromClassName($tabData['parent_class_name']);
        
        foreach (Language::getLanguages(true) as $lang) {
            $tab->name[$lang['id_lang']] = $tabData['name'];
        }

        if(!empty($tabData['icon'])){
            $tab->icon = $tabData['icon'];
        }

        if(!empty($tabData['route_name'])){
            $tab->route_name = $tabData['route_name'];
        }

        return $tab->save();
    }

    /**
     * Uninstall all Tabs.
     *
     * @return bool
     */
    public function uninstallTabs()
    {
        foreach (static::RJ_MODULE_ADMIN_CONTROLLERS as $adminTab) {
            if (false === $this->uninstallTab($adminTab)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Uninstall Tab.
     * Can be used in upgrade script.
     *
     * @param array $tabData
     *
     * @return bool
     */
    public function uninstallTab(array $tabData)
    {
        $tabId = Tab::getIdFromClassName($tabData['class_name']);
        if (!$tabId) {
            return true;
        }
        $tab = new Tab($tabId);

        return $tab->delete();
    }

        /**
     * @return bool
     */
    private function installTables()
    {
        /** @var RjfileInstaller $installer */
        $installer = $this->getInstaller();
        $errors = $installer->createTables();

        return empty($errors);
    }

    /**
     * @return bool
     */
    private function removeTables()
    {
        /** @var RjfileInstaller $installer */
        $installer = $this->getInstaller();
        $errors = $installer->dropTables();

        return empty($errors);
    }

    /**
     * @return RjfileInstaller
     */
    private function getInstaller()
    {
        try {
            $installer = $this->get('roanja.rjfilesmanager.file.install');
        } catch (Exception $e) {
            // Catch exception in case container is not available, or service is not available
            $installer = null;
        }

        // During install process the modules's service is not available yet so we build it manually
        if (!$installer) {
            $installer = new RjfileInstaller(
                $this->get('doctrine.dbal.default_connection'),
                $this->getContainer()->getParameter('database_prefix')
            );
        }

        return $installer;
    }

    public function getContent()
    {
        Tools::redirectAdmin(
            $this->context->link->getAdminLink('AdminFilesManager')
        );
    }


}