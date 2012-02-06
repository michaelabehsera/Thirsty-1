Thirsty::Application.routes.draw do

  get '/signup' => 'users#signup'
  get '/signout' => 'users#signout'
  get '/signin' => 'users#signin'

  get '/campaigns/:uuid' => 'campaigns#index'
  match '/campaigns/:uuid/:action' => 'campaigns'

  match '/:controller/meta/:action'
  match '/:controller/:action'
  match '/:action' => 'site'
  root to: 'site#index'

end
