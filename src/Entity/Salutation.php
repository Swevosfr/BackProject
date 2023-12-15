<?php
namespace App\Entity;

class Salutation {
private string $message;

public function getMessage(): string { 
    return $this->message;
}
public function setMessage(string $message): self { 
    $this->message = $message;
return $this;
}
static function of(string $message): Salutation {
$data = new Salutation();
return $data->setMessage($message); }
}