<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Recruiter
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $companyName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $contactName;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\JobApplication", mappedBy="recruiter")
     */
    private $jobApplications;

    public function __construct()
    {
        $this->jobApplications = new ArrayCollection();
    }

    /**
     * @return Collection|JobApplication[]
     */
    public function getJobApplications(): Collection
    {
        return $this->jobApplications;
    }

    public function addJobApplication(JobApplication $jobApplication): self
    {
        if (!$this->jobApplications->contains($jobApplication)) {
            $this->jobApplications[] = $jobApplication;
            $jobApplication->setRecruiter($this);
        }

        return $this;
    }

    public function removeJobApplication(JobApplication $jobApplication): self
    {
        if ($this->jobApplications->contains($jobApplication)) {
            $this->jobApplications->removeElement($jobApplication);
            // set the owning side to null (unless already changed)
            if ($jobApplication->getRecruiter() === $this) {
                $jobApplication->setRecruiter(null);
            }
        }

        return $this;
    }
}
