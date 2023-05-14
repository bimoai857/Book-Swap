<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Notification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;
use App\Models\Book;
use App\Models\BookList;
use Stevebauman\Location\Facades\Location;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

   

    public function dashboard(){
      return view('dashboard');
    }

    public function mybooks(){
        $user_id=Auth()->user()['id'];
        $bookQuery=User::where('id',$user_id)->with('book')->get();
        $mybooks=$bookQuery[0]['book'];
        return view('mybooks',['mybooks'=>empty($mybooks)?[]:$mybooks]);
    }

    public function add(Request $request){
        $request->validate([
            'title' => ['required', 'string'],
            'author' => ['required', 'string'],
            'comment' => ['required', 'string'],
            'image' => ['required','image','mimes:jpeg,png,jpg,gif']
            
        ]);
        
       $file= $request->file('image');
       $filename=uniqid().'.'.$file->getClientOriginalExtension();

       $file->storeAs('public/images',$filename);

       $data=['user_id'=>Auth()->user()['id'],'author'=>$request->author,
                    'comment'=>$request->comment,'title'=>$request->title,
                        'image'=>$filename];

       Book::create($data);
       return redirect('mybooks');
    }
    
 public function search(Request $request){

    $request->validate([
        'search'=>['required','string']
    ]);

    $exploded=explode(' ',$request->search);
   
    foreach ($exploded as $key=>$value) {
        $books[$key]=Book::where('user_id','<>',auth()->user()->id)->where('title','like','%'.$value.'%')->with('User')->get();
       
    }
    function distance($lat1, $lon1, $lat2, $lon2) {
        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        return round($miles * 1.609344, 2); // convert miles to kilometers and return the result
    }
    $user_lat=Auth()->user()->latitude;
    $user_long=Auth()->user()->longitude;

    
    foreach ($books[0] as $key => $book) {
        # code...
        $users[$key]=$book['User'];
        $distance[$key]=distance($user_lat,$user_long,$users[$key]->latitude,$users[$key]->longitude);
        $users[$key]->distance=$distance[$key];
    }
    
    $users=collect($books[0])->sortBy('User.distance');
    return view('searchResult',['users'=>$users]);
 }
 
  public function swapView($id,$bookID){
 
    $books=Book::where('user_id',auth()->user()->id)->get();
 
    return view('swapView',['books'=>$books,'id'=>$id,'bookID'=>$bookID]);
  }


   /*
    
    1.This controller is responsible for processing data that can be rendered using Notification view.
        
    */
    public function notification(){

        // Returns user id.
        $user_id=Auth()->user()['id'];

        // Returns every notification linked to the above user id.
        // Along with data columns defined in notification model viz. userFrom, book, bookList, bookList.book
        // with() function queries out the the corresponding data associated with a particular relation.
        $notifications= Notification::where('to',$user_id)->where('notification_checked',0)->with(['userFrom','book','bookList','bookList.book'])->get();
        // return $notifications;
       if(!$notifications->isEmpty()){

        foreach ($notifications as $notification) {
            # code...
          
            if($notification['RRC']==3){
                $selected_books=$notification->notBooks;
                $bookList=Book::where('user_id',auth()->user()->id)->get();
                $books=$bookList->whereNotIn('id',$selected_books->pluck('book_id'));
    
            }
     
           
           if($notification['RRC']==2 ||$notification['RRC']==3 ||$notification['RRC']==6 ){
       
            $book_id=Notification::find($notification['not_from'])['swapbook_id'];
            $book_title=Book::find($book_id)['title'];
            $notification['book_title']=$book_title;
            $notification['book_id']=$book_id;
           }
        //  return $notifications;
        }
       }
//    return $notifications;
        return view('Notification',['notifications'=>$notifications,'books'=>empty($books)?[]:$books]);
}


  public function sendNotification(Request $request){
   
   
    if($request->RRC==1){

    $notification=Notification::create(['from'=>auth()->user()->id,'to'=>$request->id,'swapbook_id'=>$request->bookID,'notification_checked'=>0,'RRC'=>1]);

   
    $yesKeys = [];
    foreach ($request->all() as $key => $value) {
        if ($value === 'on') {
            $yesKeys[] = $key;
        }
    }
 
        foreach ($yesKeys as $key => $value) {
            # code...
            BookList::create(['notification_id'=>$notification['id'],'book_id'=>$yesKeys[$key]]);

        }
        return redirect('dashboard');
  }

  elseif($request->RRC==2){
  
    Notification::find($request->notID)->update(['notification_checked'=>1]);
    $notification=Notification::create(['from'=>auth()->user()->id,'to'=>$request->id,'swapbook_id'=>$request->selected_book,'notification_checked'=>0,'RRC'=>2,'not_from'=>$request->notID]);
    return redirect('dashboard');
  }

  elseif($request->RRC==3){
    Notification::find($request->notID)->update(['notification_checked'=>1]);
    $notification=Notification::create(['from'=>auth()->user()->id,'to'=>$request->id,'swapbook_id'=>null,'notification_checked'=>0,'RRC'=>3,'not_from'=>$request->notID]);
    return redirect('dashboard');
  }
  elseif($request->RRC==4){
 
    Notification::find($request->notID)->update(['notification_checked'=>1]);
    $notification=Notification::create(['from'=>auth()->user()->id,'to'=>$request->id,'swapbook_id'=>$request->bookID,'notification_checked'=>0,'RRC'=>4,'not_from'=>$request->notID]);
 
    $yesKeys = [];
 
    foreach ($request->all() as $key => $value) {
        if ($value === 'on') {
            $yesKeys[] = $key;
        }
    }
 
        foreach ($yesKeys as $key => $value) {
            # code...
            BookList::create(['notification_id'=>$notification['id'],'book_id'=>$yesKeys[$key]]);

        }
        return redirect('dashboard');
      
  }
  elseif($request->RRC==5){
    Notification::find($request->notID)->update(['notification_checked'=>1]);
    $notification=Notification::create(['from'=>auth()->user()->id,'to'=>$request->id,'swapbook_id'=>null,'notification_checked'=>0,'RRC'=>5]);
    return redirect('dashboard');
  }
  elseif($request->RRC==6){
    Notification::find($request->notID)->update(['notification_checked'=>1]);
    $notification=Notification::create(['from'=>auth()->user()->id,'to'=>$request->id,'swapbook_id'=>$request->selected_book,'notification_checked'=>0,'RRC'=>6,'not_from'=>$request->notID]);
    return redirect('dashboard');
  }
 
}
}
