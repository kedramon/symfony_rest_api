<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TeamRepository")
 */
class Team
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $strip;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $address;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $plays;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\League", inversedBy="teams")
     * @ORM\JoinColumn(name="league", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    private $league;

    /**
     * Get id.
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set id.
     *
     * @param int $id
     *
     * @return Team
     */
    public function setID(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get name.
     *
     * @return null|string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return Team
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get strip.
     *
     * @return null|string
     */
    public function getStrip(): ?string
    {
        return $this->strip;
    }

    /**
     * Set strip.
     *
     * @param null|string $strip
     *
     * @return Team
     */
    public function setStrip(?string $strip): self
    {
        $this->strip = $strip;

        return $this;
    }

    /**
     * Get address.
     *
     * @return null|string
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }

    /**
     * Set address.
     *
     * @param string $address
     *
     * @return Team
     */
    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get plays.
     *
     * @return int|null
     */
    public function getPlays(): ?int
    {
        return $this->plays;
    }

    /**
     * Set plays.
     *
     * @param int|null $plays
     *
     * @return Team
     */
    public function setPlays(?int $plays): self
    {
        $this->plays = $plays;

        return $this;
    }

    /**
     * Get League.
     *
     * @return League|null
     */
    public function getLeague(): ?League
    {
        return $this->league;
    }

    /**
     * Set League.
     *
     * @param League|null $league
     *
     * @return Team
     */
    public function setLeague(?League $league): self
    {
        $this->league = $league;

        return $this;
    }

    /**
     * Convert to array.
     *
     * @return array|bool|float|int|mixed|string
     */
    public function toArray()
    {
        $normalizer = new ObjectNormalizer();
        $normalizer->setIgnoredAttributes(['teams', '__initializer__', '__cloner__', '__isInitialized__']);
        $normalizer->setCircularReferenceHandler(function ($object) {
            /** @var self $object */

            return $object->getId();
        });

        $normalizers = [$normalizer];
        $serializer = new Serializer($normalizers);

        return $serializer->normalize($this);
    }
}
