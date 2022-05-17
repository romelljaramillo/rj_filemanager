<?php
/**
 * 2007-2020 PrestaShop SA and Contributors
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0).
 * It is also available through the world-wide-web at this URL: https://opensource.org/licenses/AFL-3.0
 */
declare(strict_types=1);

namespace Roanja\Rjfilesmanager\Grid\Definition\Factory;

use PrestaShop\PrestaShop\Core\Grid\Action\Bulk\BulkActionCollection;
use PrestaShop\PrestaShop\Core\Grid\Action\Bulk\Type\SubmitBulkAction;
use PrestaShop\PrestaShop\Core\Grid\Action\GridActionCollection;
use PrestaShop\PrestaShop\Core\Grid\Action\Row\RowActionCollection;
use PrestaShop\PrestaShop\Core\Grid\Action\Row\Type\LinkRowAction;
use PrestaShop\PrestaShop\Core\Grid\Action\Row\Type\SubmitRowAction;
use PrestaShop\PrestaShop\Core\Grid\Action\Type\SimpleGridAction;
use PrestaShop\PrestaShop\Core\Grid\Column\ColumnCollection;
use PrestaShop\PrestaShop\Core\Grid\Column\Type\Common\ActionColumn;
use PrestaShop\PrestaShop\Core\Grid\Column\Type\Common\BulkActionColumn;
use PrestaShop\PrestaShop\Core\Grid\Column\Type\DataColumn;
use PrestaShop\PrestaShop\Core\Grid\Definition\Factory\AbstractGridDefinitionFactory;
use PrestaShop\PrestaShop\Core\Grid\Filter\Filter;
use PrestaShop\PrestaShop\Core\Grid\Filter\FilterCollection;
use PrestaShopBundle\Form\Admin\Type\SearchAndResetType;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class RjfileGridDefinitionFactory extends AbstractGridDefinitionFactory
{
    const GRID_ID = 'file';

    /**
     * {@inheritdoc}
     */
    protected function getId()
    {
        return self::GRID_ID;
    }

    /**
     * {@inheritdoc}
     */
    protected function getName()
    {
        return $this->trans('File Manager', [], 'Modules.Rjfilesmanager.Admin');
    }

    /**
     * {@inheritdoc}
     */
    protected function getColumns()
    {
        return (new ColumnCollection())
            ->add((new BulkActionColumn('bulk'))
                    ->setOptions([
                        'bulk_field' => 'id_file',
                    ])
            )
            ->add((new DataColumn('id_file'))
                    ->setName($this->trans('ID', [], 'Admin.Global'))
                    ->setOptions([
                        'field' => 'id_file',
                    ])
            )
            ->add((new DataColumn('customerId'))
                    ->setName($this->trans('customerId', [], 'Modules.Rjfilesmanager.Admin'))
                    ->setOptions([
                        'field' => 'customerId',
                    ])
            )
            ->add((new DataColumn('title'))
                    ->setName($this->trans('title', [], 'Modules.Rjfilesmanager.Admin'))
                    ->setOptions([
                        'field' => 'title',
                    ])
            )
            ->add((new DataColumn('file'))
                    ->setName($this->trans('file', [], 'Modules.Rjfilesmanager.Admin'))
                    ->setOptions([
                        'field' => 'file',
                    ])
            )
            ->add((new ActionColumn('actions'))
                    ->setName($this->trans('Actions', [], 'Admin.Global'))
                    ->setOptions([
                        'actions' => (new RowActionCollection())
                            ->add((new LinkRowAction('edit'))
                                    ->setName($this->trans('Edit', [], 'Admin.Actions'))
                                    ->setIcon('edit')
                                    ->setOptions([
                                        'route' => 'admin_rjfilesmanager_edit',
                                        'route_param_name' => 'fileId',
                                        'route_param_field' => 'id_file',
                                        'clickable_row' => true,
                                    ])
                            )
                            ->add((new SubmitRowAction('delete'))
                                    ->setName($this->trans('Delete', [], 'Admin.Actions'))
                                    ->setIcon('delete')
                                    ->setOptions([
                                        'method' => 'DELETE',
                                        'route' => 'admin_rjfilesmanager_delete',
                                        'route_param_name' => 'fileId',
                                        'route_param_field' => 'id_file',
                                        'confirm_message' => $this->trans(
                                            'Delete selected item?',
                                            [],
                                            'Admin.Notifications.Warning'
                                        ),
                                    ])
                            ),
                    ])
            )
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function getFilters()
    {
        return (new FilterCollection())
            ->add((new Filter('id_file', TextType::class))
                    ->setTypeOptions([
                        'required' => false,
                        'attr' => [
                            'placeholder' => $this->trans('ID', [], 'Admin.Global'),
                        ],
                    ])
                    ->setAssociatedColumn('id_file')
            )
            ->add((new Filter('customerId', TextType::class))
                    ->setTypeOptions([
                        'required' => false,
                        'attr' => [
                            'placeholder' => $this->trans('customerId', [], 'Modules.Rjfilesmanager.Admin'),
                        ],
                    ])
                    ->setAssociatedColumn('customerId')
            )
            ->add((new Filter('title', TextType::class))
                    ->setTypeOptions([
                        'required' => false,
                        'attr' => [
                            'placeholder' => $this->trans('title', [], 'Modules.Rjfilesmanager.Admin'),
                        ],
                    ])
                    ->setAssociatedColumn('title')
            )
            ->add((new Filter('file', TextType::class))
                    ->setTypeOptions([
                        'required' => false,
                        'attr' => [
                            'placeholder' => $this->trans('file', [], 'Modules.Rjfilesmanager.Admin'),
                        ],
                    ])
                    ->setAssociatedColumn('file')
            )
            ->add((new Filter('actions', SearchAndResetType::class))
                    ->setTypeOptions([
                        'reset_route' => 'admin_common_reset_search_by_filter_id',
                        'reset_route_params' => [
                            'filterId' => self::GRID_ID,
                        ],
                        'redirect_route' => 'admin_rjfilesmanager_list',
                    ])
                    ->setAssociatedColumn('actions')
            )
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function getGridActions()
    {
        return (new GridActionCollection())
            ->add((new SimpleGridAction('common_refresh_list'))
                ->setName($this->trans('Refresh list', [], 'Admin.Advparameters.Feature'))
                ->setIcon('refresh')
            )
            ->add((new SimpleGridAction('common_show_query'))
                ->setName($this->trans('Show SQL query', [], 'Admin.Actions'))
                ->setIcon('code')
            )
            ->add((new SimpleGridAction('common_export_sql_manager'))
                ->setName($this->trans('Export to SQL Manager', [], 'Admin.Actions'))
                ->setIcon('storage')
            )
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function getBulkActions()
    {
        return (new BulkActionCollection())
            ->add((new SubmitBulkAction('delete_bulk'))
                    ->setName($this->trans('Delete selected', [], 'Admin.Actions'))
                    ->setOptions([
                        'submit_route' => 'admin_rjfilesmanager_bulk_delete',
                        'confirm_message' => $this->trans('Delete selected items?', [], 'Admin.Notifications.Warning'),
                    ])
            )
        ;
    }
}
