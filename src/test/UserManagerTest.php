<?php

namespace Rayan\Tp2Test\gestion_produit;
use Rayan\Tp2Test\gestion_produit\UserManager;

use PHPUnit\Framework\TestCase;

class UserManagerTest extends TestCase
{

    public function testAddUser(){

        $user = new UserManager();
        $user->resetTable();
        $user -> addUser("rayane", "rayanebesrour3@gmail.com");
        $userResultat = $user -> getUser(1);
        $this->assertEquals("rayane", $userResultat['name']);
        $this->assertEquals("rayanebesrour3@gmail.com", $userResultat['email']);

    }
    public function testAddUserEmailException(){
        $user = new UserManager();
        $user->resetTable();
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Email invalide.");
        $user ->addUser("mauvaismail","rayaneb_gmail.com");

    }
    public function testUpdateUser(){
        $user = new UserManager();
        $user->resetTable();
        $user->addUser("rayane", "rayanebesrour3@gmail.com");
        $user->updateUser(1, "rayane", "rayanebesrour@gmail.com");
        $updatedUser = $user->getUser(1);
        $this->assertEquals("rayanebesrour@gmail.com", $updatedUser['email']);
    }
    public function testRemoveUser(){
        $user = new UserManager();
        $user->resetTable();
        $user->addUser("rayane", "rayanebesrour3@gmail.com");
        $user->removeUser(1);
        $this->assertCount(0,$user->getUsers());
    }
    public function testGetUsers(){
        $user = new UserManager();
        $user -> resetTable();
        $user -> addUser("rayane", "rayanebesrour3@gmail.com");
        $user -> addUser("rayane2", "rayanebesrour4@gmail.com");

        $users=$user->getUsers();
        $this->assertEquals([
            ['id' => 1, 'name' => 'rayane', 'email' => 'rayanebesrour3@gmail.com'],
            ['id' => 2, 'name' => 'rayane2', 'email' => 'rayanebesrour4@gmail.com']
        ], $users);

    }
    public function testInvalidUpdateThrowsException() {
        $user = new UserManager();
        $user->resetTable();
        $user->addUser("rayane", "rayanebesrour3@gmail.com");

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Utilisateur introuvable.");
        $user->updateUser(99, "rayane", "rayanebesrour@gmail.com");

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Email invalide.");
        $user->updateUser(1, "rayane", "email_invalide");
    }
    public function testInvalidDeleteThrowsException() {
        $user = new UserManager();
        $user->resetTable();
        $user->addUser("rayane", "rayanebesrour3@gmail.com");

        // Cas où l'ID n'existe pas
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Utilisateur introuvable.");
        $user->removeUser(99); // ID inexistant

        // Cas où l'utilisateur existe
        $user->removeUser(1); // Suppression de l'utilisateur existant
        $this->assertCount(0, $user->getUsers()); // Vérifier qu'il n'y a plus d'utilisateurs
    }

}
