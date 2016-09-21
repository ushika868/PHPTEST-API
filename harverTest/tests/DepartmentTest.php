<?php
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
class DepartmentTest extends TestCase
{
    /**
     * Test create Department
     *
     * @return void
     */
    public function testStoreDepartmentstatus()
    {
        $response = $this->call('POST', '/api/department', ['name' => 'Test-Department',]);
        $this->assertEquals(200, $response->status());
    }
    public function testStoreDepartmentResponse()
    {
        $response = $this->call('POST', '/api/department', ['name' => 'Test-Department-1']);
        $this->seeJson([
                'error' => false,
             ]);
    }
    /**
     * Test Department Hierarchy
     *
     * @return void
     */   
    public function testGetDepartmentHierarchyStatusCode(){
        $response = $this->call('GET', '/api/department');
        $this->assertEquals(200, $response->status());
    }    
    public function testGetDepartmentHierarchyStatus(){
        $response = $this->call('GET', '/api/department');
        $this->assertResponseOk();
    }

}