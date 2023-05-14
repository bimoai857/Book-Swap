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
  @foreach ($users as $key=>$user)
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
               
                 @if ($user==null)
                    <div style="color: #14A44D">Not Found</div>
                   @else
                   Name:<div style="color: #14A44D">{{ $user['User']->name}}</div><br/>
                   Distance apart:<div style="color: #14A44D">{{ $user['User']->distance}}km</div><br/>
                   Name of the Book:<div style="color: #14A44D">{{ $user->title}}</div><br/>
                   Comment about the book:<div style="color: #14A44D">{{ $user->comment}}</div>
                   <button type="button" class="btn btn-primary" style="margin-left: 85%"><a href={{ route('swapView',['id'=>$user['User']->id,'bookID'=>$user->id]) }}>Swap Request</a></button>
                   
                 @endif
                </div>
            </div>
        </div>
    </div>
    @endforeach

    </x-app-layout>
  
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
  </body>
</html>