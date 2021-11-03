<html>
 <head>
  <title>PHP Test</title>
 </head>
 <body>
    <?php
     try {
        // connect to mongodb
        $manager = new MongoDB\Driver\Manager("mongodb://mongo:27017");
        $command = new MongoDB\Driver\Command(['ping' => 1]);

        try {
            $cursor = $manager->executeCommand('admin', $command);
        } catch(MongoDB\Driver\Exception $e) {
            echo $e->getMessage(), "\n";
            exit;
        }

        /* The ping command returns a single result document, so we need to access the
        * first result in the cursor. */
        $response = $cursor->toArray()[0];

        var_dump($response);
        echo "Sent the request to the mongo db", "\n";
    } catch(Exception $e) {
        echo "Caught exception", $e->getMessage(), "\n";
    }
    ?>
 </body>
</html>

