<?php

namespace App\Entity;

use App\Repository\MatchMakerRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiProperty;


/**
 * @ORM\Entity(repositoryClass=MatchMakerRepository::class)
 * @ApiResource(iri="https://schema.org/SportsEvent")
 */
class MatchMaker
{

    public const STATUS_PENDING = "En attente";
    public const STATUS_PLAYING = "En cours";
    public const STAUS_OVER = "Terminé";
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status = self::STATUS_PENDING;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @ApiProperty(iri="https://schema.org/startDate")
     */
    private $encounterDate;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status =$status ;

        return $this;
    }

    public function getEncounterDate(): ?\DateTimeInterface
    {
        return $this->encounterDate;
    }

    public function setEncounterDate(?\DateTimeInterface $encounterDate): self
    {
        $this->encounterDate = $encounterDate;

        return $this;
    }

    /**
     * @ORM\ManyToOne(targetEntity="Player")
     */
    public ?PlayerInterface $playerA;

    /**
     * @ORM\ManyToOne(targetEntity="Player")
     */
    public ?PlayerInterface $playerB;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    public ?float $scorePlayerA = null;
    /**
     * @ORM\Column(type="float",  nullable=true)
     */
    public ?float $scorePlayerB = null;


    public function __construct(PlayerInterface $playerA = null, PlayerInterface $playerB = null )
    {
        $this->playerA = $playerA;
        $this->playerB = $playerB;

    }

    public function getWinner(): ?Player
    {
        if(null === ($this-> scorePlayerA ?? $this-> scorePlayerB ?? null)){
            return null;
        }
        $potentialWinners = [
            -1 => $this-> playerB,
            0=> null,
            1=> $this-> PlayerA
        ];
        return $potentialWinners[$this->scorePlayerA <=> $this->scorePlayerB];
    }
    

    public function updateRatios():void
    {
        $winner = $this->getWinner();
    
        $resultPlayerA = $this->playerA === $winner ? 1 : ($this -> playerB === $winner ? 0 : 0.5 );
        $resultPlayerB = $this->playerB === $winner ? 1 : ($this -> playerA === $winner ? 0 : 0.5 );
    
        $this-> playerA -> updateRatioAgainst($this-> playerB, $resultPlayerA);
        $this-> playerB -> updateRatioAgainst($this -> playerA, $resultPlayerB);
    }

}
