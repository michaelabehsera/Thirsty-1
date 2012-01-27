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
    if user = login(params[:email], params[:password], true)
      redirect_to '/'
    else
      render inline: 'fail'
    end
  end

  def signout
    logout
    redirect_to '/'
  end

  def signup
  end

end
