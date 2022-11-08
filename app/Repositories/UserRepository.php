<?php

namespace App\Repositories;
use App\Models\User;
use File;
use DB;
use InvalidArgumentException;
use Image;
class UserRepository implements BaseRepositoryInterface{

    protected $model;
    private $path,$imageSizes;
    public function __construct(User $model){
        $this->model = $model;
        $this->path = public_path().'/images/users';
        $this->imageSizes = ['thumbnail','original'];
    }

    public function getData($order='DESC',$pagination=null){
        $data = $this->model->orderBy('created_at',$order);
        if($pagination == null){
            return $data->get();
        }else{
            return $data->paginate($pagination);
        }
    }

    public function getById($id){
        return $this->model->where('id',$id)->first();
    }

    public function store($data){
        // dd($data);
        DB::beginTransaction();
        try {
            $model              = new $this->model;
            $model->name        = $data['name'];
            $model->email       = $data['email'];
            if(isset($data['user_group'])){
                $model->role_id       = $data['user_group'];
            }
            $model->password    = bcrypt($data['password']);
            // Upload Image
            $model->save();
            
            if(isset($data['image'])){
                $model->image = $this->uploadImage($data['image'],$model->id);
                $model->save();
            }

            if(isset($data['user_group'])){
                $model->assignRole($model->role->name);
            }
        
            //code...
            DB::commit();
        } catch (\Exception $e) {
            //throw $th;
            DB::rollback();
            return response()->json([
                'success' => false,
                'code'    => $e->getCode(),
                'message' => $e->getMessage(),
                'errors'  => $e->getMessage()
            ]);
        }
        return response()->json([
            'success' => true,
            'code'    => 201,
            'message' => $model->name.' has been created successfully',
            'errors'  => null,
            'data'    => $model->fresh()
        ]);

    }

    public function update($data,$id){
        $model              = $this->getById($id);;
        DB::beginTransaction();
        try {
            $model->name        = $data['name'];
            $model->email       = $data['email'];
            if(isset($data['password'])){
                $model->password    = bcrypt($data['password']);
            }
            if(isset($data['user_group'])){
                $model->role_id       = $data['user_group'];
            }

            // Upload Image
            $model->update();
            
            if(isset($data['image'])){
                $this->deleteImage($model->id,$data['old_image']);
                $model->image = $this->uploadImage($data['image'],$model->id);
                $model->save();
            }

            if(isset($data['user_group'])){
                $model->syncRoles($model->role->name);
            }

            DB::commit();
        } catch (\Exception $e) {
            //throw $th;
            DB::rollback();
            return response()->json([
                'success' => false,
                'code'    => $e->getCode(),
                'message' => $e->getMessage(),
                'errors'  => $e->getMessage()
            ]);
        }
        return response()->json([
            'success' => true,
            'code'    => 200,
            'message' => $model->name.' has been updated successfully',
            'errors'  => null,
            'data'    => $model->fresh()
        ]);
    }

    public function destroy($id){
        $model = $this->getById($id);
        if($model->image !== 'default.png'){
            File::deleteDirectory(public_path('images/users/'.$id));
        }
        $model->delete();
        return response()->json([
            'success' => true,
            'code'    => 201,
            'message' => $model->name.' has been deleted successfully',
            'errors'  => null,
            'data'    => $model->fresh()
        ]);

    }

    public function table($request){

        $columns = array(
            0 =>'image',
            1 =>'name',
            2 => 'email',
            5 => 'created_at'
        );

        $totalData = $this->model->count();
        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value'))){
            $roles = $this->model->offset($start)
            ->limit($limit)
            ->orderBy($order,$dir)
            ->get();
        }else{
            $search = $request->input('search.value'); 
            $query =  $this->model->where('id','LIKE',"%{$search}%")
            ->orWhere('name', 'LIKE',"%{$search}%")
            ->orWhere('email','LIKE',"%{$search}%");
            $count = $query->count();
            $roles = $query->offset($start)
            ->limit($limit)
            ->orderBy($order,$dir)
            ->get();
            $totalFiltered = $count;
        }

        $data = array();

        if(!empty($roles)){
            $angka =$start+1;
            foreach ($roles as $u){
                $url_edit =  route('users.edit',$u->id);
                $url_delete = route('users.destroy',$u->id);
                $edit = '<a href="'.$url_edit.'" class="btn btn-sm btn-primary large-modal-show btn-edit" title="Edit : '.$u->name.'"><i class="fas fa-edit"></i> </a>';
                $delete = '<a href="'.$url_delete.'" class="btn btn-sm btn-danger sw-delete" title="'.$u->name.'"><i class="fas fa-trash-alt"></i> </a>';
                $nestedData['angka'] = $angka;
                $nestedData['id'] = $u->id;
                $nestedData['name'] = $u->name;
                $nestedData['email'] = $u->email;

                $img_url = ($u->image == 'default.png') ? asset('images/users/'.$u->image) : asset('images/users/'.$u->id.'/thumbnail/'.$u->image);
                $nestedData['image'] = '<img class="img-fluid" src="'. $img_url.'" width="100"/>';

                $nestedData['created_at'] = @$u->created_at->diffForHumans();

                $nestedData['user_group'] = $u->role->name;
                $nestedData['action'] = ($u->id !== 1) ?$edit." ".$delete :'';
                $data[] = $nestedData;

                $angka++;
            }
        }

        $json_data = array(
            "draw"            => intval($request->input('draw')),  
            "recordsTotal"    => intval($totalData),  
            "recordsFiltered" => intval($totalFiltered), 
            "data"            => $data   
            );

        return $json_data;

    }


    private function uploadImage($data,$user_id){

        // Validation Create Folder
        if(!File::exists($this->path.'/'.$user_id)) {
            File::makeDirectory($this->path.'/'.$user_id);
        }
        // Size
        foreach ($this->imageSizes  as $imgSize) {
            if(!File::exists($this->path.'/'.$user_id.'/'.$imgSize)) {
                File::makeDirectory($this->path.'/'.$user_id.'/'.$imgSize);
            }
        }


        $image = $data;
        $nameImage = time().'.'.$image->getClientOriginalExtension();

        // Thumbnail
        $thumbImage = Image::make($image->getRealPath())->resize(100, 100);
        $thumbPath = $this->path.'/'.$user_id.'/'.$this->imageSizes[0].'/' . $nameImage;
        $thumbImage = Image::make($thumbImage)->save($thumbPath);

        // Original Image
        $oriPath = $this->path.'/'.$user_id.'/'.$this->imageSizes[1].'/' . $nameImage;
        $oriImage = Image::make($image)->save($oriPath);

        return $nameImage;
    }

    private function deleteImage($user_id,$old_img){
        foreach ($this->imageSizes as $size) {
            File::delete($this->path.'/'.$user_id.'/'.$size.'/'.$old_img);            
        }

        return true;
    }

  

}
