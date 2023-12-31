<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{

    public function __construct()
    {
            $this->returnUrl = "/users";
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $users=User::all();
        return view("backend.users.index" ,["users" => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        return view("backend.users.insert_form");

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  UserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {

      /*  $name = $request->get("name");
                $email = $request->get("email");
                 $password = $request->get("password");
                $is_admin = $request->get("is_admin",0);
                $is_active = $request->get("is_active",0);

        */

        $user = new User();

 /*
$user->name = $name;
$user->email = $email;
$user->password = Hash::make($password);
$user->is_active = $is_active;
$user->is_admin = $is_admin;
  */

$data = $this->prepare($request,$user->getFillable());
$user->fill($data);
$user->save();

    return Redirect::to($this->returnUrl);



    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view("backend.users.update_form", ["user" =>$user]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UserRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserRequest $request, User $user)
    {
          /*  $name = $request->get("name");
                $email = $request->get("email");
                $is_admin = $request->get("is_admin",0);
                $is_active = $request->get("is_active",0);


$user->name = $name;
$user->email = $email;
$user->is_active = $is_active;
$user->is_admin = $is_admin;
          */


$data = $this->prepare($request,$user->getFillable());
$user->fill($data);


$user->save();
    return Redirect::to($this->returnUrl);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return JsonResponse
     */
    public function destroy(User $user): JsonResponse
    {

         $user->delete();
        // return Redirect::to("/users");

        return response()->json(["message" => "Done" , "id" => $user->user_id]);

    }



    /**
     * Display a listing of the pasword.
     *
     * @return \Illuminate\Contracts\View\View
     */

    public function passwordForm(User $user){
        return view("backend.users.password_form", ["user" => $user]);


    }




  public function changepassword(UserRequest $request, User $user): \Illuminate\Http\RedirectResponse
{
    $data = $this->preparePassword($request);
    $user->fill($data);
    $user->save();

    return Redirect::to($this->returnUrl);
}

protected function preparePassword(UserRequest $request): array
{
    return [
        'password' => $request->input('password'),
    ];
}

}
