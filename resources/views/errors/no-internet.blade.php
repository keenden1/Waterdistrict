<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>No Internet Connection</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            background: linear-gradient(5deg, #0000FF, #1E3A8A, #E6E6FA);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: lightgrey;
        }

        h1 {
            font-size: 2.5em;
            margin-bottom: 0.5em;
        }

        p {
            font-size: 1.2em;
            max-width: 400px;
        }

        @media (max-width: 600px) {
            h1 {
                font-size: 2em;
            }

            p {
                font-size: 1em;
            }
        }
    </style>
</head>
<body>
    <h1>Oops! Unable to connect to the internet.</h1>
    <p>Please check your network connection and try again.</p>
</body>
</html>
