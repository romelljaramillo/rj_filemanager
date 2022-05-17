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

namespace Roanja\Rjfilesmanager\Grid\Filters;

use Roanja\Rjfilesmanager\Grid\Definition\Factory\RjfileGridDefinitionFactory;
use PrestaShop\PrestaShop\Core\Search\Filters;

class RjfileFilters extends Filters
{
    protected $filterId = RjfileGridDefinitionFactory::GRID_ID;

    /**
     * {@inheritdoc}
     */
    public static function getDefaults()
    {
        return [
            'limit' => 10,
            'offset' => 0,
            'orderBy' => 'id_file',
            'sortOrder' => 'asc',
            'filters' => [],
        ];
    }
}
