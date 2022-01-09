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
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Movie App</title>
        <meta name="description" content="">
        <meta name="author" content="fadilxcoder">
        <meta property="og:title" content="">
        <meta property="og:type" content="website">
        <meta property="og:url" content="">
        <meta property="og:description" content="">
        <meta property="og:image" content="image.png">
        <link rel="icon" href="favicon.png">
        <link rel="stylesheet" href="styles.css?v=1.0">
    </head>
    <body>
        <main>
            <h1><?php echo $settings['movie_title']; ?></h1>
            <video id="video-settings" controls>
                <source src="<?php echo $settings['movie_repo'] . $settings['movie_mp4'] ; ?>" type="video/mp4">
                <track label="English" kind="subtitles" srclang="en" src="<?php echo $settings['movie_repo'] . $settings['movie_subs'] ; ?>" default>
                Your browser does not support the video tag.
            </video>
        </main>
        <script src="scripts.js?v=1.0"></script>
    </body>
</html>