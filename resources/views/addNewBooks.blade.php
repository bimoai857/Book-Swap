<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add New Books</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>
<body>
  <x-app-layout>
    <div class="container">
        <div class="row">
          <div class="col-md-4 mx-auto">
           
                <form action="/add" method="post"  enctype="multipart/form-data">
                  @csrf
                    
                    @if(session('emailSent'))
                    <h4 class="text-success">{{ session('emailSent') }}</h4>
                    @endif
                    <div class="mb-3 mt-3">
                        
                      <label  class="form-label ">Title</label>
                      <input type="text" name="title" class="form-control">@error('title')
                       <div class="text-danger">{{ $message }}</div> 
                      @enderror
                    </div>
                    <div class="mb-3 mt-3">
                        <label  class="form-label ">Author</label>
                        <input type="text" name="author" class="form-control">@error('author')
                        <div class="text-danger">{{ $message }}</div> 
                      @enderror
                      </div>
                      <div class="mb-3 mt-3">
                        <label  class="form-label ">Comment</label>
                        <textarea class="form-label" rows="5" cols="45" name='comment'></textarea>@error('comment')
                        <div class="text-danger">{{ $message }}</div> 
                      @enderror
                      </div>
                      <div class="form-group">
                        <label for="image">Choose Image</label>
                        <div class="input-group" style="margin-top: 5px">
                          <div class="custom-file">
                            <input type="file" name='image' class="custom-file-input" id="image" >@error('image')
                            <div class="text-danger">{{ $message }}</div> 
                          @enderror
                          </div>
                        </div>
                      </div>
                      
                    <button type="submit" class="btn btn-primary" style="width: 130px ;margin-top:15px">Add</button>

                    <div class="mt-2">
                  </div>
            
                  </form>
            
          </div>
        </div>
      </div>
    </x-app-layout>
   
   
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>
</html>