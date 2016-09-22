# Simple REST API

Technologies

Laravel 5.2

Doctrine 2

#API End points with Sample Requests

Base URL - http://harvertest.dev

#Create Department

 URL - http://harvertest.dev/api/department
 
 Method -  POST
 
 Sample Request - 
 
{
"name" : "Human Resource Department"
}

#Create Sub Department

 URL - http://harvertest.dev/api/department
 
 Method -  POST
 
 Sample Request - 
 
{
"name" : "Accounts Department",
"parent_id": 1
}

#Create Employee

  URL - http://harvertest.dev/api/employee
 
  Method -  POST
 
  Sample Request - 
 
{
"name" : "Anne",
"email": "Anne@gmail.com",
"department": 1
}

#Department Hierarchy

  URL - http://harvertest.dev/api/department
 
  Method -  GET
  
#Employees of the department

  URL - http://harvertest.dev/api/department/{departmentId}
 
  Method -  GET
 
