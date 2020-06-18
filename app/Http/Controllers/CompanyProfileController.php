<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CompanyProfile;
use DB;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\CustomExceptions;
class CompanyProfileController extends Controller
{
  private $customExceptions;

  public function __construct(CustomExceptions $customExceptions)
  {
      $this->customExceptions = $customExceptions;
  }
    public function newCompany(){
        $user = Auth::user();
        $userFname=$user->empfirstname;
        $userLname=$user->emplastname;
        $userImage=$user->image;
      return view('company.addnewcompany',compact('userFname','userLname','userImage'));
    }
    // public function newCompany(){
    //     $allCompanies = CompanyProfile::All();

    //     return response()->json([
    //         'allCompanies' => $allCompanies
    //     ]);
    // }
    public function addNewCompany(Request $request){
      try{
        $company=$this->customExceptions->addCompany($request);
      }
      catch(\PDOException $e){
        return back()->withError($e->getMessage())->withInput();
      }
      $filename='CaterU.png';
        $newCompany= new CompanyProfile();
        if($request->file('image')==NULL){
        $newCompany->companyname = $request->companyname;
        $newCompany->address = $request->address;
        $newCompany->tin = $request->tin;
        $newCompany->contactNo = $request->contactNo;
        $newCompany->email = $request->email;
        $newCompany->logo=$filename;
         $newCompany->save();
        }
        else{
            $filename = $request->file('image')->getClientOriginalName();
    
            $path = public_path().'/company/company_images';
            $request->file('image')->move($path, $filename);
            $newCompany->companyname = $request->companyname;
            $newCompany->address = $request->address;
            $newCompany->tin = $request->tin;
            $newCompany->contactNo = $request->contactNo;
            $newCompany->email = $request->email;
            $newCompany->logo=$filename;
             $newCompany->save();
        }
        return redirect('/company/companylist')->with('success','Company Successfully Added');
    }
    public function companyList(){
        $lists = CompanyProfile::all();
        $user = Auth::user();
        $userFname=$user->empfirstname;
        $userLname=$user->emplastname;
        $userImage=$user->image;
        return view('company.companylist',compact('lists','userFname','userLname','userImage'));
    }
    public function updateCompany($compid){
      $user = Auth::user();
      $userFname=$user->empfirstname;
      $userLname=$user->emplastname;
      $userImage=$user->image;
      $companyRecord = CompanyProfile::find($compid); 
      return view('company.updateCompany', compact('userImage','userFname','userLname','companyRecord'));
  }
  public function saveCompanyUpdate( $compid,Request $request)
  {
    try{
      $company=$this->customExceptions->EditCompany($request);
    }
    catch(\PDOException $e){
      return back()->withError($e->getMessage())->withInput();
    }
    $newCompany= CompanyProfile::find($compid);
      if($request->file('image')==NULL){
        $newCompany->companyname = $request->companyname;
        $newCompany->address = $request->address;
        $newCompany->tin = $request->tin;
        $newCompany->contactNo = $request->contactNo;
        $newCompany->email = $request->email;
        $newCompany->logo=$newCompany->logo;
        $newCompany->save();
      }
      else{
      $filename = $request->file('image')->getClientOriginalName();
  
      $path = public_path().'/company/company_images';
      $request->file('image')->move($path, $filename);
  
      $newCompany->companyname = $request->companyname;
            $newCompany->address = $request->address;
            $newCompany->tin = $request->tin;
            $newCompany->contactNo = $request->contactNo;
            $newCompany->email = $request->email;
            $newCompany->logo=$filename;
             $newCompany->save();
      }
      return redirect('/company/companylist')->with('success','Company Information Successfully Edited');
  }
  public function removeCompany($compid)
  {
    $newCompany= CompanyProfile::find($compid);
  
      if ($newCompany) {
          $newCompany->delete();
      }
  
      return \Response::json(['status' =>200,'error'=>""]);
  }
//     public function addNewCompany(Request $request){
//         $newCompany= new CompanyProfile();
        
//         $newCompany->companyname = $request->companyname;
//         $newCompany->address = $request->address;
//         $newCompany->tin = $request->tin;
//         $newCompany->contactNo = $request->contactNo;
//         $newCompany->email = $request->email;

//         $newCompany->save();

//         return response()->json([
//             'message' => "Saved successfully!"
//         ]);
//   }
  public function getCompanyProfileByID($id){
    $info = CompanyProfile::find($id);

    return response()->json([
        'info' => $info
    ]);
  }
  public function getCompanyProfileByName($name){
    $info = DB::table('companies')->where('companyname','=',$name)->get();

    return response()->json([
        'info' => $info
    ]);
  }

}
