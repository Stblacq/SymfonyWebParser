<?php
namespace App\Client;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Psr\Log\LoggerInterface;


class RabbitMqClient
{

  private $host;
  private $port;
  private $username;
  private $password;

  public function __construct($host,$port,$username,$password) {

                 $this->host = $host;
                 $this->port = $port;
                 $this->username = $username;
                 $this->password = $password;
            }

    public function send($channelName,$data){
        $connection = new AMQPStreamConnection($this->host,
        $this->port, $this->username, $this->password);

        $channel = $connection->channel();
        
        $channel->queue_declare($channelName, false, false, false, false);
        
        $msg = new AMQPMessage($data);
        $channel->basic_publish($msg, '', $channelName);        
        $channel->close();
        $connection->close();
        return true;  ## TODO exception and logs
        
    }

    public function receive($channelName, $callback){

        $connection = new AMQPStreamConnection($this->host,
        $this->port, $this->username, $this->password);

        $channel = $connection->channel();
        
        $channel->queue_declare($channelName, false, false, false, false);

        $channel->basic_consume($channelName, '', false, true, false, false, $callback);
        
        while ($channel->is_consuming()) {
            $channel->wait();
        }

        $channel->close();
        $connection->close();
    }

    


}