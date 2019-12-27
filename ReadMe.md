1) symfony install
composer create-project symfony/website-skeleton:^4.4 symfony4blog.loc

2) git setup
git init
git remote add origin git@github.com:Shkurik/symfony4blog.git
git config user.name Shkurik
git config user.email oleksandr.shkuropat@gmail.com
git add .
git commit -m 'symfony 4.4 install'
git checkout -b dev

3) create controller
php bin/console make:controller
>Article
php bin/console make:controller
> Comment

4) create entity(model)
php bin/console make:entity
> Article
php bin/console make:entity
> Comment

5) create form (bind form to entity)
php bin/console make:form
> ArticleType

php bin/console make:form
> CommentType
https://youtu.be/T9vF7qNavkw?t=1903

6)setup env.local file
DATABASE_URL=mysql://root:1@127.0.0.1:3306/symfony4blog

7) create database
php bin/console doctrine:database:create

8) create Migration
php bin/console make:migration

9) run Migration
php bin/console doctrine:migrations:migrate

10) create new routs
11)
php bin/console make:migration
php bin/console doctrine:migrations:migrate