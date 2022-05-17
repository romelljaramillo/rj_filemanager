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

use Doctrine\ORM\EntityManagerInterface;
use Roanja\Rjfilesmanager\Entity\Rjfile;
use Roanja\Rjfilesmanager\Repository\RjfileRepository;
use PrestaShop\PrestaShop\Core\Form\IdentifiableObject\DataHandler\FormDataHandlerInterface;
use PrestaShopBundle\Entity\Repository\LangRepository;

class RjfileFormDataHandler implements FormDataHandlerInterface
{
    /**
     * @var RjfileRepository
     */
    private $fileRepository;

    /**
     * @var LangRepository
     */
    private $langRepository;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @param RjfileRepository $fileRepository
     * @param LangRepository $langRepository
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        RjfileRepository $fileRepository,
        LangRepository $langRepository,
        EntityManagerInterface $entityManager
    ) {
        $this->fileRepository = $fileRepository;
        $this->langRepository = $langRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * {@inheritdoc}
     */
    public function create(array $data)
    {
        $rjfile = new Rjfile();
        $rjfile->setCustomerId($data['customerId']);
        $rjfile->setTitle($data['title']);
        $rjfile->setFile($data['file']);
        
        $this->entityManager->persist($rjfile);
        $this->entityManager->flush();

        return $rjfile->getId();
    }

    /**
     * {@inheritdoc}
     */
    public function update($id, array $data)
    {
        $file = $this->fileRepository->findOneById($id);
        $file->setCustomerId($data['customerId']);
        $file->setTitle($data['title']);
        $file->setFile($data['file']);
        
        $this->entityManager->flush();

        return $file->getId();
    }
}
