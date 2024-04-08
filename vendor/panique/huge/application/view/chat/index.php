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
