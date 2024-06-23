<?php declare(strict_types=1);
namespace App;
use danog\MadelineProto\EventHandler\Query\ChatButtonQuery;
use danog\MadelineProto\EventHandler\SimpleFilter\Incoming;
use danog\MadelineProto\Logger;
use danog\MadelineProto\SimpleEventHandler;
use danog\MadelineProto\EventHandler\Message;
use danog\MadelineProto\EventHandler\Attributes\Handler;
use danog\MadelineProto\EventHandler\CallbackQuery;

class Bot extends SimpleEventHandler {
    public function getReportPeers() {
        return [BOT_ADMIN];
    }
    public function onStart() {
        $this->sendMessageToAdmins("Бот готов.");
    }
    #[Handler]
    public function onMessage(Incoming&Message $message) {
        if($message->chatId != CHANNEL_ID) {
            $message->reply("Ваше предложение отправлено на модерацию. Спасибо за вклад в канал.");
            $forwardedMessage=$message->forward(BOT_ADMIN);
            $replyInlineMarkup = ["_"=>"replyInlineMarkup","rows"=>[
                ["_"=>"keyboardButtonRow", "buttons" => [
                    ["_" => "keyboardButtonCallback", "text"=>"✅", "data"=>"yes ".$message->id],
                ]]
            ]];
            $sent=$this->messages->sendMessage(peer:BOT_ADMIN,reply_to:[
                "_"=>"inputReplyToMessage",
                "reply_to_msg_id"=>$forwardedMessage[0]->id,
            ],message:"Отправляем?",reply_markup:$replyInlineMarkup);
        }
    }
    #[Handler]
    public function onButton(ChatButtonQuery $query) {
        $data=explode(" ",$query->data);

        if($data[0]=="yes") {
            $query->answer("Отправка на канал...");
            $this->messages->forwardMessages(id:[$data[1]],to_peer:CHANNEL_ID,drop_author:true);
        }
    }
}