<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rental;
use App\Helpers\formatAPI;
use Exception;

class RentalController extends Controller
{
    public function index(Request $request)
    {
        $data = Rental::all();
        if ($request->query('search_supir')){
            $search = $request->query('search_supir');

            $data = Rental::where('supir', $search)->get();
            if($request->query('limit')) {
                $limit = $request->query('limit');

                $data = Rental::where('supir', $search)->limit($limit)->get();
            }
        }
        if($data){
            return formatAPI::createAPI(200,'Success',$data);
        }else{
            return formatAPI::createAPI(400,'Failed');
        }
    }

    public function store(Request $request)
    {
        try {
            $rental = Rental::create([
                'nama' => $request->nama,
                'alamat' => $request->alamat,
                'type' => $request->type,
                'waktu_jam' => $request->waktu_jam,
                'jam_mulai' => $request->jam_mulai,
                'supir' => $request->supir,
                'total_harga' => $request->waktu_jam * 150000,
                'tempat_tujuan' => null,
                'jam_selesai' =>null,
                'status' => "proses"
            ]);

            $data = Rental::where('id', '=', $rental->id)->GET();

            if($data) {
                return formatAPI::createAPI(200, 'Success', $data);
            } else {
                return formatAPI::createAPI(400, 'error');
            }

        } catch (Exception $error) {
            return formatAPI::createAPI(400, 'error', $error);
        }
    }


    public function show($id)
    {
        try{
            $data = Rental::where('id', '=', $id)->first();

            if($data){
                return formatAPI::createAPI(200,'success', $data);
            }else{
                return formatAPI::createAPI(400,'failed');
            }
        }catch(Exception $error){
            return formatAPI::createAPI(400,'failed', $error->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $rental = Rental::where('id', '=', $id)->first();
            $riwayat_perjalanan = "Dimulai jam $rental->jam_mulai di $rental->alamat dan selesai pada jam $request->jam_selesai dengan titik akhir di $request->tempat_tujuan";
            Rental::findorFail($id)->update([
                'jam_selesai' => $request->jam_selesai,
                'tempat_tujuan' => $request->tempat_tujuan,
                'riwayat_perjalanan' => $riwayat_perjalanan,
                'status' => 'selesai'
            ]);

            $data = Rental::where('id', '=', $rental->id)->first();
    
            if ($data) {
                return formatAPI::createAPI(200, 'Success', $data);
            } else {
                return formatAPI::createAPI(400, 'Failed');
            }
        } catch (Exception $error) {
            return formatAPI::createAPI(400, 'Failed', $error->getMessage());
        }
    }

    public function destroy($id)
    {
        try{
            $rental = Rental::findorfail($id);
            $data = $rental->delete();
            if($data){
                return formatAPI::createAPI(200,'Success', "Berhasil menghapus");
            }else{
                return formatAPI::createAPI(400,'Failed');
            }
        }catch(Exception $error){
            return formatAPI::createAPI(400,'Failed',$error->getMessage());
        }
    }

    //? Trash function

    public function getTrash()
    {
        try {
            $data= Rental::onlyTrashed()->get(); 

            if($data){
                return formatAPI::createAPI(200, 'berhasil', $data);
            }else{
                return formatAPI::createAPI(400, 'Failed');
            }
        }catch(Exception $error){
            return formatAPI::createAPI(400, 'gagal', $error);

        }
    }

    public function restore($id)
    {
        try{
            $data = Rental::onlyTrashed()->findorfail($id);
            $data = $data->restore();
            $data = Rental::where('id', $id)->get();

            if($data){
                return formatAPI::createAPI(200, 'berhasil', $data);
            }else{
                return formatAPI::createAPI(400, 'Failed');
            }
        }catch(Exception $error){
            return formatAPI::createAPI(400, 'gagal', $error);

        }
    }

    public function deleteTrash($id)
    {
        try{
            $data = Rental::onlyTrashed()->findorfail($id);
            $data = $data->forceDelete();

            if($data){
                return formatAPI::createAPI(200, 'berhasil', $data);
            }else{
                return formatAPI::createAPI(400, 'Failed');
            }
        }catch(Exception $error){
            return formatAPI::createAPI(400, 'gagal', $error);

        }
    }
}