<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Research Brisk</title>
</head>
<body>
    <h4>Hello and Welcome to Research Brisk</h4>
    <p>You have received a new Enquiry,</p> <hr>

    <div>
    <h5>About</h5>
    <p>{{ $request->message }}</p>
    <p>By: <i> {{ $request->email }} </i></p>
    </div>



</body>
</html>