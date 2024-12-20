<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Kreait\Firebase\Factory;

class FirebaseController extends Controller
{
    protected  $messaging;

    public function __construct()
    {
        
        $firebaseCredentials = [
             "type"=> "service_account",
              "project_id"=> "dropus-ios",
              "private_key_id"=> "4ce46994762d57d3393065b71c7ee72d04b246ed",
              "private_key"=> "-----BEGIN PRIVATE KEY-----\nMIIEvgIBADANBgkqhkiG9w0BAQEFAASCBKgwggSkAgEAAoIBAQC+NMBVdGG7OMOB\n0qsdqKBa8OiSJjxnEDK6xyUtoOs5U+JrSvL323OnplWDj+mA+iN1d3/hV2DHV8VH\n8lK4cW3VLD35haQI09fJ7KC6DKPjHR9jHlxM/jxG0TWjCT5OjXaKVaNNZpe9oPet\nWt6d3j6dydCiMlW5OIAdG8/jNGPbvg8J3TyHNfZJ9ZLHZHLaBlfcQpHz/QiKh1ln\nzjvXsSQetvZ1IYXOC7vUmS+e5wbfZJeJ5LiS5F93AtXeMfMbHz3l7tPLdomRCoID\nOtVEJ9BWTablVYfI35D+tmrGdvbUgSRyn5yUjq2fQqpXRvKMCqVXd8rwPYfSVomr\n9eodnV43AgMBAAECggEADerXipPXdYGJHKiziJoGvGDAQ7a0g2i2AuCrdxPn4kFM\nYe67/ygkOvIlc65GDFVBNEkoJu7jz/I7fIYzSKJUF7MDCIz0xwiT04c9mMoapnWX\nua2bsgPa7pDu9xz9XXYQZGgxE2rG/kMW8az3zl6tVOeoHRYdxk28t2SKPjpedtI9\nrEYhaj2Y32Rj1hv135yXTG78KfZ9PQdqm/8KHL79D6bZlInMU39L0x+QFYK4+Fue\nclYzobPuw642lUKpCMUQy2sQoc+CcfnJSvZinAs02rRfZ9D8hoo0OJRS2KAiovoT\n5z5qG96edmOAWu/mqz8P7JXc9F65oQYU0xwcFQB9QQKBgQDj6SUiXXco3FivDRgq\n5zxKoaxhojGGfX3EUI5sWvWuwp2a7bLDN5qmmAK5QFvzHYpMjOXDNUMXh6Mc3P0x\nTHSgXdxI31Pq4HB4FIVr+q4HYoKbNg8O6yfU54zu4/gWFDFWLNgx4YXPWkcGUujN\npIfrdQUdY2Qf/SXLXBW1idl/0QKBgQDVpfqsIlL53PFQpH33QLT4I++qhWbCY1gd\nE5orCVyDogC8C+6yN9z+L/xmOaoWDGsQ+oqLdFwauHowC9ozMT7xWypHU1bRJglw\nf7haPrzA166+3vsS7PJq+WpJ5q2uy2CzHi+NdK1rXcFyWGsDY2oSIaHAr2ykYpHp\nogDrl/hHhwKBgQDZEU5X67M5TJx+pTcWbcRjxJYdK1CGKnGlj6AGnZ+PwjY/wBLZ\nkdUOxIsbi6vH4qO9Axk2kj0DZSE6tVPFJ2+Q6bSMB4CynO8hv1HQJSKpT+7bC2LO\nL7RxN9RoFuJLjRHsZKvI3mYGtpIc+MxYSFNYM80aT3ambQIZLOxUSiXIcQKBgQDB\nmX1UnGnqZ27474YCFs2mihH0yJu8jH9dIdUzKHGACr51qK5tKrgEUoF6NMjO4APp\nR89h3VhVElQO076vYvGxjjX6midysPAe1G2+wVkTup5r8e08UiC+FTNesj0yxrLi\nvPjESzWWtEfGkR6v3FdTBMzpqU1ejL/CIX6J/pUKYwKBgARuPosVHyX0utTOp/L9\nCKr2eEKJQU9y+zOkats71VOsdcIPfRlP6llHFTHsaEgW53Z0ViRZwPDcdTzb6ISc\nslxLl6gJT3oyqLUkA8NXPvmWJKeP6keO0jea8ej4NU3dUZhOAmYYLG8PdvbXdJOg\ndeY0bDq24z/wpGvqwJQDNSZs\n-----END PRIVATE KEY-----\n",
              "client_email"=> "firebase-adminsdk-pa1az@dropus-ios.iam.gserviceaccount.com",
              "client_id"=> "105826055674829377114",
              "auth_uri"=> "https://accounts.google.com/o/oauth2/auth",
              "token_uri"=> "https://oauth2.googleapis.com/token",
              "auth_provider_x509_cert_url"=> "https://www.googleapis.com/oauth2/v1/certs",
              "client_x509_cert_url"=> "https://www.googleapis.com/robot/v1/metadata/x509/firebase-adminsdk-pa1az%40dropus-ios.iam.gserviceaccount.com",
              "universe_domain"=> "googleapis.com"
        ]; 
        // echo "<pre>"; var_dump($firebaseCredentials); die;

        $firebase = (new Factory)
            ->withServiceAccount($firebaseCredentials);

        $this->messaging = $firebase->createMessaging();
    }

    public function sendNotification($deviceTokens,$title,$body,$data = [])
    {

        $notification = [
            "title" => $title,
            "body" => $body,  
        ];
    
        $notification = Notification::fromArray($notification);

        $message = CloudMessage::fromArray([
            'notification' => $notification,
            'data' => $data,
        ]);

        $sendReport = $this->messaging->sendMulticast($message, $deviceTokens);
     
    }


}