<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Firebase Project
    |--------------------------------------------------------------------------
    |
    | Specify the name of the default project. This name must exist in the
    | "projects" array below. Use this name to reference the default Firebase
    | app throughout your application.
    |
    */

    'default' => env('FIREBASE_PROJECT', 'app'),

    /*
    |--------------------------------------------------------------------------
    | Firebase Projects
    |--------------------------------------------------------------------------
    |
    | Define multiple Firebase projects if needed. The key is the project name,
    | and the value is the configuration for that project.
    |
    */

    'projects' => [

        'app' => [

            /*
            |--------------------------------------------------------------------------
            | Credentials / Service Account
            |--------------------------------------------------------------------------
            |
            | Set the path to the service account credentials JSON file. You can also
            | set this to an array if you want to directly include the credentials.
            |
            */

            'credentials' => [
                'file' => env('FIREBASE_CREDENTIALS', base_path('storage/app/firebase-auth.json')),
            ],

            /*
            |--------------------------------------------------------------------------
            | Firebase Database
            |--------------------------------------------------------------------------
            |
            | If you're using the Firebase Realtime Database, provide its URL here.
            |
            */

            'database' => [
                'url' => env('FIREBASE_DATABASE_URL'),
            ],

            /*
            |--------------------------------------------------------------------------
            | Firebase Storage
            |--------------------------------------------------------------------------
            |
            | Provide your default Cloud Storage bucket if you're using Firebase Storage.
            |
            */

            'storage' => [
                'default_bucket' => env('FIREBASE_STORAGE_BUCKET'),
            ],

        ],

    ],

];
