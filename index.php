<?php
    $valid_paths = array(
        'foo',
        'foo/new',
        'foo/bar/foo',
        'foo/$',
        'foo/$/bar',
        'foo/$/bar/$'
    );

    $request_url = (isset($_SERVER['REQUEST_URI'])) ? $_SERVER['REQUEST_URI'] : '';
    $script_url  = (isset($_SERVER['PHP_SELF'])) ? $_SERVER['PHP_SELF'] : '';
    
    if($request_url != $script_url) {
        $url = trim(preg_replace('/'. str_replace('/', '\/', str_replace('index.php', '', $script_url)) .'/', '', $request_url, 1), '');
    }
    $url = preg_replace('/\?.*/', '', $url); // Strip query string
    $url = rtrim($url, '/');

    if($url) {
        $url_parts = explode('/', $url);
        $url_parts_count = count($url_parts);

        if(in_array($url, $valid_paths) === true) {
            echo "<p>Valid path</p>";
        } else {
            $array_key_count = 0;
            $evens_count = 1;

            while ($evens_count <= $url_parts_count) {
                if($evens_count % 2 == 0) {
                    $url_parts[$array_key_count] = '$';    
                }
                $array_key_count++;
                $evens_count++;
            }

            $url = implode('/', $url_parts);

            if(in_array($url, $valid_paths) === true) {
                echo "<p>Valid path</p>";
            } else {
                echo "<p>Invalid path</p>";
            }
        }

    } else {
        echo "<p>Display homepage</p>";
    }

    //Create test paths so Selenium can click on them for testing
    $test_paths = array(
        'foo',
        'foo/new',
        'foo/bar/foo',
        'foo/1',
        'foo/1/bar/',
        'foo/1/bar/1'
    );

    foreach ($test_paths as $test_path) {
        echo '<a href="/'.$test_path.'/">'.$test_path.'</a><br>';
    }
?>