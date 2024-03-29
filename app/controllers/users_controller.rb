class UsersController < InheritedResources::Base

  expose(:user) { User.where(username: params[:username]).first }

  def reset_pass
    user = User.find(params[:id])
    user.change_password!(params[:password])
    user.save
    redirect_to '/signin'
  end

  def forgot_email
    user = User.where(email: params[:email]).first
    if user
      Pony.mail(
        to: params[:email],
        from: 'mike@thirsty.com',
        subject: 'Forgot your Thirsty pass?',
        body: "<a href=\"http://thirsty.com/forgot/#{user.id}\">Click here</a> to reset it.",
        headers: { 'Content-Type' => 'text/html' },
        via: :smtp,
        via_options: {
          address: 'smtp.gmail.com',
          port: '587',
          enable_starttls_auto: true,
          user_name: 'mike@thirsty.com',
          password: 'AAA123321',
          authentication: :plain,
          domain: 'thirsty.com'
        }
      )
    end
    redirect_to '/signin'
  end

  def link
    social = user.socials.where(name: params[:name]).first || user.socials.new(name: params[:name])
    case social.name
      when 'Dribbble'
        social.url = "http://dribbble.com/#{params[:handle]}"
      when 'Posterous'
        social.url = "http://#{params[:handle]}.posterous.com"
      when 'Twitter'
        social.url = "http://twitter.com/#{params[:handle]}"
      when 'Digg'
        social.url = "http://digg.com/#{params[:handle]}"
      when 'LinkedIn'
        social.url = "http://linkedin.com/in/#{params[:handle]}"
      when 'Reddit'
        social.url = "http://reddit.com/user/#{params[:handle]}"
      when 'Google +'
        social.url = "http://plus.google.com/#{params[:handle]}"
      when 'Tumblr'
        social.url = "http://#{params[:handle]}.tumblr.com"
      else
        social.url = params[:handle]
    end
    social.save
    render nothing: true
  end

  def update
    user.update_attributes params[:user]
    pass = params[:password]
    user.change_password!(pass) if pass.present? && pass == params[:password_confirmation]
    user.save
    redirect_to "/profile/#{user.username}/settings", notice: :success
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
