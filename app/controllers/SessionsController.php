<?php

class SessionsController extends \BaseController {

  protected $sessionsValidator;

  public function __construct(UserSessionValidator $userSessionValidator, AdminSessionValidator $adminSessionValidator)
  {
    $this->userSessionValidator = $userSessionValidator;
    $this->adminSessionValidator = $adminSessionValidator;
  }


  /**
   * Show the form for creating a new resource.
   * GET /sessions/create
   *
   * @return Response
   */
  public function create()
  {
    $type = get_login_type();

    return View::make('sessions.create', compact('type'));
  }

  /**
   * Allows an admin to log in.
   *
   */
  public function adminCreate()
  {
    $type = 'admin';
    return View::make('sessions.create', compact('type'));
  }

  /**
   * Store a newly created resource in storage.
   * POST /sessions
   *
   * @return Response
   */
  public function store()
  {
    // If coming from admin, use that login method.
    if (Input::has('password')) {
      $input = Input::only('email', 'password');
      $this->adminSessionValidator->validate($input);
      return $this->adminLogin($input);
    }
    // Use the user login/create method.
    else if (Input::has('birthdate')) {
      $input = Input::only('first_name', 'email', 'phone', 'birthdate', 'candidate_id');
      $this->userSessionValidator->validate($input);
      return $this->userLogin($input);
    }
  }

  /**
   * Remove the specified resource from storage.
   * DELETE /sessions/{id}
   *
   * @param  int  $id
   * @return Response
   */
  public function destroy($id = null)
  {
    Auth::logout();

    return Redirect::home()->withFlashMessage('You\'re now signed out.');;
  }
  /**
   *
   */
  public function userLogin($input)
  {
    $user = User::isCurrentUser($input);
    if (is_string($user)) {
      return Redirect::back()->withInput()->withFlashMessage('Looks like that\'s not the right birthdate');
    }
    if (!$user) {
      Event::fire('user.create');
      $user = User::createNewUser($input);
    }
    // Log in the user.
    Auth::login($user);

    // Is the user login on a vote page?
    if (isset($input['candidate_id']) && !empty($input['candidate_id'])) {
      $vote = Event::fire('user.login.to.vote', array($input['candidate_id'], Auth::user()->id));
      if ($vote)
        return Redirect::back()->withFlashMessage('Welcome ' . $input['first_name'] . '. We got that vote!');
      else
        return Redirect::back()->withFlashMessage('Welcome back ' . $input['first_name'] . '. You already voted in that category today!');
    }

    return Redirect::intended('/')->withFlashMessage('Welcome ' . $input['first_name']);
  }

  /**
   *
   */
  public function adminLogin($input)
  {
    // $this->sessionValidator->validate($input);
    if(Auth::attempt($input)) {
      return Redirect::intended('/')->withFlashMessage('Welcome back!');
    }
    else {
      return Redirect::back()->withInput()->withFlashMessage('Invalid username or password!');
    }

  }

}
