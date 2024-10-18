
<?php

class User {
    public $admin;
    public $photo;
    public $phone;
    public $email;
    public $name;
    public $username;
    public $password;
    public $city;
    public $user_id;
    public $bio;
    
   

    public function __construct($admin, $photo, $phone ,$email, $name, $username, $password, $city = null, $user_id = null, $bio = null) {
        $this->admin = $admin;
        $this->photo = $photo;
        $this->phone = $phone;
        $this->email = $email;
        $this->name = $name;
        $this->username = $username;
        $this->password = $password;
        $this->city = $city;
        $this->user_id = $user_id ?? uniqid($email, true);
        $this->bio = $bio;
    }   
        
    

    public static function getUser(PDO $db, string $email, string $password) : ?User {
        $email = trim($email);
        $password = trim($password);

        $stmt = $db->prepare('SELECT * FROM User WHERE email = ?');
        $stmt->execute([strtolower($email)]);
    
        if ($user = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if (password_verify($password, $user['password'])) {
                return new User(
                    $user['admin'],
                    $user['photo'],
                    $user['phone'],
                    $user['email'],
                    $user['name'],
                    $user['username'],
                    $user['password'],
                    $user['city'],
                    $user['user_id'],
                    $user['bio']
                );
            }
        }
        return null;
    }

    public static function getUserById(PDO $db, string $id) : ?User {

        $stmt = $db->prepare('SELECT * FROM User WHERE user_id = ?');
        $stmt->execute([strtolower($id)]);
    
        if ($user = $stmt->fetch(PDO::FETCH_ASSOC)) {
                return new User(
                    $user['admin'],
                    $user['photo'],
                    $user['phone'],
                    $user['email'],
                    $user['name'],
                    $user['username'],
                    $user['password'],
                    $user['city'],
                    $user['user_id'],
                    $user['bio']
                );
        }
        return null;
    }
    public function saveUser(PDO $db) :bool {
        $stmt = $db->prepare('INSERT INTO USER (admin ,photo, phone, email, name,username, password, city, user_id, bio) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
        $stmt->execute([
            $this->admin,
            $this->photo,
            $this->phone,
            $this->email,
            $this->name,
            $this->username,
            password_hash($this->password, PASSWORD_DEFAULT),
            $this->city ?? "",
            $this->user_id,
            $this->bio ?? ""
        ]);
        return true;
    }

    public static function getCurrentUser(PDO $db, $user_id) : ?User {
        $stmt = $db->prepare('SELECT * FROM User WHERE user_id = ?');
        $stmt->execute(array ($user_id));
    
        if ($user = $stmt->fetch(PDO::FETCH_ASSOC)) {
            return new User(
                $user['admin'],
                $user['photo'],
                $user['phone'],
                $user['email'],
                $user['name'],
                $user['username'],
                $user['password'],
                $user['city'],
                $user['user_id'],
                $user['bio']
            );
        }
        return null;
    }

    public static function userEmailAlreadyExists(PDO $db, string $email): bool {
        $stmt = $db->prepare('SELECT COUNT(*) FROM User WHERE email = ?');
        $stmt->execute([$email]);
        $result = $stmt->fetchColumn();
        return $result > 0;
    }

    public static function usernameAlreadyExists(PDO $db, string $username): bool {
        $stmt = $db->prepare('SELECT COUNT(*) FROM User WHERE username = ?');
        $stmt->execute([$username]);
        $result = $stmt->fetchColumn();
        return $result > 0;
    }

    public static function userPhoneAlreadyExists(PDO $db, string $phone): bool {
        $stmt = $db->prepare('SELECT COUNT(*) FROM User WHERE phone = ?');
        $stmt->execute([$phone]);
        $result = $stmt->fetchColumn();
        return $result > 0;
    }


    public function updateUser(PDO $db, $phone, $email, $name, $username, $password, $city, $bio, $photo): bool {
        $stmt = $db->prepare('UPDATE User SET name = ?, city = ?, phone = ?, email = ?, username = ?, password = ?, bio = ?, photo = ? WHERE user_id = ?');

        if (!empty($password)) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        } else {
            $hashedPassword = $this->password;
        }

        $stmt->execute([
            $name,
            $city,
            $phone,
            $email,
            $username,
            $hashedPassword,
            $bio,
            $photo,
            $this->user_id
        ]);

        return true;
    }

    public function serialize() {
        return serialize([
            'admin' => $this->admin,
            'photo' => $this->photo,
            'phone' => $this->phone,
            'email' => $this->email,
            'name' => $this->name,
            'username' => $this->username,
            'city' => $this->city,
            'user_id' => $this->user_id,
            'bio' => $this->bio,
        ]);
    }

    public function unserialize($value) {
        $value = unserialize($value);
        $this->admin = $value['admin'];
        $this->photo = $value['photo'];
        $this->phone =$value['phone'];
        $this->email =$value['email'];
        $this->name =$value['name'];
        $this->username =$value['username'];
        $this->city =$value['city'];
        $this->user_id =$value['user_id'];
        $this->bio =$value['bio'];
    }
}

