<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use App\Models\Relation;
use Illuminate\Database\Seeder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database. 5,000 users with 300 posts spanning 1 year
     */
    public function run()
    {
        File::cleanDirectory('storage/app/public/images');
        
        for ($i = 0; $i < 50; $i++) { // temp
            User::create([
                'username' => 'user'.$i,
                'password' => Hash::make('password'),
            ]);
        }
        
        date_default_timezone_set('Asia/Singapore');
        $now = time();

        for ($i = 0; $i < 10; $i++) { // temp
            $lipsum = '';
            while ($lipsum == '') {
                try {
                    $lipsum = file_get_contents('http://loripsum.net/api/1/short/headers');
                } catch (\Exception $e) {
                    error_log($e->getMessage());
                }
            }
            $title = substr($lipsum, strpos($lipsum, '<h1>') + 4, strpos($lipsum, '</h1>') - strpos($lipsum, '<h1>') - 4);
            $content = substr($lipsum, strpos($lipsum, '<p>') + 3, strpos($lipsum, '</p>') - strpos($lipsum, '<p>') - 3);
            $rand_num = mt_rand(1, 2);
            $file_path = ($rand_num == 1 ? '/Users/kaisato/Sites/sns-app/database/seeders/cats/' : '/Users/kaisato/Sites/sns-app/database/seeders/dogs/');
            $file_name = ($rand_num == 1 ? 'cat' : 'dog');
            $file_name = $file_name.'.'.strval(mt_rand(1, 4000)).'.jpg';
            $rand_num = mt_rand(1, 3);
            if ($rand_num == 1) {
                Post::create([
                    'user_id' => rand(1, 50), // temp
                    'title' => $title,
                    'content' => $content,
                    'created_at' => date('Y-m-d H:i:s', mt_rand($now - 31536000, $now)),
                ]);
            } elseif ($rand_num == 2) {
                $file = new UploadedFile($file_path.$file_name, $file_name, 'image/jpg', null, TRUE);
                $file->store('public/images');
                $file_name = $file->hashName();
                Post::create([
                    'user_id' => rand(1, 50), // temp
                    'title' => $title,
                    'file_name' => $file_name,
                    'created_at' => date('Y-m-d H:i:s', mt_rand($now - 31536000, $now)),
                ]);
            } else {
                $file = new UploadedFile($file_path.$file_name, $file_name, 'image/jpg', null, TRUE);
                $file->store('public/images');
                $file_name = $file->hashName();
                Post::create([
                    'user_id' => rand(1, 50), // temp
                    'title' => $title,
                    'content' => $content,
                    'file_name' => $file_name,
                    'created_at' => date('Y-m-d H:i:s', mt_rand($now - 31536000, $now)),
                ]);
            }
        }
    }
}