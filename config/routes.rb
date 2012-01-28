Thirsty::Application.routes.draw do

  get '/signup' => 'users#signup'
  get '/signout' => 'users#signout'
  get '/signin' => 'users#signin'

  match '/:controller/:action'
  match '/:action' => 'site'
  root to: 'site#index'

end
