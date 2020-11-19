<?php

namespace App\Entity;

use App\Repository\MatchMakerRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * @ORM\Entity(repositoryClass=MatchMakerRepository::class)
 * @ApiResource
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
    private $player1;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $player2;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $encounterDate;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlayer1(): ?string
    {
        return $this->player1;
    }

    public function setPlayer1(string $player1): self
    {
        $this->player1 = $player1;

        return $this;
    }

    public function getPlayer2(): ?string
    {
        return $this->player2;
    }

    public function setPlayer2(string $player2): self
    {
        $this->player2 = $player2;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

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

    public PlayerInterface $playerA;
    public PlayerInterface $playerB;

    public ?float $scorePlayerA = null;
    public ?float $scorePlayerB = null;


    public function __construct(PlayerInterface $playerA, PlayerInterface $playerB )
    {
        $this->playerA = $playerA;
        $this->playerB = $playerB;

    }

    public function getWinner(): ?Player
    {
        if(null === ($this-> scorePlayerA ?? $this-> scorePlayerB ?? null)){
            throw new \Exception('Missing result to get a winner');
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
