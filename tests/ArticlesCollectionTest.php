<?php

use App\Models\Article;
use App\Models\ArticlesCollection;

test('Articles collection should work', function () {

    $collection = new ArticlesCollection([
        new Article('Codelex', 'codelex', 'https://codelex.io', 'https://static.lsm.lv/media/2022/06/large/1/i92n.jpg'),
        new Article('Google', 'google', 'https://google.com', 'https://static.lsm.lv/media/2022/06/large/1/i92n.jpg'),
        new Article('Wikipedia', 'wikipedia', 'https://wikipedia.lv', 'https://static.lsm.lv/media/2022/06/large/1/i92n.jpg')
    ]);

    expect(count($collection->getAll()))->toBe(3);
    expect($collection->getAll()[1]->getTitle())->toBe('Google');
    expect($collection->getAll()[1]->getImage())->toBe('https://static.lsm.lv/media/2022/06/large/1/i92n.jpg');
});