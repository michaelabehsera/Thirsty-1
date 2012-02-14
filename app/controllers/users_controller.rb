class UsersController < InheritedResources::Base

  def create
    @user = User.new params[:user]
    if @user.save
      auto_login @user
      redirect_to '/'
    else
      render 'users/signup'
    end
  end

  def auth
    if user = login(params[:user][:email], params[:user][:password], true)
      remember_me!
      cookies[:thirsty_uid] = user.id
      redirect_to '/'
    else
      redirect_to '/signin', alert: 'error'
    end
  end

  def signout
    logout
    cookies[:thirsty_uid] = nil
    redirect_to '/'
  end

  def signup
  end

end
