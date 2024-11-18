<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
</head>
<body>
        <div>
        <h2>Morse Code Converter</h2>
        <p>Input Morse code data with the "data" URL parameter, e.g. ?data=whatever</p>

        <?php
        $user_input = $_GET["data"];
        if ($user_input == null) {
                $user_input = "";
        }
        // replace everything except negated characters
        // only keep lowercase letters, numbers and spaces
        $user_input = preg_replace("/[^a-z0-9 ]+/", "", $user_input);
        $input_length = strlen($user_input);

        echo $user_input;
        echo "[";

        // start Morse code with LED off
        $converted_data = "0";

        for($i = 0; $i < $input_length; $i++) {
                // international morse code
                // each letter is followed by three zeros
                // this creates three units of space between letters in the same word
                switch($user_input[$i]) {
                        case 'a': // .-
                                $converted_data = $converted_data."10111000";
                                break;
                        case 'b': // -...
                                $converted_data = $converted_data."111010101000";
                                break;
                        case 'c': // -.-.
                                $converted_data = $converted_data."11101011101000";
                                break;
                        case 'd': // -..
                                $converted_data = $converted_data."1110101000";
                                break;
                        case 'e': // .
                                $converted_data = $converted_data."1000";
                                break;
                        case 'f': // ..-.
                                $converted_data = $converted_data."101011101000";
                                break;
                        case 'g': // --.
                                $converted_data = $converted_data."111011101000";
                                break;
                        case 'h': // ....
                                $converted_data = $converted_data."1010101000";
                                break;
                        case 'i': // ..
                                $converted_data = $converted_data."101000";
                                break;
                        case 'j': // .---
                                $converted_data = $converted_data."1011101110111000";
                                break;
                        case 'k': // -.-
                                $converted_data = $converted_data."111010111000";
                                break;
                        case 'l': // .-..
                                $converted_data = $converted_data."101110101000";
                                break;
                        case 'm': // --
                                $converted_data = $converted_data."1110111000";
                                break;
                        case 'n': // -.
                                $converted_data = $converted_data."11101000";
                                break;
                        case 'o': // ---
                                $converted_data = $converted_data."11101110111000";
                                break;
                        case 'p': // .--.
                                $converted_data = $converted_data."10111011101000";
                                break;
                        case 'q': // --.-
                                $converted_data = $converted_data."1110111010111000";
                                break;
                        case 'r': // .-.
                                $converted_data = $converted_data."1011101000";
                                break;
                        case 's': // ...
                                $converted_data = $converted_data."10101000";
                                break;
                        case 't': // -
                                $converted_data = $converted_data."111000";
                                break;
                        case 'u': // ..-
                                $converted_data = $converted_data."1010111000";
                                break;
                        case 'v': // ...-
                                $converted_data = $converted_data."101010111000";
                                break;
                        case 'w': // .--
                                $converted_data = $converted_data."101110111000";
                                break;
                        case 'x': // -..-
                                $converted_data = $converted_data."11101010111000";
                                break;
                        case 'y': // -.--
                                $converted_data = $converted_data."1110101110111000";
                                break;
                        case 'z': // --..
                                $converted_data = $converted_data."11101110101000";
                                break;
                        case ' ': // just one zero for nothing
                                // three zeros come after each regular letter
                                // adding four zeros creates a seven unit gap
                                $converted_data = $converted_data."0000";
								break;
                        default: // default to 'a'
                                $converted_data = $converted_data."10111000";
                }
        }
        
        echo $converted_data . "]";
        
        $endpoint = "amazonaws.com";
        $username = "username";
        $password = "password";
        $dbname = "historic_morse_code_requests";
        
        // create connection
        $conn = mysqli_connect($endpoint, $username, $password, $dbname);
        // check connection
        if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
        }
        
        if ($user_input != "") {
            $sql = "INSERT INTO requests (request, result) VALUES (\"".$user_input."\", \"".$converted_data."\")";
        }
        $result = mysqli_query($conn, $sql);

        $sql = "SELECT * FROM requests ORDER BY date DESC";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
                echo "<br><br><table border=\"1px solid black\"><tr><th>Request</th><th>Result</th><th>Date</th></tr>";
                while($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>".$row["request"]."</td>";
                        echo "<td>".$row["result"]."</td>";
                        echo "<td>".$row["date"]."</td>";
                        echo "</tr>";
                }
                echo "</table>";
        }
		else {
                echo "No data";
        }
        ?>
        </div>
</body>
</html>