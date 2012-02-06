class ApplicationController < ActionController::Base
  protect_from_forgery

  before_filter :auth_from_cookie

  def auth_from_cookie
    auto_login(User.find(cookies[:thirsty_uid])) if cookies[:thirsty_uid].present?
  end
end
