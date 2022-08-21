<?php

use App\Models\Article;

test('Article should work', function () {
    $article = new Article('Codelex', 'abc', 'https://codelex.io', 'https://static.lsm.lv/media/2022/06/large/1/i92n.jpg');

    expect($article->getTitle())->toBe('Codelex');
    expect($article->getDescription())->toBe('abc');
    expect($article->getUrl())->toBe('https://codelex.io');
    expect($article->getImage())->toBe('https://static.lsm.lv/media/2022/06/large/1/i92n.jpg');
});
