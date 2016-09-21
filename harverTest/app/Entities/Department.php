<?php
namespace App\Entities;
use Doctrine\ORM\Mapping AS ORM;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * @ORM\Entity
 * @ORM\Table(name="department")
 */
class Department
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
     * @ORM\OneToMany(targetEntity="Department", mappedBy="parent")
     */
    private $children;
    /**
     * @ORM\ManyToOne(targetEntity="Department", inversedBy="children")
     * @ORM\JoinColumn(name="parent_department_id", referencedColumnName="id")
     */
    private $parent;    
    /**
     * @ORM\OneToMany(targetEntity="Employee", mappedBy="department", cascade={"persist"})
     * @var ArrayCollection|Employee[]
     */
    private $employees;
  
    public function __construct($name)
    {
        $this->name = $name;
        $this->children = new ArrayCollection();
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
    public function getEmployees()
    {
        return $this->employees;
    }
    /**
     * Assigns the $employee Employee to the current department.
     *
     * @param Employee $employee
     */
    public function addEmployee(Employee $employee)
    {
        if(!$this->employees->contains($employee)) {
            $employee->setDepartment($this);
            $this->employees->add($employee);
        }
    }
    public function getParent() {
        return $this->parent;
    }
    public function getChildren() {
        return $this->children;
    }
    /**
     * Assigns the $child Department to the current department.
     *
     * @param Department $child
     */    
    public function addChild(Department $child) {
       $this->children[] = $child;
       $child->setParent($this);
    }
    /**
     * Assigns the $parent Department to the current department.
     *
     * @param Department $parent
     */
    public function setParent(Department $parent) {
       $this->parent = $parent;
    }   

}