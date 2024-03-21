
<div class="container">
    <h1>ChatController/index</h1>
    <div class="box">
        <!-- echo out the system feedback (error and success messages) -->
        <?php $this->renderFeedbackMessages(); ?>
        <form method="post" action="<?php echo Config::get('URL');?>chat/getMessages">
            <?php foreach($this->users as $user) {
                echo '<input type="submit" name="receiver_id" value="'.$user->user_name.'" autocomplete="off">';
            } ?>
        </form>
        <form method="post" action="<?php echo Config::get('URL');?>chat/send">
                    <label>Message </label><input type="text" name="message_text" />
                    <input type="submit" value='Send Message' autocomplete="off" />
        </form>
        <div class="card">
            <p><?php foreach($this->messages as $message) {echo json_encode($message);}?></p>
        </div>
    </div>
</div>
