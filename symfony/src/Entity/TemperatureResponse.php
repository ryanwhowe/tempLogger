<?php

namespace App\Entity;

use App\Repository\TemperatureResponseRepository;
use DateTime;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TemperatureResponseRepository::class)
 */
class TemperatureResponse
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $event;

    /**
     * @ORM\Column(type="json")
     */
    private $response = [];

    /**
     * @ORM\Column(type="float")
     */
    private $celsius;

    /**
     * @ORM\Column(type="float")
     */
    private $relativeHumidity;

    public function __construct(){
        $this->setEvent(new DateTime());
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEvent(): ?DateTimeInterface
    {
        return $this->event;
    }

    public function setEvent(DateTimeInterface $event): self
    {
        $this->event = $event;

        return $this;
    }

    public function getResponse(): ?array
    {
        return $this->response;
    }

    public function setResponse(array $response): self
    {
        $this->response = $response;

        return $this;
    }

    public function getCelsius(): ?float
    {
        return $this->celsius;
    }

    public function setCelsius(float $celsius): self
    {
        $this->celsius = $celsius;

        return $this;
    }

    public function getRelativeHumidity(): ?float
    {
        return $this->relativeHumidity;
    }

    public function setRelativeHumidity(float $relativeHumitity): self
    {
        $this->relativeHumidity = $relativeHumitity;

        return $this;
    }
}
