<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Research Brisk</title>
</head>
<body>
    <h4>Hello and Welcome to Research Brisk  {{ $request->email }}</h4>
    <p>We have received your request on this: </p> 
    <div>
        <p><b>Title: </b> {{ $request->title }} </p>
        <p><b>Pages: </b> {{ $request->pages }} </p>
        <p><b>Due On: </b> {{ $request->duedate }} </p>
        <p><b>Description: </b> {{ $request->description }} </p>
    </div>
    <p> will get back to you for more info</p>
</body>
</html>