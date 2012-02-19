class UsersController < InheritedResources::Base

  expose(:user) { User.where(username: params[:username]).first }

  def link
    social = user.socials.where(name: params[:name]).first || user.socials.new(name: params[:name])
    social.url = params[:url]
    social.save
    render nothing: true
  end

  def update
    user.update_attributes params[:user]
    pass = params[:password]
    user.change_password!(pass) if pass.present? && pass == params[:password_confirmation]
    user.save
    respond_to :js
  end

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
    if u = login(params[:user][:email], params[:user][:password], true)
      remember_me!
      cookies[:thirsty_uid] = u.id
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

  def settings
    redirect_to '/' if current_user != user
  end

  def show
  end

end
