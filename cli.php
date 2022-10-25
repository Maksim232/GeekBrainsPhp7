<?php
include __DIR__ . "/vendor/autoload.php";

use App\Blog\Post;
use App\Blog\Repositories\PostsRepository\SqlitePostsRepository;
use App\Blog\Repositories\UsersRepository\SqliteUsersRepository;
use App\Blog\UUID;
use App\Blog\User;



$connection = new PDO('sqlite:' . __DIR__ . '/blog.sqlite');
$usersRepository = new SqliteUsersRepository($connection);
$postsRepository = new SqlitePostsRepository($connection);
//Добавляем в репозиторий несколько пользователей
//$usersRepository->save(new User(UUID::random(), new Name('Ivan', 'Nikitin'), "asfc"));
//$usersRepository->save(new User(UUID::random(), new Name('Anna', 'Petrova'), "admin"));
//try{
////    $usersRepository->save(new User(UUID::random(), new Name('Ivan', 'Nikitin'), "user"));
//    echo $usersRepository->getByUsername('user');
//}catch (Exception $e){
//    echo $e->getMessage();
//}

//$command = new CreateUserCommand($usersRepository);
//try{
////    $usersRepository->save(new User(UUID::random(), new Name('Ivan', 'Nikitin'), "user"));
//    $command->handle(Arguments::fromArgv($argv));
//}catch (Exception $e){
//    echo $e->getMessage();
//}




//$user = $usersRepository->get(new UUID('cbc7b92f-6013-47f0-b0e0-6d062c0684ff'));
//var_dump($user);


try {
 $user = $usersRepository->get(new UUID('cbc7b92f-6013-47f0-b0e0-6d062c0684ff'));
    $post = new Post(
        UUID::random(),
        $user,
        'Заглавный',
        'Текст'
    );
    $postsRepository->save($post);
}
    catch (Exception $e){
 echo $e->getMessage();
}