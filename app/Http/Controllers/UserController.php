<?php

namespace App\Http\Controllers;

use App\Events\UserRegistered;
use App\Http\Requests\UserRequest;
use App\Http\Traits\ApiResponseTrait;
use App\Notifications\WelcomeNotification;
use App\Repositories\UserRepository;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    use ApiResponseTrait;
    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * UserController constructor
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(UserRequest $request)
    {

        try {
            $data = $request->validated();
            // Store the user image in storage disk
            if(isset($data['image']) && !empty($data['image'])){
                $imagePath = $request->file('image')->store('profile_images', 'public');
                $data['image'] = $imagePath;
            }
    
            $user = $this->userRepository->createUser($data);
            event(new UserRegistered($user));

            return $this->successResponse($user, 'User Successfully Created', 201);    
        

        } catch (QueryException $e) {
            throw $e;
            return $this->errorResponse('Error', 'Database Error', Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Exception $e){
            throw $e;
            return $this->errorResponse('Error', 'Something went wrong', Response::HTTP_BAD_REQUEST);
        }
        
    }

    public function login(Request $request, UserRepository $userRepository)
    {
        try{
        $request->validate([
            'email' => 'required|email',
            'password' => 'required' 
        ]); 

        $user = $userRepository->findUserByEmail($request->email);

        if(!$user || !Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            throw ValidationException::withMessages([
                'email' => ['The Provided credentials are incorrect']
            ]);
        }
        $token = $user->createToken('authToken')->plainTextToken;
        return $this->successResponse($user, 'Successfull', 200, $token );    
    } catch (QueryException $e) {
        throw $e;
        return $this->errorResponse('Error', 'Database Error', Response::HTTP_INTERNAL_SERVER_ERROR);
    } catch (\Exception $e){
        throw $e;
        return $this->errorResponse('Error', 'Something went wrong', Response::HTTP_BAD_REQUEST);
    }
    }
}
