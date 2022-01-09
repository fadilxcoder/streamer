```
<?php
    ### Settings ###

    $settings = [
        'movie_repo' => './the-new-mutants/',
        'movie_mp4' => 'movie.mp4',
        'movie_subs' => 'subs.vtt', # Should be in .vtt format
        'movie_title' => 'The New Mutants'
    ];

    ### Settings ###
?>
```

- Change setting for movie
- Launch in-built php server : `php -S 127.0.0.1:2121`
- Lauch tunnel : `lt --port 2121 --subdomain movie-app`
- **OR** `lt --port 80 --local-host movies.app.local --subdomain movies-app`
- **OR** `ngrok start app.movies`