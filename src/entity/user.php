<?php

namespace Entity;
/**
 * Description of user
 *
 * @author Etudiant
 */
class user {
    
    /**
     * Primary key for user
     * @var INT 
     */
    
    
    private $id;


    /**
     * username of user
     * @var string 
     */
    
    
    private $username;
    
     /**
     * email of user
     * @var string 
     */
    
    
    private $email;
    
     /**
     * prenom of user
     * @var string 
     */
    
    
    private $firstname;
    
     /**
     * nom of user
     * @var string 
     */
    
    
    private $name;
    
    public function getId(): INT {
    return $this->id;
    }

    public function getUsername() {
    return $this->username;
    }

    public function getEmail() {
    return $this->email;
    }

    public function getFirstName() {
    return $this->firstname;
    }

    public function getName() {
    return $this->name;
    }

    public function setId(INT $id) {
    $this->id = $id;
    }

    public function setUsername($username) {
    $this->username = $username;
    }

    public function setEmail($email) {
    $this->email = $email;
    }

    public function setFirstName($firstname) {
    $this->firstname = $firstname;
    }

    public function setName($name) {
    $this->name = $name;
    }
    

}