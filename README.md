# sms-client
Provide websms.lu implementation

## Install

    composer require interact/sms-client
    
## Use case

Init Client
    
    use SMSClient\Client\Client;

    $client = new Client('your_login', 'your_password');

Send method
    
    $client->send('your_to', your_from', 'your_message');
    
    // the subject of the message is optionnal
    
    $client->send('your_to', your_from', 'your_message', 'your_subject');

Display method (get infos about last message sent)

    $client->display($websmsResponse);