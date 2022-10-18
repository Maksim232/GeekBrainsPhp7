<?php

use App\Person\Name;
use App\Blog\User;
use App\Blog\Post;
use App\Blog\Comment;
use App\Blog\Repositories\UsersRepository;

include __DIR__ . "/vendor/autoload.php";

//spl_autoload_register('load');

//function load($class_name)
//{
//    $file = str_replace('_', DIRECTORY_SEPARATOR, strtolower($class_name)).'.php';
//    $file = str_replace("\\", "/", $file);
//    if ( ! file_exists($file))
//    {
//        return FALSE;
//    }
//    include $file;
//}
//$faker = Faker\Factory::create('ru_RU');
////
//$name2 = new  Name(
//    $faker->firstName('male'),
//   $faker->lastName()
//);
////$user = new User (1, $name2, 'Logg');
////echo $user;
//
////$name2 = new Name ('Viktor', 'Ivanov');
//$user = new User ($name2 ,$faker->randomDigitNotNull(), $faker->sentence(1));

//$route = $argv[1] ?? null;
//
//switch ($route){
//    case "user":
//        echo $user;
//        break;
//    case "post":
//        $post = new Post(
//            $faker->randomDigitNotNull(),
//            $user,
//            $faker->text(100)
//        );
//        echo $post;
//        break;
//    case "comment":
//        $post = new Post(
//            $faker->randomDigitNotNull(),
//            $user,
//            $faker->text(100)
//        );
//        $comment = new Comment(
//            $faker->randomDigitNotNull,
//            $user,
//            $post,
//            $faker->realText(rand(50,100))
//        );
//        echo $comment;
//        break;
//    default:
//        echo "error try user post comment parament";
//}

//$usersRepository = new InMemoryUsersRepository();
//$usersRepository->save(new User(123, new Name('Ivan', 'Nikitin')));
//
//try {
////Загружаем пользователя из репозитория
//    $user = $usersRepository->get(333);
//    print $user->name();
//} catch (UserNotFoundException $e) {
//    print $e->getMessage();
//}

