<?php
class Config{

    const  DATABASE_HOST = 'localhost';
    const  DATABASE_NAME = 'my_blog01';
    const  DATABASE_USERNAME = 'root';
    const  DATABASE_PASSWORD ='';
    const  DATABASE_CHARSET = 'utf8mb4';
    /**
     * @var Array indicates the attributes for the PDO instances
     */
    const  PDO_OPTIONS = [
        PDO::ATTR_ERRMODE=> PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE=> PDO::FETCH_ASSOC
    ];
    /**
     * Indicates whether to create or not the database with the
     * initial data in case there is a 1049 error code (unknown database)
     * @var Boolean
     */
    const DATABASE_ON_ERROR_CONNECTION_CREATE = true;

}