<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Modules\RolePermission\Entities\InfixRole;
use Modules\RolePermission\Entities\Permission;
use Modules\RolePermission\Entities\InfixModuleInfo;
use Modules\RolePermission\Entities\InfixPermissionAssign;
use Modules\RolePermission\Entities\InfixModuleStudentParentInfo;

class UserRolePermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $route = null)
    {
       if (!Auth::guard('web')->check()) {
            return redirect()->route('login');
        }

        $permissions =  app('permission');

        $cache_key = 'have_due_fees_'.auth()->user()->id ;
        if(Cache::get($cache_key)){
            $whitelist = ['fees.student-fees-list','fees.student-fees-list-parent','student_fees','student-dashboard'];
            $permissions = (array_intersect($whitelist, $permissions));
        }

        
        if(!$this->hasPermission($route)){
            abort(403);
        }

        if( (! is_null($permissions)) &&  (Auth::user()->role_id != 1) ){
            if( in_array($route , $permissions )){
                return $next($request);
            }
            else{
                abort('403');
            }
        }else{
            return $next($request);
        }
    }

    public function hasPermission($route){


        $permissions = Permission::with(['subModule'])->get();
       
        $parent_module = $permissions->where('route', $route)->first();

        if(!$parent_module){
            foreach($permissions as $permission){
                $children_module = $permission->subModule->where('route', $route)->first();
                if($children_module){
                    $parent_module = $permission;
                    break;
                }
            }
        }

        if($parent_module){
            $parent_module_id = $parent_module->id;

            // get permission name

            $school_permissions = planPermissions('menus', true);
            $key = false;
            foreach($school_permissions as $permission => $id){
                if($id == $parent_module_id){
                    $key = $permission;
                    break;
                }
            }

            if($key) {
                return isMenuAllowToShow($key);
            }
        }
        return true;
    }
}