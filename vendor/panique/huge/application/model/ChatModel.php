<?php

class ChatModel {
    public static function sendMessage($message_text, $receiver_id) {
        $database = DatabaseFactory::getFactory()->getConnection();
        if (!empty($message_text) && !empty($receiver_id)) {
            $user_id_sender = Session::get('user_id'); 
            
            
            $sql = "INSERT INTO messages (user_id_sender, user_id_receiver, message) VALUES (:user_id_sender, :user_id_receiver, :message)";
            
            
            $query = $database->prepare($sql);
            
            $query->execute(array(
                ':user_id_sender' => $user_id_sender,
                ':user_id_receiver' => $receiver_id,
                ':message' => $message_text
            ));
    
            
            if ($query->rowCount() == 1) {
                echo "Nachricht erfolgreich gesendet!";
                return true;
            } else {
                echo "Fehler beim Senden der Nachricht!";
            }
        } else {
            echo "sdfdsffdsdf";
        }
        
        Session::add('feedback_negative', Text::get('FEEDBACK_NOTE_CREATION_FAILED'));
        return false;
    }

    public static function getMessagesForUser($user_id_receiver) {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT message FROM messages WHERE user_id_sender = :user_id AND user_id_receiver = :user_id_receiver LIMIT 1";
        $query = $database->prepare($sql);
        $query->execute(array(':user_id' => Session::get('user_id'), ':user_id_receiver' => $user_id_receiver));

        return $query->fetch();
    }
}

?>