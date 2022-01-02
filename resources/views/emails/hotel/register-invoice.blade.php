<!DOCTYPE html>
<html>
<head>
    <title>Cloud Travel</title>
</head>
<body>
    <p>Hi {{ $LeaderName }}</p>
    <!-- <h1>Body Text Here</h1> -->
    @if($passwords!='')
    <h1> user id: {{ $email }}</h1>
    <p>password : {{ $passwords }}</p>
    @endif
    <p>Thanks </p>
    <p>Cloud Travel </p>
</body>
</html>