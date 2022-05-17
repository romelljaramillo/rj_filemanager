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

namespace Roanja\Rjfilesmanager\Form;

use Roanja\Rjfilesmanager\Entity\Rjfile;
use Roanja\Rjfilesmanager\Repository\RjfileRepository;
use PrestaShop\PrestaShop\Core\Form\IdentifiableObject\DataProvider\FormDataProviderInterface;

class RjfileFormDataProvider implements FormDataProviderInterface
{
    /**
     * @var RjfileRepository
     */
    private $repository;

    /**
     * @param RjfileRepository $repository
     */
    public function __construct(RjfileRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * {@inheritdoc}
     */
    public function getData($fileId)
    {
        $file = $this->repository->findOneById($fileId);

        $fileData = [
            'title' => $file->getTitle(),
            'file' => $file->getFile(),
        ];

        return $fileData;
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultData()
    {
        return [
            'title' => '',
            'file' => [],
        ];
    }
}
