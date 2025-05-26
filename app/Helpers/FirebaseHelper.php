<?php

namespace App\Helpers;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Database;

class FirebaseHelper
{
    public static function getDatabase()
    {
        $firebase = (new Factory)
            ->withServiceAccount(base_path(env('FIREBASE_CREDENTIALS')))
            ->withDatabaseUri(env('FIREBASE_DATABASE_URL'));

        return $firebase->createDatabase();
    }

    public static function saveUser($uid, $name, $email)
    {
        $database = self::getDatabase();
        $reference = $database->getReference('employee/' . $uid);

        $reference->set([
            'name' => $name,
            'email' => $email,
            'uid' => $uid,
        ]);

        return true;
    }
}
