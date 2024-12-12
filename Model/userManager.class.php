<?php
require_once('Connection.class.php');

class UserManager
{
    private PDO $db;
    private string $table = 'users';

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    // CREATE USER
    public function create(User $user): void
    {
        $req = $this->db->prepare("INSERT INTO users (password, email, firstName, lastName,
            address, postalCode, city, admin) VALUES (:password, :email, :firstName, :lastName, :address,
            :postalCode, :city, :admin)");

        $req->bindValue(':password', hash("sha256", $user->getPassword()));
        $req->bindValue(':email', $user->getEmail());
        $req->bindValue(':firstName', $user->getFirstName());
        $req->bindValue(':lastName', $user->getLastName());
        $req->bindValue(':address', $user->getAddress());
        $req->bindValue(':postalCode', $user->getPostalCode());
        $req->bindValue(':city', $user->getCity());
        $req->bindValue(':admin', 0);

        // DEBUG
        echo "<pre>";
        print_r([
            ':password' => hash("sha256", $user->getPassword()),
            ':email' => $user->getEmail(),
            ':firstName' => $user->getFirstName(),
            ':lastName' => $user->getLastName(),
            ':address' => $user->getAddress(),
            ':postalCode' => $user->getPostalCode(),
            ':city' => $user->getCity(),
            ':admin' => 0
        ]);
        echo "</pre>";

        $req->execute();
    }

    // ALL USERS
    public function findAll(): array
    {
        $users = [];
        $req = $this->db->query("SELECT * FROM {$this->table} ORDER BY id");
        while ($donnees = $req->fetch(PDO::FETCH_ASSOC)) {
            $user = new User();
            $user->hydrate($donnees);
            $users[] = $user;
        }
        return $users;
    }

    // USER BY ID
    public function findOne(int $id): ?User
    {
        $req = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = :id");
        $req->bindValue(':id', $id, PDO::PARAM_INT);
        $req->execute();

        $donnees = $req->fetch(PDO::FETCH_ASSOC);
        if ($donnees) {
            $user = new User();
            $user->hydrate($donnees);
            return $user;
        }
        return null;
    }

    // UPDATE USER
    public function update(User $user): void
    {
        try {
            $req = $this->db->prepare("UPDATE {$this->table} SET 
                password = :password, 
                email = :email, 
                firstName = :firstName, 
                lastName = :lastName, 
                address = :address, 
                postalCode = :postalCode, 
                city = :city 
                WHERE id = :id");


            $hashedPassword = password_hash($user->getPassword(), PASSWORD_DEFAULT);

            $req->bindValue(':password', $hashedPassword);
            $req->bindValue(':email', $user->getEmail());
            $req->bindValue(':firstName', $user->getFirstName());
            $req->bindValue(':lastName', $user->getLastName());
            $req->bindValue(':address', $user->getAddress());
            $req->bindValue(':postalCode', $user->getPostalCode());
            $req->bindValue(':city', $user->getCity());
            $req->bindValue(':id', $user->getId(), PDO::PARAM_INT);

            $req->execute();
        } catch (PDOException $e) {
            echo "Erreur lors de la mise à jour de l'utilisateur : " . $e->getMessage();
        }
    }


    // DELETE USER
    public function delete(User $user): void
    {
        $req = $this->db->prepare("DELETE FROM {$this->table} WHERE id = :id");
        $req->bindValue(':id', $user->getId(), PDO::PARAM_INT);
        $req->execute();
    }

    public function findByEmailAndPassword(string $email, string $password): ?User
    {
        $hashedPassword = hash("sha256", $password);
    
        $req = $this->db->prepare("SELECT * FROM {$this->table} WHERE email = :email AND password = :password");
        $req->bindValue(':email', $email);
        $req->bindValue(':password', $hashedPassword);
        $req->execute();
    
        $donnees = $req->fetch(PDO::FETCH_ASSOC);
        if ($donnees) {
            $user = new User($donnees);
            $user->hydrate($donnees);
            return $user;
        }
        return null;
    }


    public function findByEmail(string $email): ?User
    {
        // GET USER BY EMAIL
        $req = $this->db->prepare("SELECT * FROM {$this->table} WHERE email = :email");
        $req->bindValue(':email', $email);
        $req->execute();

        // GET USER DATA
        $donnees = $req->fetch(PDO::FETCH_ASSOC);

        if ($donnees) {

            $user = new User($donnees);
            return $user;
        }
        return null;
    }



    public function getAllUsers()
    {
        $query = "SELECT email, password, firstName, lastName, admin FROM users";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
