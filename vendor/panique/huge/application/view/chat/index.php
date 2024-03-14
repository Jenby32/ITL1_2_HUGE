
<div class="container">
    <h1>ChatController/index</h1>
    <div class="box">
        <!-- echo out the system feedback (error and success messages) -->
        <?php $this->renderFeedbackMessages(); ?>

        <form method="post" action="<?php echo Config::get('URL');?>chat/send">
            <label>Message </label><input type="text" name="message_text" />
            <label>Receiver </label><input type="number" name="user_id_receiver" />
            <input type="submit" value='Send Message' autocomplete="off" />
        </form>
        <form method="post" action="<?php echo Config::get('URL');?>chat/getMessages">
            <input type="submit" name="receiver_id" value='3' autocomplete="off" />
        </form>
        <p><?php foreach($this->messages as $message) {echo $message;}?></p>
    </div>
</div>
