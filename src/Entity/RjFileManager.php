<?php

namespace Roanja\Rjfilesmanager\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table()
 * @ORM\Entity()
 */
class RjFileManager
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(name="id_file", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="id_customer", type="integer")
     */
    private $customerId;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=64)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="file", type="text")
     */
    private $file;


    /**
     * @var DateTime
     *
     * @ORM\Column(name="date_add", type="datetime")
     */
    private $dateAdd;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="date_upd", type="datetime")
     */
    private $dateUpd;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getCustomerId()
    {
        return $this->customerId;
    }

    /**
     * @param int $customerId
     *
     * @return RjFileManager
     */
    public function setCustomerId($customerId)
    {
        $this->customerId = $customerId;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return RjFileManager
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getfile()
    {
        return $this->file;
    }

    /**
     * @param string $file
     *
     * @return RjFileManager
     */
    public function setfile($file)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Set dateAdd.
     *
     * @param DateTime $dateAdd
     *
     * @return $this
     */
    public function setDateAdd(DateTime $dateAdd): self
    {
        $this->dateAdd = $dateAdd;

        return $this;
    }

    /**
     * Get dateAdd.
     *
     * @return DateTime
     */
    public function getDateAdd(): DateTime
    {
        return $this->dateAdd;
    }

    /**
     * Set dateUpd.
     *
     * @param DateTime $dateUpd
     *
     * @return $this
     */
    public function setDateUpd(DateTime $dateUpd): self
    {
        $this->dateUpd = $dateUpd;

        return $this;
    }

    /**
     * Get dateUpd.
     *
     * @return DateTime
     */
    public function getDateUpd(): DateTime
    {
        return $this->dateUpd;
    }

    /**
     * Now we tell doctrine that before we persist or update we call the updatedTimestamps() function.
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updatedTimestamps(): void
    {
        $this->setDateUpd(new DateTime());

        if ($this->getDateAdd() == null) {
            $this->setDateAdd(new DateTime());
        }
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'id_file' => $this->getId(),
            'id_customer' => $this->getCustomerId(),
            'title' => $this->getTitle(),
            'file' => $this->getfile(),
            'dateAdd' => $this->getDateAdd(),
            'dateUpd' => $this->getDateUpd(),
        ];
    }
}