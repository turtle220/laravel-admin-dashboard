<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
class UsersController extends Controller
{
    // route name
    private $r = 'user';
    private $rs = 'users';  
    private $database = 'User';  


    public function __construct(){
        $this->database = app('App\\'.$this->database);
    }

    /**
        * Display a listing of the resource.
        *
        * @return \Illuminate\Http\Response
        */
    public function index(Request $request)
    {

        $perpage = !empty($request->perpage) ? $request->perpage : 20;
        $offset  = !empty($request->offset) ? $request->offset : 0;
        $search  = !empty($request->search) ? $request->search : false;
        $order   = !empty($request->order) ? $request->order : false;
        $api     = !empty($request->api) ? true : false;

        if($search){
            $search = explode('||' , $search)[0];
            $data = $this->database::limit($perpage)->offset($offset)->orderBy('updated_at' , 'DESC')
            ->where('name' , 'LIKE' , '%'.$search.'%')
            ->orWhere('email' , 'LIKE' , '%'.$search.'%')
            ->orWhere('created_at' , 'LIKE' , '%'.$search.'%')
            ->orWhere('updated_at' , 'LIKE' , '%'.$search.'%')
            ->get();
            $total = $this->database::orderBy('updated_at' , 'DESC')
            ->where('name' , 'LIKE' , '%'.$search.'%')
            ->orWhere('email' , 'LIKE' , '%'.$search.'%')
            ->orWhere('created_at' , 'LIKE' , '%'.$search.'%')
            ->orWhere('updated_at' , 'LIKE' , '%'.$search.'%')
            ->count();
        }elseif($order){
            $data = $this->database::limit($perpage)->offset($offset)->orderBy($order , $request->orderBy)->get();
            $total = $this->database::count();
        }else{
            $data = $this->database::limit($perpage)->offset($offset)->orderBy('updated_at' , 'DESC')->get();
            $total = $this->database::count();
        }

        $data = $data->map(function($item){
            $item->showUrl = route($this->r.'.show' , ['id' => $item->id]);
            $item->editUrl = route($this->r.'.edit' , ['id' => $item->id]);
            $item->deleteUrl = route($this->r.'.delete' , ['id' => $item->id]);
            return $item;
        });


        if(!$api){
            return view('admin.'.$this->rs.'.index')->with(['total' => $total , 'perpage' => $perpage ,
            'offset' => $offset , 'gw' => $data  , 'search' => $search]);
        }

        $currentRoute = \Route::currentRouteName();

        /**
            * all needed data for index
            */
        $all = [
            'gw' => $data ,
            'search' => [
                "searchUrl" => route($this->rs) ,
                "searchPhrase" => $search
            ],
            'urls'  => [
                'addUrl' => route($this->r.'.store')
            ],
            'pagination'  => [
                'total'   => $total ,
                'perpage' => $perpage ,
                'offset'  => $offset,
                'url'     => route($currentRoute)
            ],
        ];

        return response()->json($all , 200);

    }

    /**
        * Store a newly created resource in storage.
        *
        * @param  \Illuminate\Http\Request  $request
        * @return \Illuminate\Http\Response
        */
    public function store(Request $request)
    {   
        $validator = \Validator::make($request->all() , [
            'email' => 'required|unique:users',
            'password' => 'required',
            'name' => 'required',
            'role' => 'required',
        ]);
        

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()[0]] , 400);
        }

        $request->merge(['password' => bcrypt($request->password)]);
        /**
            * check if uniquer
            */
        $item = $this->database::create($request->all());
        $id = $item->id;
        $item->showUrl = route($this->r.'.show' , ['id' => $id]);
        $item->editUrl = route($this->r.'.edit' , ['id' => $id]);
        $item->updateUrl = route($this->r.'.update' , ['id' => $id]);
        $item->deleteUrl = route($this->r.'.delete' , ['id' => $id]);
        return response()->json($item , 200);
    }

    /**
        * get update form
        */
    public function edit($id){
        $item = $this->database::find($id);

        if($item->count() > 0){
            $item->showUrl = route($this->r.'.show' , ['id' => $id]);
            $item->editUrl = route($this->r.'.edit' , ['id' => $id]);
            $item->updateUrl = route($this->r.'.update' , ['id' => $id]);
            $item->deleteUrl = route($this->r.'.delete' , ['id' => $id]);
            return response()->json($item , 200);
        }else{
            return response()->json(['error' => 'User Not Found'] , 400);
        }
    }

    /**
        * update data
        */
    public function update($id , Request $request){
        $validator = \Validator::make($request->all() , [
            'email' => 'required',
            'name' => 'required',
            'role' => 'required',
        ]);
        
        

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()[0]] , 400);
        }   

        

        if(!empty($request->password)){
            $request->merge(['password' => bcrypt($request->password)]);
            $data = $request->only(['password' , 'name' , 'email' , 'role']);
        }else{
            $data = $request->only(['name' , 'email' , 'role']);
        }

        /**
        * check if uniquer
        */
        $item = $this->database::where('email' , '=' , $request->value)->get();

        if($item->count() < 2){
            $item = $this->database::find($id);
            $item->update($data);
            $item->showUrl = route($this->r.'.show' , ['id' => $id]);
            $item->editUrl = route($this->r.'.edit' , ['id' => $id]);
            $item->updateUrl = route($this->r.'.update' , ['id' => $id]);
            $item->deleteUrl = route($this->r.'.delete' , ['id' => $id]);
            return response()->json($item , 200);
        }

        return response()->json(['error' => 'User Already Exist'] , 400);
    }

    /**
        * remove vendor
        */
    public function destroy($id){
        $this->database::find($id)->delete();
        return response()->json(['success' => 'User Deleted Successfully'] , 200);
    }

    /**
     * export all 
     */
    public function exportAll(){
        $users = collect($this->database::all())->map(function($item){
            $pw = $item->getAuthPassword();
            $item = json_decode(json_encode($item) , true);
            $item['password'] = $pw; 
            return $item;
        });
        $data  = json_encode($users);

        $files = glob(public_path()."/upload/json/*"); // get all file names

        foreach($files as $file){ // iterate files
            if(is_file($file)){
                unlink($file); // delete file
            }
        }

        $file = time() . '_users.json';
        
        $destinationPath=public_path()."/upload/json/";
        
        // create the direction
        if (!is_dir($destinationPath)) {  mkdir($destinationPath,0777,true);  }
        
        \File::put($destinationPath.$file,$data);

        return response()->download($destinationPath.$file);
    }


    /**
     * import 
     */
    public function importJson(Request $request){
        $allData = json_decode(file_get_contents($request->file('file')->getRealPath()) , true);
        foreach($allData as $data){
            $checker = $this->database::where('email' , '=' , $data['email'])->get();

            if($checker->count() > 0){
                continue;
            }
            $this->database::create($data);
        }

        return redirect()->back();
    }

}
