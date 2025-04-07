<?php

namespace Ludov\UnitTestTpFinal;

use Ludov\UnitTestTpFinal\UserManager;
use Exception;
use InvalidArgumentException;

class UserManagerTest extends \PHPUnit\Framework\TestCase
{
    private UserManager $userManager;


    public function testAddUser() {
        $this->userManager = new UserManager();
        $this->userManager->addUser('Test', 'test@test.test');
        
        $users = $this->userManager->getUsers();
        $this->assertCount(1, $users);
        $this->assertEquals('Test', $users[0]['name']);
        $this->assertEquals('test@test.test', $users[0]['email']);

        //clear db
        $users = $this->userManager->getUsers();
        $userId = $users[0]['id'];

        $this->userManager->removeUser($userId);
    }
    public function testAddUserEmailException() {
        $this->userManager = new UserManager();
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Email invalide.');
        
        $this->userManager->addUser('Test', 'invalid-email');
    }
    public function testUpdateUser() {
        $this->userManager = new UserManager();
        $this->userManager->addUser('Test1', 'test1@test.test');
        $users = $this->userManager->getUsers();
        $userId = $users[0]['id'];

        $this->userManager->updateUser($userId, 'Test2', 'test2@test.test');
        
        $updatedUser = $this->userManager->getUser($userId);
        $this->assertEquals('Test2', $updatedUser['name']);
        $this->assertEquals('test2@test.test', $updatedUser['email']);

        //clear db
        $users = $this->userManager->getUsers();
        $userId = $users[0]['id'];

        $this->userManager->removeUser($userId);
    }
    public function testRemoveUser(): void
    {
        $this->userManager = new UserManager();
        $this->userManager->addUser('Test', 'test@test.test');
        $users = $this->userManager->getUsers();
        $userId = $users[0]['id'];

        $this->userManager->removeUser($userId);
        
        $this->assertCount(0, $this->userManager->getUsers());
    }

    public function testGetUsers(): void
    {
        $this->userManager = new UserManager();
        $this->userManager->addUser('Test1', 'test1@test.test');
        $this->userManager->addUser('Test2', 'test2@test.test');
        
        $users = $this->userManager->getUsers();
        
        $this->assertCount(2, $users);
        $this->assertEquals('Test1', $users[0]['name']);
        $this->assertEquals('Test2', $users[1]['name']);

        //clear db
        $users = $this->userManager->getUsers();
        $userId = $users[0]['id'];
        $userId2 = $users[1]['id'];

        $this->userManager->removeUser($userId);
        $this->userManager->removeUser($userId2);
    }

    public function testInvalidUpdateThrowsException(): void
    {
        $this->userManager = new UserManager();
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Utilisateur introuvable.');
        
        $this->userManager->updateUser(999, 'Test', 'test@test.test');
    }

    public function testInvalidDeleteThrowsException(): void
    {
        $this->userManager = new UserManager();
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Utilisateur introuvable.');
        
        $this->userManager->removeUser(999);
    }

}


?>