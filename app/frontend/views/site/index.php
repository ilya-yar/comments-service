<?php

/** @var yii\web\View $this */

$this->title = 'Comments service';
?>
<div class="site-index">

    <div class="body-content">

        <div class="row">
            <div class="container-fluid py-5 text-left">
                <h1 class="display-4">Пример работы с API</h1>
            </div>

            <p><b>Список комментариев: </b>http://api.testtask.loc/comments</p>
            <p><b>Просмотр комментария: </b>http://api.testtask.loc/comments/1</p>
            <p><b>Сортировка и фильтрация: </b>http://api.testtask.loc/comments?subject=subject1&sort=updated_at</p>
            <p><b>Создание комментария через терминал с использованием CURL: </b></p>
            <blockquote>
            <pre><code>
curl  -d '{"subject":"api_subject_1", "subject_id":4, "username":"ilya", "comment":"api comment"}' -H "Content-Type: application/json" -X POST http://api.testtask.loc/comments
            </code></pre>
            </blockquote>
        </div>
    </div>
</div>