

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Books</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  </head>
  <body>
    <x-app-layout>
      <form method="POST" action={{ route('search') }}>
        @csrf
        
        <div class="input-group" style="margin-left: 38%; margin-top:10%">
          
          <input type="search" name="search" style="max-width: 400px;" class="form-control rounded"  placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
        </div>
        <button type="submit" class="btn btn-outline-primary" style="margin-left: 50%; margin-top:10px">search</button>
      <br/>
      <div style="margin-left: 45%; margin-top:10px" class="text-danger">
        @error('search')
        {{ $message }} 
      @enderror
      </div>
       
      </form>
     
    </x-app-layout>
   
  
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
  </body>
</html>
