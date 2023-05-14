
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
  <form method="POST" action={{ route('sendNotification.test',['id'=>$id,'RRC'=>1,'bookID'=>$bookID]) }}>
@csrf
    <div class="pt-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <p class="text-success">Swap the book with:</p>
                    <br/>
                    <label>
                        @foreach ( $books as $book)
                        <input type="checkbox" name={{$book->id}}>
                        {{ $book->title }}<br/>
                        @endforeach
                       
                    </label>

                    
                </div>
                <div class="pl-6 mb-2">
                    <button type="submit" class="btn btn-primary">Send</button>
                </div>

            </div>
        </div>
    </div>

  </form>
   
    </x-app-layout>
  
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
  </body>
</html>
