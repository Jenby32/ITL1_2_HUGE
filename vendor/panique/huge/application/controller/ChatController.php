<?php

class ChatController extends Controller {
    public function __construct() {
        parent::__construct();
    }
    /**
     * This method controls what happens when you move to /note/index in your app.
     * Gets all notes (of the user).
     */
    public function index()
    {
        $this->View->render('chat/index');
    }

    /**
     * This method controls what happens when you move to /dashboard/create in your app.
     * Creates a new note. This is usually the target of form submit actions.
     * POST request.
     */
    public function send() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $messageText = Request::post('message_text');
            $receiverId = Request::post('user_id_receiver');
            echo $messageText. "    ". $receiverId;
            
            ChatModel::sendMessage($messageText, $receiverId);
        } else {
            echo "fehler";
        }
    }

    public function getMessages() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $receiverId = Request::post('receiver_id');
            
            $this->View->render('chat/index', array(
                                            'messages' => ChatModel::getMessagesForUser($receiverId)));
        } else {
            echo "fehler";
        }
    }
}