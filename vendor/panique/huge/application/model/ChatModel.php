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

        $sql1 = "SELECT message FROM messages WHERE user_id_sender = :user_id AND user_id_receiver = :user_id_receiver LIMIT 1";
        $query1 = $database->prepare($sql1);
        $query1->execute(array(':user_id' => Session::get('user_id'), ':user_id_receiver' => $user_id_receiver));

        $sql2 = "SELECT message FROM messages WHERE user_id_sender = :user_id AND user_id_receiver = :user_id_receiver LIMIT 1";
        $query2 = $database->prepare($sql2);
        $query2->execute(array(':user_id' => $user_id_receiver, ':user_id_receiver' => Session::get('user_id')));

        $chat = array_merge($query1->fetchAll(PDO::FETCH_ASSOC), $query2->fetchAll(PDO::FETCH_ASSOC));
        
        // usort($chat, function($a, $b) {
        //     return $a->timestamp_col <=> $b->timestamp_col;
        // });

        return $chat;
    }

    public static function showButtonForUsers() {
        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT user_id, user_name FROM users";
        $query = $database->prepare($sql);
        $query->execute();

        $users = $query->fetchAll();
        
        return $users;
    }
}

?>