class SiteController < ApplicationController

  def inbound
    uuid, receiver = params['MailboxHash'].split('|')
    edit = Edit.where(uuid: uuid).first
    message = edit.messages.new(content: params['TextBody'].match(/((.|\n)*)\n\nOn \w{3}, \w{3} \d, \d{4}(.|\n)*wrote/).captures.first)
    if receiver == 'f'
      message.user = edit.to
    else
      message.user = edit.from
    end
    message.save
    UsersMailer.response(uuid, receiver, params['Subject'], CGI.unescapeHTML(params['HtmlBody'])).deliver
    render nothing: true
  end

  def stripe
    event = JSON.parse request.body.read
    if event['type'] == 'customer.subscription.created'
      Left.create type: :incoming, amount: event['data']['object']['plan']['amount'] / 100, customer: event['data']['object']['customer']
      left = Leftronic.new 'llyYZJ65kVcDDhvITRNF'
      left.push 'inrev', Left.where(type: :incoming).map{|l|l.amount}.reduce(:+)
    elsif event['type'] == 'customer.subscription.deleted'
      Left.where(type: :incoming, customer: event['data']['object']['customer']).first.destroy
      left = Leftronic.new 'llyYZJ65kVcDDhvITRNF'
      left.push 'inrev', Left.where(type: :incoming).map{|l|l.amount}.reduce(:+)
    end
    render nothing: true
  end

  def notify
    current_user.update_attribute(:type, :marketer)
    respond_to :js
  end

  def index
    render 'home' if logged_in?
  end

  def install_theme
    theme = Theme.new params[:theme]
    theme.filename = params[:url].split('/').last
    `wget #{params[:url]} -P #{Rails.root}/public/wordpress/themes`
    `unzip #{Rails.root}/public/wordpress/themes/#{theme.filename} -d #{Rails.root}/public/wordpress/themes`
    Archive.read_open_filename("#{Rails.root}/public/wordpress/themes/#{theme.filename}") do |ar|
      theme.foldername = ar.next_header.pathname
    end
    theme.save
    redirect_to request.referrer
  end

  def install_plugin
    plugin = Plugin.new params[:plugin]
    plugin.filename = params[:url].split('/').last
    `wget #{params[:url]} -P #{Rails.root}/public/wordpress/plugins`
    `unzip #{Rails.root}/public/wordpress/plugins/#{plugin.filename} -d #{Rails.root}/public/wordpress/plugins`
    Archive.read_open_filename("#{Rails.root}/public/wordpress/plugins/#{plugin.filename}") do |ar|
      plugin.foldername = ar.next_header.pathname
    end
    plugin.save
    redirect_to request.referrer
  end

  def my_notifications
    if logged_in?
      render 'notifications'
    else
      redirect_to '/'
    end
  end

  def callback
    rt = OAuth::RequestToken.new(con, session[:rt_token], session[:rt_secret])
    Garb::Session.access_token = rt.get_access_token oauth_verifier: params[:oauth_verifier]
    current_user.campaigns.each do |campaign|
      profile = Garb::Management::Profile.all.detect { |p| p.web_property_id =~ /#{campaign.analytics_id}/ }
      campaign.articles.each do |article|
        page = profile.pageviews.detect { |p| p.page_path =~ /#{article.title}/ }
        article.update_attribute(:unique_pageviews, page.unique_pageviews.to_i) if page
      end
    end
    redirect_to campaign.url
  end

  def auth
    rt = con.get_request_token({oauth_callback: 'http://localhost:3000/callbacks'}, {:scope => 'https://www.google.com/analytics/feeds/data'})
    session[:rt_token] = rt.token
    session[:rt_secret] = rt.secret
    redirect_to rt.authorize_url
  end

end
