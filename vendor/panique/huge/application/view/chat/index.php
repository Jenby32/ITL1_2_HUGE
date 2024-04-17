
<style>
.button-container {
  position: relative;
  display: inline-block;
  margin-right: 20px;
  margin-top: 10px;
  margin-bottom: 10px;
}

input[type="submit"] {
  width: 150px;  /* Breite des Buttons */
  height: 40px;  /* Höhe des Buttons */
  font-size: 16px; /* Größe der Schrift */
  border-radius: 5px; /* Abgerundete Ecken */
  border: 1px solid #ccc; /* Grauer Rand */
  background-color: #f8f8f8; /* Hellgraue Hintergrundfarbe */
  cursor: pointer; /* Cursor als Zeiger */
}

.notification {
  position: absolute;
  top: -10px;  /* leicht oberhalb des Containers */
  right: -10px; /* leicht rechts des Containers */
  background-color: red;
  color: white;
  border-radius: 50%;
  width: 20px;
  height: 20px;
  display: flex;
  justify-content: center;
  align-items: center;
  font-size: 12px;
}

</style>

<div class="container">
    <h1>ChatController/index</h1>
    <div class="box">
        <!-- echo out the system feedback (error and success messages) -->
        <?php $this->renderFeedbackMessages(); ?>
        <form method="post" action="<?php echo Config::get('URL');?>chat/getMessages">
        <?php foreach($this->users as $user) {
            // Initialisiere den Zähler für ungelesene Nachrichten
            $unreadCount = 0;

            // Durchlaufe das Array der ungelesenen Nachrichten, um die Anzahl der ungelesenen Nachrichten für diesen Benutzer zu finden
            foreach ($this->unreadMessages as $message) {
                if ($message->user_id_sender == $user->user_id) {
                    $unreadCount += $message->unread;
                }
            }

            echo '<div class="button-container">
            <input type="submit" name="receiver_id" value="'.$user->user_name.'" autocomplete="off">';

            if ($unreadCount > 0) {
                echo '<div class="notification">' . $unreadCount . '</div>';
            }
            echo '</div>';

        } ?>
        </form>
        <div class="card">
            <?php foreach($this->messages as $message) {?>
                <?php if($message["user_id"] == Session::get("user_id")) {?>
                    <div style="display: flex; justify-content: flex-end;">
                        <div style="position: relative; font-weight: bold; max-width: 300px; background-color: lightblue; padding: 6px; border-radius: 15px; box-shadow: 0 0 5px rgba(0,0,0,0.2); margin: 5px;">
                            <p><?php echo $message["message"]. "  " .$message["user_id"];?></p>
                        </div>
                    </div>
                <?php } else { ?>
                    <div style="display: flex; justify-content: flex-start;">
                        <div style="position: relative; font-weight: bold; max-width: 300px; background-color: #f0f0f0; padding: 6px; border-radius: 15px; box-shadow: 0 0 5px rgba(0,0,0,0.2); margin: 5px;">
                            <p class="left"><?php echo $message["message"]. "  " .$message["user_id"];?></p>
                        </div>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
        <form method="post" action="<?php echo Config::get('URL');?>chat/send">
                    <label>Message </label><input type="text" name="message_text" />
                    <input type="submit" value='Send Message' autocomplete="off" />
        </form>
    </div>
</div>
