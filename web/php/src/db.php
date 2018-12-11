<?php
try {
    $db=new PDO('mysql:host=localhost;dbname=iseti', 'aminelch', 'demo', [
    //PDO::MYSQL_ATTR_INIT_COMMAND=>  "SET NAMES utf8",
    PDO::ATTR_ERRMODE=>             PDO::ERRMODE_WARNING,
    PDO::ATTR_DEFAULT_FETCH_MODE=>  PDO::FETCH_OBJ
    ]);
} catch (Exception $e) {
    echo 'Impossible de se connecter au base de donnée<br>';
    echo '<strong>'.$e->getMessage().'<strong>';
    //exit();
}


function getAllPosts()
{
    global $db;
    try {
        $select=$db->query('SELECT * FROM posts ORDER BY id DESC');
        $posts=$select->fetchAll();
        return $posts;
    } catch (PDOException $e) {
        return $e->getMessage();
    }
}


function getPostById($id)
{
    global $db;
    $id=$db->quote($id);
    $select=$db->query("SELECT * FROM posts WHERE id= $id");
    $post=$select->fetch();
    return $post;
}

function deletePost($id)
{
    global $db;
    $id=$db->quote($id);
    $req=$db->query("DELETE FROM posts WHERE id= $id");
    return $req->rowCount();
}

/**
 * Get posts count
 * @param  [type] $db [the database linker used to deploy request]
 * @return [int]     [number of posts exist]
 */
function getPostsCount()
{
    global $db;
    $count= $db->query("SELECT id from posts")->rowCount();
    return $count;
}

/**
 * Get news count
 * @param  [type] $db [the database linker used to deploy request]
 * @return [int]     [number of news exist]
 */
function getNewsCount()
{
    global $db;
    $count= $db->query("SELECT id from news")->rowCount();
    return $count;
}

function deleteNews($id)
{
    global $db;
    $id=$db->quote($id);
    $req=$db->query("DELETE FROM news WHERE id= $id");
    return $req->rowCount();
}

function getAllNews()
{
    global $db;
    try {
        $select=$db->query('SELECT * FROM news ORDER BY id DESC');
        $news=$select->fetchAll();
        return $news;
    } catch (PDOException $e) {
        return null;
    }
}
