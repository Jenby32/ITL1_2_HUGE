<?php

class ChatModel {
    public static function sendMessage($message_text, $receiver_id) {
        $database = DatabaseFactory::getFactory()->getConnection();
        if (!empty($message_text) && !empty($receiver_id)) {
            $user_id_sender = Session::get('user_id'); 
            
            $sql = "INSERT INTO messages (user_id_sender, user_id_receiver ,message) VALUES (:user_id_sender, :user_id_receiver, :message)";
            
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
            echo "Fehler";
        }
        
        Session::add('feedback_negative', Text::get('FEEDBACK_NOTE_CREATION_FAILED'));
        return false;
    }

    public static function getMessagesForUser($user_id_receiver) {
        $database = DatabaseFactory::getFactory()->getConnection();
        $sql = "UPDATE messages SET viewed = 1 WHERE user_id_sender = :sender_id AND user_id_receiver = :receiver_id";
        $query = $database->prepare($sql);
        $query->execute(array(':sender_id' => Session::get('user_id'), ':receiver_id' => $user_id_receiver));

        $sql1 = "SELECT message AS message, user_id_sender AS user_id, timestamp_col FROM messages WHERE user_id_sender = :user_id AND user_id_receiver = :user_id_receiver";
        $query1 = $database->prepare($sql1);
        $query1->execute(array(':user_id' => Session::get('user_id'), ':user_id_receiver' => $user_id_receiver));

        $sql2 = "SELECT message AS message, user_id_sender AS user_id, timestamp_col FROM messages WHERE user_id_sender = :user_id AND user_id_receiver = :user_id_receiver";
        $query2 = $database->prepare($sql2);
        $query2->execute(array(':user_id' => $user_id_receiver, ':user_id_receiver' => Session::get('user_id')));

        $chat = array_merge($query1->fetchAll(PDO::FETCH_ASSOC), $query2->fetchAll(PDO::FETCH_ASSOC));

        usort($chat, function($a, $b) {
            return strtotime($a['timestamp_col']) - strtotime($b['timestamp_col']);
        });


        return $chat;
    }

    public static function showButtonForUsers() {
        $database = DatabaseFactory::getFactory()->getConnection();
        $currentUser = Session::get('user_id');

        $sql = "SELECT user_id, user_name, unread_messages FROM users WHERE NOT user_id = :currentUserId";
        $query = $database->prepare($sql);
        $query->execute(array(':currentUserId' => $currentUser));

        $users = $query->fetchAll();
        
        return $users;
    }

    public static function getUnreadMessages($userId)
    {
        $database = DatabaseFactory::getFactory()->getConnection();
 
        $sql = "CALL CountUnreadMessagesByReceiver(?);";
        $query = $database->prepare($sql);
        $query->bindParam(1, $userId, PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll();
    }
}

?>