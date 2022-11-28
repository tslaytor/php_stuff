<html>
    <head>
        <title>PHP Test</title>
    </head>
<body>
    <?php
        echo '<p>Hello World</p>'; 

        $num = 65;
        $isit = true;
        $word = 'wordy';
        $float = 5.34;

        echo $num. '<br>'. $isit. '<br>'; 
        echo $word .'<br>'. $float. '<br>';
        echo PHP_INT_MAX. '<br>';

        $string = "    hello world     ";
        $string2 = "hello";
        echo ucfirst($string). '<br>' . ucfirst($string2). '<br>';
        echo strpos($string, 'world') . '<br>';
        echo substr($string, 8, 6). '<br>';
        echo str_replace('World', "php", $string). '<br>';
        echo str_ireplace('World', "php", $string). '<br>'.'<br>';

        $longText = "Hello, here is <b>some</b> text
                        with line breaks
                        if I want to <b>preserve</b> these breaks in html
                        I can use the function below";

        echo nl2br($longText). '<br>'.'<br>';
        echo htmlentities($longText). '<br>'.'<br>';
        echo nl2br(htmlentities($longText)). '<br>'.'<br>';
        echo htmlentities(nl2br($longText)). '<br>'.'<br>';

        var_dump(htmlentities($longText));
        
        echo '<br>'.'<br>';

        function sum(...$nums){
            $count = 0;
            foreach($nums as $num){
                $count += $num;
            }
            return $count;
        }

        // echo sum(1, 4, 5, 6, 7, 800, 9);

        function sum1line(...$nums){
            return array_reduce($nums, fn($carry, $n) => $carry + $n);
        };

        // echo sum1line(1, 2, 3, 4). '<br>' . '<br>';
        
        $dateString = 'February 4 2020 12:45:35';

        $parsedDate = date_parse_from_format('F j Y H:i:s', $dateString);

        echo $parsedDate['year'].' '.$parsedDate['month'].' '.$parsedDate['day'];

        echo '<pre>';
        var_dump($parsedDate);
        echo '</pre>';

        // $dateString = 'February 4 2020 12:45:35';

        // $parsedDate = date_parse_from_format('F j Y H:i:s', $dateString);
        // echo '<pre>';
        // var_dump($parsedDate);
        // echo '</pre>';


    ?> 
 </body>
</html>