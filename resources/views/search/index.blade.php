<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Thasadith:700" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <style>
        html {
            height: 100%;
        }

        section {
            background: url(img/72859.jpg) no-repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
            overflow-y: auto;
            height: 100%;
        }

        body {
            height: 100%;
            background-color: transparent;
        }

        input {
            outline: none;
        }

        .search-field {
            width: 100%;
            height: 50px;
            font-size: 24px;
            padding: 0 15px;
            background-color: #00000069;
            border: 1px solid #313131;
            border-radius: 3px;
            color: white;
        }

        .result {
            background-color: #000000c9;
            border: 1px solid #313131;
            border-radius: 3px;
            color: white;
        }

        hr {
            border: none;
            color: #f8f9fa12;
            background-color: #f8f9fa12;
            height: 1px;
            margin: 5px;
        }


        html * {
            font-family: 'Thasadith', sans-serif;
        }
    </style>
</head>
<body>


<section class="pb-5 text-center pt-5">
    <div class=" container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <h1 class="jumbotron-heading">Search songs</h1>
                <form>
                    <input class="search-field" name="search" value="{{$text ?? ''}}" type="text">
                </form>
            </div>
        </div>

        @if(isset($songs))
            <div class="mt-5">
                <div class="col-md-8 offset-md-2 result p-2">

                    @foreach($songs as $song)
                        <div class="row p-1">
                            <div class="col-md-3">
                                <img width="100"
                                     src="{{$song->album->getCover()}}">
                            </div>
                            <div class="col-md-6 text-left">
                                <div>
                                    Band: {{$song->album->band->name}}
                                </div>
                                <div>
                                    Album: {{$song->album->name}}
                                </div>
                                <div>
                                    Year: {{$song->album->year}}
                                </div>
                                <div>
                                    Song: {{$song->name}}
                                </div>
                            </div>
                            <div class="col-md-3" style="line-height: 100px">
                                <a href="http://www.heavy-music.ru/{{$song->download_url}}" class="btn btn-dark">Download</a>
                            </div>
                        </div>
                        <hr>
                    @endforeach
                    @if(!$songs->count())
                        No result found
                    @endif
                </div>
            </div>
        @endif
    </div>

</section>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.bundle.min.js"
        integrity="sha384-zDnhMsjVZfS3hiP7oCBRmfjkQC4fzxVxFhBx8Hkz2aZX8gEvA/jsP3eXRCvzTofP"
        crossorigin="anonymous"></script>
</body>
</html>