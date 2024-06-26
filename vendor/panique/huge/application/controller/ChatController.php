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
        $this->View->render('chat/index', array("messages" => [], 'users' => ChatModel::showButtonForUsers(), 'unreadMessages' => ChatModel::getUnreadMessages(Session::get("user_id"))));
    }

    /**
     * This method controls what happens when you move to /dashboard/create in your app.
     * Creates a new note. This is usually the target of form submit actions.
     * POST request.
     */
    public function send() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $messageText = Request::post('message_text');
            $receiverId = Session::get("currentReceiver");

            ChatModel::sendMessage($messageText, $receiverId);

            $messages = ChatModel::getMessagesForUser($receiverId);
            $this->View->render('chat/index', array(
                'messages' => $messages, 'users' => ChatModel::showButtonForUsers(), 'unreadMessages' => ChatModel::getUnreadMessages(Session::get("user_id"))));
        } else {
            echo "fehler";
        }
    }

    public function getMessages() {
        global $currentReceiver;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $receiverName = Request::post('receiver_id');
            $database = DatabaseFactory::getFactory()->getConnection();


            $sql1 = "SELECT user_id FROM users WHERE user_name = :receiverName LIMIT 1";
            $query1 = $database->prepare($sql1);
            $query1->execute(array(':receiverName' => $receiverName));
            $receiver = $query1->fetch();
            
            $currentReceiver = $receiver->user_id;
            Session::set("currentReceiver", $currentReceiver);
            echo Session::get("currentReceiver");
            // echo json_encode($receiverId->user_id);
            $messages = ChatModel::getMessagesForUser($currentReceiver);
            // echo Session::get('user_id');
            $this->View->render('chat/index', array(
                                            'messages' => $messages, 'users' => ChatModel::showButtonForUsers(), 'unreadMessages' => ChatModel::getUnreadMessages(Session::get("user_id"))));
        } else {
            echo "fehler";
        }
    }
}