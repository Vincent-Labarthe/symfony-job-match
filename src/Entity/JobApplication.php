<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\JobApplicationRepository")
 */
class JobApplication 
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
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $adress;

    /**
     * @ORM\Column(type="integer")
     */
    private $refId;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Recruiter", inversedBy="jobApplications")
     * @ORM\JoinColumn(nullable=true)
     */
    private $recruiter;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="jobApplications")
     */
    private $user;

    public function __construct()
    {
        $this->user = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getAdress(): ?int
    {
        return $this->adress;
    }

    public function setAdress(int $adress): self
    {
        $this->adress = $adress;

        return $this;
    }

    public function getRecruiter(): ?recruiter
    {
        return $this->recruiter;
    }

    public function setRecruiter(?recruiter $recruiter): self
    {
        $this->recruiter = $recruiter;

        return $this;
    }

    /**
     * @return Collection|user[]
     */
    public function getUser(): Collection
    {
        return $this->user;
    }

    public function addUser(user $user): self
    {
        if (!$this->user->contains($user)) {
            $this->user[] = $user;
        }

        return $this;
    }

    public function removeUser(user $user): self
    {
        if ($this->user->contains($user)) {
            $this->user->removeElement($user);
        }

        return $this;
    }
    

    /**
     * Get the value of refId
     */ 
    public function getRefId()
    {
        return $this->refId;
    }

    /**
     * Set the value of refId
     *
     * @return  self
     */ 
    public function setRefId($refId)
    {
        $this->refId = $refId;

        return $this;
    }
}
