Thirsty::Application.routes.draw do

  get '/signup' => 'users#signup'
  get '/signout' => 'users#signout'
  get '/signin' => 'users#signin'

  get '/campaigns/:uuid' => 'campaigns#index'
  match '/campaigns/:uuid/:action' => 'campaigns'

  match '/notifications' => 'site#my_notifications'

  match '/profile/:username' => 'users#show'
  match '/profile/:username/:action' => 'users'

  match '/:controller/meta/:action'
  match '/:controller/:action'
  match '/:action' => 'site'
  root to: 'site#index'

end
