
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
    
      @if(count($notifications) > 0)
      @foreach ($notifications as $notification)

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">


                    @if ($notification['RRC']==1)
                    You have received a notification from 
                    <div style="color: #E4A11B ;display: inline-block">{{ $notification['userFrom']['name']}} </div>
                    to swap 
                    <div style="color: #3B71CA ;display: inline-block">{{ $notification['book']['title'] }}</div> with <br/>
                      <br/>
                      <form method="POST" action={{ route('sendNotification',['id'=>$notification['from'],'RRC'=>2,'notID'=>$notification['id']]) }}>
                        @csrf
            
                        <label>
                          @foreach ( $notification['bookList'] as $not)
                          <div style="color: #14A44D;"><input type="radio"  name="selected_book" value={{ $not['Book']['id'] }}>
                            {{ $not['Book']['title'] }}<br/></div>
                          @endforeach
                      </label>
                      <br/>
                      <div style='margin-top: 20px;'>
                        <button type="submit" class="btn btn-success" >Accept</button>

                      </div>
                    </form>

                      <div>
                      <form method="POST" action={{ route('sendNotification',['id'=>$notification['from'],'RRC'=>3,'notID'=>$notification['id']]) }}>
                        @csrf
                        <div style="margin-top:5px;">
                        <button type="submit" class="btn btn-primary" >More Books</button>
                        </div>
                      </form>
                      <form method="POST" action={{ route('sendNotification',['id'=>$notification['from'],'RRC'=>5,'notID'=>$notification['id']])}}>
                        @csrf
                        <div style="margin-top:5px;">
                          <button type="submit" class="btn btn-danger" >Reject</button>

                        </div>
                      </form>
                    </div>
                   

                    @elseif ($notification['RRC']==2)
                    {{ $notification['userFrom']['name']}} has accepted to swap his book <div style="color: #14A44D ;display: inline-block">{{ $notification['book_title'] }}</div> with your
                    <div style="color: #14A44D ;display: inline-block">{{ $notification['book']['title'] }}.</div>
                    
                    @elseif ($notification['RRC']==3)
                    {{ $notification['userFrom']['name']}} wants to see other books.
                   <div>You wanted:<div style="color: #14A44D ;display: inline-block;">{{ $notification['book_title'] }}.</div></div> 

                   <div>
                    <form method="POST" action={{ route('sendNotification',['id'=>$notification['from'],'RRC'=>4,'bookID'=>$notification['book_id'],'notID'=>$notification['id']]) }}>
                      @csrf
                      <label>
                        <div style="margin-top:5px;">
                          @foreach ( $books as $book)
                          <div style="color: #14A44D;"><input type="checkbox" name={{ $book->id }}>
                            {{ $book['title'] }}<br/></div>
                          @endforeach
                        </div>
                       
                        </label>
                        <div style="margin-top: 10px;">
                          <button type="submit" class="btn btn-success" >Send</button>

                        </div>
                      </div>
                    </form> 
                    <div style="margin-top: 10px">
                      <form method="POST" action={{ route('sendNotification',['id'=>$notification['from'],'RRC'=>5,'notID'=>$notification['id']])}}>
                        @csrf
                        <button type="submit" class="btn btn-danger" >Reject</button>
                      </form>
                 
                    </div>
                     

                    @elseif ($notification['RRC']==4)
                    <div style="color: #14A44D; display:inline-block">{{ $notification['userFrom']['name']}}</div> has provided a list of other books to swap with your book <div style="color: #14A44D ;display: inline-block">{{ $notification['book']['title'] }}</div>
                    <form method="POST" action={{ route('sendNotification',['id'=>$notification['from'],'RRC'=>6,'notID'=>$notification['id']]) }}>
                      @csrf
                      <label>
                        @foreach ( $notification['bookList'] as $not)
                        <div style="color: #14A44D;"><input type="radio"  name="selected_book" value={{ $not['Book']['id'] }}>
                          {{ $not['Book']['title'] }}<br/></div>
                        @endforeach
                    </label>
                    <br/>
                    <div style="margin-top: 10px">
                      <button type="submit" class="btn btn-success" >Accept</button>

                    </div>

                    <div style="margin-top: 5px">
                    </form>
                    <form method="POST" action={{ route('sendNotification',['id'=>$notification['from'],'RRC'=>5,'notID'=>$notification['id']])}}>
                      @csrf
                      <button type="submit" class="btn btn-danger" >Reject</button>
                    </form>
                    </div>
                 


                    @elseif ($notification['RRC']==5)
                    {{ $notification['userFrom']['name']}} has denied to show other books.
                   
                    @elseif ($notification['RRC']==6)
                    {{ $notification['userFrom']['name']}} has accepted to swap your <div style="color: #14A44D ;display: inline-block">{{ $notification['book']['title'] }}</div> with 
                    his book <div style="color: #14A44D ;display: inline-block">{{ $notification['book_title'] }}.</div>

                    @endif
                    
                </div>
            </div>
        </div>
       
    </div>
    @endforeach 
    @else
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
              <div class="p-6 text-gray-900 dark:text-gray-100">
    <p>No notifications to show.</p>
              </div>
          </div>
        </div>
    </div>
@endif
    </x-app-layout>
 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
  </body>
</html>
