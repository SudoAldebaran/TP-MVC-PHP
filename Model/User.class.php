<?php

class User
{
    private ?int $id = NULL;
    private ?string $password;
    private ?string $email;
    private ?string $firstName;
    private ?string $lastName;
    private ?string $address;
    private ?string $postalCode;
    private ?string $city;
    private ?bool $admin = false;


    public function __construct(array $data)
    {
        $this->email = $data['email'] ?? null;
        $this->password = $data['password'] ?? null;
        $this->firstName = $data['firstName'] ?? null;
        $this->lastName = $data['lastName'] ?? null;
        $this->address = $data['address'] ?? null;
        $this->postalCode = $data['postalCode'] ?? null;
        $this->city = $data['city'] ?? null;
        $this->admin = $data['admin'] ?? false;
    }

    // GETTERS et SETTERS
    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
    }

    public function getEmail()
    {
        return $this->email;
    }
    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getPassword()
    {
        return $this->password;
    }
    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    public function getAddress()
    {
        return $this->address;
    }
    public function setAddress($address)
    {
        $this->address = $address;
    }

    public function getPostalCode()
    {
        return $this->postalCode;
    }
    public function setPostalCode($postalCode)
    {
        $this->postalCode = $postalCode;
    }

    public function getCity()
    {
        return $this->city;
    }
    public function setCity($city)
    {
        $this->city = $city;
    }

    public function isAdmin()
    {
        return $this->admin;
    }
    public function setAdmin($admin)
    {
        $this->admin = $admin;
    }

    public function getAdmin()
    {
        return $this->admin;
    }

    public function hydrate(array $data)
    {
        foreach ($data as $key => $donnee) {
            $method = 'set' . ucfirst(str_replace('_', '', ucwords($key, '_')));

            if (method_exists($this, $method)) {
                $this->$method($donnee);
            }
        }
    }
}
