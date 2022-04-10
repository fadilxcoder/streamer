```
<?php
    ### Settings ###

    const REPO = './movies/';

    $movies = [
        'the-new-mutants' => [
            'movie_repo' => 'the-new-mutants',
            'movie_mp4' => 'movie.mp4',
            'movie_subs' => 'subs.vtt', # Should be in .vtt format
            'movie_title' => 'The New Mutants'
        ],
        'black-widow' => [
            'movie_repo' => 'black-widow',
            'movie_mp4' => 'movie.mp4',
            'movie_subs' => 'subs.vtt',
            'movie_title' => 'Black Widow'
        ]
    ];

    ### Current movie to expose ###

    $settings = $movies['the-new-mutants']; <- Movie to stream
    // $settings = $movies['black-widow'];

    ### Settings ###
?>
```

- https://videojs.com/ (Library for player GUI)
- Change setting for movie
- Launch in-built php server : `php -S 127.0.0.1:2121` & Launch tunnel : `lt --port 2121 --subdomain movie-app`
- **OR** `lt --port 80 --local-host movies.app.local --subdomain movies-app`
- **OR** `ngrok start app.movies`