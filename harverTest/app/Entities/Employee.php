<?php
namespace App\Entities;
use Doctrine\ORM\Mapping AS ORM;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * @ORM\Entity
 * @ORM\Table(name="employee")
 */
class Employee
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="string")
     */
    private $name;
    /**
     * @ORM\Column(type="string", unique = true)
     */
    private $email;
    /**
     * @ORM\ManyToOne(targetEntity="Department", inversedBy="employee")
     * @var Department
     */
    private $department;  
   
    /**
    * @param $name
    * @param $email
    */
    public function __construct($name,$email)
    {
        $this->name = $name;
        $this->email = $email;
        $this->departments = new ArrayCollection();


    }
    public function getId()
    {
        return $this->id;
    }    
    public function getName()
    {
        return $this->name;
    }
    /**
    * @param $name
    */
    public function setName($name)
    {
        $this->name = $name;
    }
    public function getEmail()
    {
        return $this->email;
    }
    /**
    * @param $email
    */
    public function setEmail($email)
    {
        $this->email = $email;
    }
    /**
     * @return Department
     */
    public function getDepartment()
    {
        return $this->department;
    }

    /**
     * @param Department $department
     */
    public function setDepartment(Department $department)
    {
        $this->department = $department;
    }
}