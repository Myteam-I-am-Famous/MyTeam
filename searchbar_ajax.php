<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

include 'includes/functions.php';



function searchUsers($query)
{
    $result = [];
    $users = getDataFrom('users');

    foreach ($users as $user) {
        if (
            strpos(strtolower($user['first_name']), strtolower($query)) !== false
            || strpos(strtolower($user['last_name']), strtolower($query)) !== false
        )
            array_push($result, $user);
    }

    return $result;
}

function searchAthlete($query)
{
    $result = [];
    $athletes = getDataFrom('basketball_cards');

    foreach ($athletes as $athlete) {
        if (
            strpos(strtolower($athlete['full_name']), strtolower($query)) !== false
            || strpos(strtolower($athlete['position']), strtolower($query)) !== false
            || strpos(strtolower($athlete['team']), strtolower($query)) !== false
            || strpos(strtolower($athlete['jersey_number']), strtolower($query)) !== false
            || strpos(strtolower($athlete['team_abv']), strtolower($query)) !== false
        )
            array_push($result, $athlete);
    }
    return $result;
}

function searchForums($query)
{
    $result = [];
    $forums = getDataFrom('forum_subjects');

    foreach ($forums as $forum) {
        if (
            strpos(strtolower($forum['title']), strtolower($query)) !== false
            || strpos(strtolower($forum['content']), strtolower($query)) !== false
            || strpos(strtolower($forum['id']), strtolower($query)) !== false
            || strpos(strtolower($forum['category']), strtolower($query)) !== false
        )
            array_push($result, $forum);
    }
    return $result;
}

function searchArticles($query)
{
    $result = [];
    $articles = getDataFrom('articles');

    foreach ($articles as $article) {
        if (
            strpos(strtolower($article['title']), strtolower($query)) !== false
            || strpos(strtolower($article['content']), strtolower($query)) !== false
            || strpos(strtolower($article['caption']), strtolower($query)) !== false
        )
            array_push($result, $article);
    }
    return $result;
}



if (isset($_POST['query'])) {


    $athletes = searchAthlete($_POST['query']);
    $users = searchUsers($_POST['query']);
    $forums = searchForums($_POST['query']);
    $articles = searchArticles($_POST['query']);


    echo json_encode([
        'status' => true,
        'athletes' => $athletes,
        'users' => $users,
        'forums' => $forums,
        'articles' => $articles
    ]);
}

