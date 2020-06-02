<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prueba Excel</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <div class="card card-primary">
        <div class="card-body">

            @if ($message = Session::get('success'))
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{{ $message }}</strong>
            </div>
            <a href="{{ Session::get('url') }}" download>Descargar Excel!</a>
            @endif
    
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> There were some problems with your input.
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
    
            <form action="{{ route('file.upload.profesor') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
    
                    <div class="col-md-6">
                        <input type="file" name="profes" class="form-control">
                    </div>
    
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-success">Procesar</button>
                    </div>
    
                </div>
            </form>
    
        </div>
        </div>
    </div>
</body>
</html>