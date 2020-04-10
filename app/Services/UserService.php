<?php

namespace App\Services;

use App\Role;

use Illuminate\Support\Facades\Auth;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use App\BackOffice\Services\LoginTokenService;


class UserService {

		public function __construct(
			UserRepository $repository,
			LoginTokenService $loginTokenService
			) {
			$this->repository = $repository;
			$this->loginTokenService = $loginTokenService;
		}

		public function index() {
			return $this->repository->all();
		}
		
		public function create($request) {
			$request['password'] = bcrypt($request['password']);
			return $this->repository->create($request);
		}

		public function update($request, $id) {
			$user = $this->repository->find($id);
			$user->revokeAllRoles();
			$user = $this->repository->find($id);
			$roles = json_decode($request['roles']);
			
			if(count($roles)) {
				foreach ($roles as $role) {
					$user->assignRole($role);
				}
			}
			return $this->repository->update($id, $request);
		}

		public function read($id) {
						return $this->repository->find($id);
		}

		public function delete($id) {
							return $this->repository->delete($id);
		}

		public function checkUser($user) {
			return $this->repository->checkUser($user);
		}

		public function checkLogin() {
			if (Auth::check()) {
				$token = auth()->user()->createToken('TutsForWeb')->accessToken;
				$user = auth()->user();
				$user->roles = auth()->user()->getRoles();
				$newRoles = Role::where('id', auth()->user()->id)->get();
				return response()->json([
					'success' => true,
					'user' => $user,
					'userRoles' => $newRoles
				]);
			}
			return response()->json([
                'success' => false,
                'message' => 'You must login first'
            ])->setStatusCode(401);
		}

		public function forcedLogin($request) {
			$user =  $this->repository->forcedLogin($request['socio']);
			if($user) {
				$token = $this->loginTokenService->find($request['socio'], $request['token']);
				if($token) {
					$auth = Auth::login($user);
					$token = auth()->user()->createToken('TutsForWeb')->accessToken;
					$user = auth()->user();
					$user->roles = auth()->user()->getRoles();
					$newRoles = Role::where('id', auth()->user()->id)->get();
					return response()->json(['token' => $token, 'user' =>  $user, 'userRoles' => $newRole], 200);
					}
				}
		return response()->json([
			'success' => false,
			'message' => 'You must login first'
		])->setStatusCode(401);
		}
}