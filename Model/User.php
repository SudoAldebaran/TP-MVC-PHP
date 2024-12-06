<?php

class User
{
    private $id;
    private $email;
    private $password;
    private $firstName;
    private $lastName;
    private $address;
    private $postalCode;
    private $city;
    private $admin;

    // Constructeur par défaut
    public function __construct()
    {
        // Initialisation des propriétés si nécessaire
        $this->id = null;
        $this->email = '';
        $this->password = '';
        $this->firstName = '';
        $this->lastName = '';
        $this->address = '';
        $this->postalCode = '';
        $this->city = '';
        $this->admin = false;
    }

    // GETTERS et SETTERS
    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; }

    public function getEmail() { return $this->email; }
    public function setEmail($email) { $this->email = $email; }

    public function getPassword() { return $this->password; }
    public function setPassword($password) { $this->password = $password; }

    public function getFirstName() { return $this->firstName; }
    public function setFirstName($firstName) { $this->firstName = $firstName; }

    public function getLastName() { return $this->lastName; }
    public function setLastName($lastName) { $this->lastName = $lastName; }

    public function getAddress() { return $this->address; }
    public function setAddress($address) { $this->address = $address; }

    public function getPostalCode() { return $this->postalCode; }
    public function setPostalCode($postalCode) { $this->postalCode = $postalCode; }

    public function getCity() { return $this->city; }
    public function setCity($city) { $this->city = $city; }

    public function isAdmin() { return $this->admin; }
    public function setAdmin($admin) { $this->admin = $admin; }

    // Hydrate method to populate the object properties
    public function hydrate(array $data)
    {
        foreach ($data as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }
}
