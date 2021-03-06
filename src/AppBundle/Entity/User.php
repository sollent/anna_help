<?php


namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $firstName;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $lastName;

    /**
     * @var mixed
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\ProjectTime", mappedBy="user")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $projectsTime;

    public function __construct()
    {
        parent::__construct();

        $this->projectsTime = new ArrayCollection();
    }

    /**
     * @param ProjectTime $projectTime
     */
    public function addProjectTime(ProjectTime $projectTime)
    {
        $this->projectsTime->add($projectTime);
        $projectTime->setUser($this);
    }

    /**
     * @param ProjectTime $projectTime
     */
    public function removeProjectTime(ProjectTime $projectTime)
    {
        $this->projectsTime->removeElement($projectTime);
        $projectTime->setUser(null);
    }

    /**
     * @return mixed
     */
    public function getProjectsTime()
    {
        return $this->projectsTime;
    }

    /**
     * @param mixed $projectsTime
     */
    public function setProjectsTime($projectsTime)
    {
        foreach ($projectsTime as $item) {
            if (!$this->projectsTime->contains($item)) {
                $this->addProjectTime($item);
            }
        }
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }
}
