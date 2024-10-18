<?php
  class Session {
    private array $messages;
    private static ?Session $instance = null;

    public function __construct() {
      session_start();

      $messages = isset($_SESSION['messages']) ? $_SESSION['messages'] : [];
      unset($_SESSION['messages']);
    
    }

    public static function getInstance(): Session {
      if (self::$instance === null) {
          self::$instance = new Session();
      }
      return self::$instance;
  }


    public function get(string $key){
        return $_SESSION[$key] ?? null;
    }

    public function set(string $key, $value): void {
      $_SESSION[$key] = $value;
}

    public function addMessage(string $type, string $message) {
      $_SESSION['messages'][] = array('type' => $type, 'message' => $message);
    }

    public function getMessages() {
      return $this->messages;
    }

    public function isLoggedIn() : bool {
      return isset($_SESSION['id']);    
    }

    public function setId($user_id) {
      $_SESSION['id'] = $user_id;
    }
    
    public function getId() {
      return isset($_SESSION['id']) ? $_SESSION['id'] : null;
    }

    public function logout(){
      session_destroy();
    }

  }
?>