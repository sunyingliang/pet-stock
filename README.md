petstock
========

A Symfony demo project created to test RESTful APIs

##Requirements
1. PHP version >= 7.0
2. composer has been installed

##Installation
1. clone this repo by running 'git@github.com:sunyingliang/pet-stock.git'
2. change the database configuration item in /paht/to/pet-stock/app/config/parameters.yml to your database information
3. install essential components by running 'composer install' under your project directory
4. update database schema by running 'php bin/console doctrine:schema:update' in your terminal
    * If any error, please run 'php bin/console doctrine:schema:validate' to check
5. start server by running 'php bin/console server:run'    
6. backup database daily
    * check mysql has been installed, if not please install mysql
    * edit crontab by running '$crontab -e', and append the following item into crontab:
    ```
    0 0 * * * sudo sh /path/to/pet-stock/script/back_database.sh
    ```

##API Description

###Author API
1. Create a new author record
    * URI: http://localhost:8000/app_dev.php/api/author/create
    * Method: POST
    * Params: json / form-data 
    ~~~
    {
        "name": "peter"
    }
    ~~~
    * Return: 
    ~~~
    {
        "status": "success",
        "data": {
            "id": 5
        }
    }
    ~~~

###Article API
1. Create a new article record
    * URI: http://localhost:8000/app_dev.php/api/article/create
    * Method: POST
    * Params: json / form-data 
    ~~~
    {
        "authorId":3,
        "title":444,
        "url":"test_url6",
        "content":"test_test_url",
        "createdAt":"2017-06-20 19:18:00",
        "updatedAt":"2017-06-20 19:19:00"
    }
    ~~~
    * Return: 
    ~~~
    {
        "status": "success",
        "statusCode": 200,
        "data": {
            "id": 8
        }
    }
    ~~~

2. List all article records
    * URI: http://localhost:8000/app_dev.php/api/article/list
    * Method: POST / GET
    * Params: Nil
    * Return: 
    ~~~
    {
        "status": "success",
        "statusCode": 200,
        "data": [
            {
                "id": 3,
                "title": "test_tile",
                "author": "time",
                "summary": "test_test_url",
                "url": "test_url",
                "createdAt": "2017-06-20 19:18:00"
            },
            {
                "id": 5,
                "title": "test_tile2",
                "author": "time",
                "summary": "test_test_url",
                "url": "test_url2",
                "createdAt": "2017-06-20 19:18:00"
            }
        ]
    }
    ~~~

3. List article record by id
    * URI: http://localhost:8000/app_dev.php/api/article/list/3
    * Method: GET
    * Return: 
    ~~~
    {
        "status": "success",
        "statusCode": 200,
        "data": {
            "id": 3,
            "title": "test_tile",
            "author": "time",
            "content": "test_test_url",
            "url": "test_url",
            "createdAt": "2017-06-20 19:18:00"
        }
    }
    ~~~

4. Update a article record
    * URI: http://localhost:8000/app_dev.php/api/article/update
    * Method: POST
    * Params: json / form-data 
    ~~~
    {
        "id": 3,
        "authorId":3,
        "title":444,
        "url":"test_url33",
        "content":"test_test_url",
        "createdAt":"2017-06-20 19:18:00",
        "updatedAt":"2017-06-20 19:19:00"
    }
    ~~~
    * Return: 
    ~~~
    {
        "status": "success",
        "statusCode": 200
    }
    ~~~

5. Delete a article record by id
    * URI: http://localhost:8000/app_dev.php/api/article/delete
    * Method: POST
    * Params: json / form-data 
    ~~~
    {
        "id": 3
    }
    ~~~
    * Return: 
    ~~~
    {
        "status": "success",
        "statusCode": 200
    }
    ~~~
