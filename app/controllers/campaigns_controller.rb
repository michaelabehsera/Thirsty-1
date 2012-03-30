require 'xmlrpc/client'

class CampaignsController < ApplicationController

  before_filter :authorize, except: :submit
  before_filter :associate, except: [:authorize, :index]

  expose(:campaign) { Campaign.where(uuid: params[:uuid]).first }
  expose(:con) {
    OAuth::Consumer.new('811319492611.apps.googleusercontent.com', 'MgExVYkbVQQViVGtTnScO8Lg',
      {:site => 'https://www.google.com',
       :request_token_path => '/accounts/OAuthGetRequestToken',
       :access_token_path => '/accounts/OAuthGetAccessToken',
       :authorize_path => '/accounts/OAuthAuthorizeToken'})
  }
  expose(:campaign_notifications) {
    ([campaign.notification] + campaign.cocktail.goals.map {|g|g.notification} + campaign.articles.map {|a|a.notification}).flatten.compact.sort_by(&:created_at).reverse if current_user
  }

  def associate
    user = nil
    if params[:id]
      begin
        user = User.find params[:id]
        user.active_campaigns << campaign
      rescue
        if current_user
          current_user.active_campaigns << campaign
          user = current_user
        end
      end
    elsif current_user
      current_user.active_campaigns << campaign
      user = current_user
    end
    if campaign
      begin
        campaign.articles.each do |article|
          unless user.bits.where(article_id: article.id).first
            bitly = BitLy.shorten("#{article.url}##{user.id}")
            bit = article.bits.new(url: bitly.short_url, hash: bitly.user_hash)
            bit.user = user
            bit.save
          end
        end
      rescue
      end
    end
  end

  def authorize
    redirect_to '/signin' unless logged_in?
  end

  def help
    help = campaign.helps.new
    help.user = current_user
    help.save
    render nothing: true
  end

  def edit_article
    article = Article.find params[:id]
    render json: { title: article.title, content: article.content, tags: article.tags, id: article.id }
  end

  def request_edit
    article = Article.find params[:id]
    Pony.mail(
      to: article.user.email,
      from: 'mike@thirsty.com',
      subject: 'You have some feedback',
      body: "Your \"#{article.title}\" has received some feedback:<br/><br/>#{params[:request]}",
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
    render nothing: true
  end

  def upgrade
    Stripe::Customer.retrieve(campaign.stripe_id).update_subscription(plan: params[:plan])
    respond_to :js
  end

  def headline
    headline = campaign.headlines.new(title: params[:headline])
    headline.user = current_user
    headline.save
    respond_to :js
  end

  def view
    article = Article.find params[:id]
    render json: { success: true, title: article.title, article: article.content, bio: article.bio }
  end

  def chat_message
    Juggernaut.publish campaign.uuid, { message: params[:message], username: current_user.name, timestamp: Time.now.strftime('%H:%M') }, except: params[:sessionID]
    chat = Chat.new
    chat.campaign = campaign
    chat.user = current_user
    chat.message = params[:message]
    chat.timestamp = Time.now.strftime('%H:%M')
    chat.save
  end

  def analytics
    @article = Article.find params[:id]
    @json = @article.bits.map { |bit| { referrers: BitLy.referrers(bit.url).referrers, user: bit.user.name } }.to_json
    render layout: false
  end

  def create_comment
    @comment = campaign.comments.new params[:comment]
    @comment.user = current_user
    @comment.create_notification if @comment.save
    respond_to :js
  end

  def update_desc
    campaign.tags.each { |t| campaign.tags.delete(t) }
    params[:tags].split(/, ?/).each do |tag|
      campaign.tags << Tag.find_or_create_by(name: tag)
    end
    respond_to :js
  end

  def update_guidelines
    campaign.update_attribute(:guidelines, params[:guidelines])
    respond_to :js
  end

  def upload_image
    campaign.update_attributes params[:campaign]
    redirect_to "/campaigns/#{campaign.uuid}"
  end

  def install
    plugin = Plugin.find params[:pid]
    creds = { user: params[:fuser], pass: params[:fpass], domain: params[:fdomain], root: params[:root] }
    Stalker.enqueue 'tool.upload', { id: @plugin.id, cid: campaign.id, cid: campaign.id }, ttr: 9999
    render nothing: true
  end

  def theme
    plugin = Theme.find params[:tid]
    creds = { user: params[:fuser], pass: params[:fpass], domain: params[:fdomain], root: params[:root] }
    Stalker.enqueue 'theme.upload', { id: plugin.id, cid: campaign.id, creds: creds }, ttr: 9999
    render nothing: true
  end

  def submit
    user = User.find(params[:id])
    user.update_attribute(:bio, params[:bio])
    if params[:edit] == 'false'
      article = campaign.articles.new(content: params[:content], title: params[:title], bio: params[:bio], tags: params[:tags])
      article.user = user
      if article.save
        article.create_notification
        render json: { success: true, id: article.id, title: article.title, name: user.name }
      else
        render json: { success: false }
      end
    else
      article = Article.find params[:aid]
      article.update_attributes(content: params[:content], title: params[:title], bio: params[:bio], tags: params[:tags])
      render json: { success: true, id: article.id, title: article.title, name: user.name }
    end
  end

  def deny
    @article = Article.find(params[:id])
    @article.update_attribute(:approved, false)
    render 'deny'
  end

  def approve_headline
    @headline = Headline.find params[:id]
    @headline.update_attribute(:approved, true)
    Pony.mail(
      to: @headline.user.email,
      from: 'mike@thirsty.com',
      subject: 'Your headline has been approved!',
      body: "Your \"#{@headline.title}\" headline has been approved! Get started on that article ;).",
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
    respond_to :js
  end

  def deny_headline
    @headline  = Headline.find params[:id]
    @headline.update_attribute(approved: false)
    respond_to :js
  end

  def approve
    article = Article.find params[:id]
    post = {
      'title' => article.title,
      'description' => article.content,
      'mt_keywords' => article.tags.split(/, ?/)
    }
    connection = XMLRPC::Client.new(campaign.url.gsub('http://', '').gsub('www.', ''), '/xmlrpc.php')
    id = connection.call(
      'metaWeblog.newPost',
      1,
      campaign.username,
      campaign.pass,
      post,
      true
    )
    tries = 0
    while !article.url && tries < 5
      tries = tries + 1
      article.update_attribute(:url, connection.call('metaWeblog.getPost',id,campaign.username,campaign.pass)['link'])
    end
    if article.save
      Stalker.enqueue 'analytics.send', { id: article.id }, ttr: 999
      Pony.mail(
        to: article.user.email,
        from: 'mike@thirsty.com',
        subject: 'Your article has been approved!',
        body: "Your \"#{article.title}\" article has been approved!",
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
      article.update_attribute(:approved, true)
      goal = campaign.goals.where(type: :article).first
      goal.update_attribute(:achieved, true) if goal && campaign.articles.where(month: campaign.month, approved: true).count >= goal.num
      @article = article
      render 'approve'
    else
      render nothing: true
    end
  end

  def paid
    campaign.update_attributes(paid: true, stripe_id: params[:customer_id])
    redirect_to "/campaigns/#{campaign.uuid}"
  end

  def update
    campaign.tags.each { |t| campaign.tags.delete(t) }
    campaign.update_attributes params[:campaign]
    campaign.tags.each { |t| campaign.tags.delete(t) }
    params[:tags].split(/, ?/).each do |tag|
      campaign.tags << Tag.find_or_create_by(name: tag)
    end
  end

  def create
    url = params[:url].gsub('http://', '')
    host = url.split('/')[0]
    if url.split('/').count > 1
      path = '/' + url.split('/')[1..-1].join('/') + '/xmlrpc.php'
    else
      path = '/xmlrpc.php'
    end
    @wordpress = true
    begin
      connection = XMLRPC::Client.new(host, path)
      connection.call('wp.getUsersBlogs', params[:user], params[:pass])
    rescue Exception => e
      @wordpress = false
    end
    if @wordpress
      @campaign = Campaign.new(uuid: UUID.new.generate)
      @campaign.user = current_user
      @campaign.cocktail = Cocktail.find(params[:id])
      @campaign.title = params[:name]
      @campaign.url = url
      @campaign.username = params[:user]
      @campaign.pass = params[:pass]
      @campaign.analytics_id = params[:aid]
      @campaign.guidelines = params[:guidelines]
      params[:tags].split(/, ?/).each do |tag|
        @campaign.tags << Tag.find_or_create_by(name: tag)
      end
      case @campaign.cocktail.price
        when 149
          @campaign.goals.new(num: 3, type: :article)
        when 299
          @campaign.goals.new(num: 6, type: :article)
        when 499
          @campaign.goals.new(num: 12, type: :article)
          @campaign.goals.new(num: 500, type: :traffic)
        when 999
          @campaign.goals.new(num: 21, type: :article)
          @campaign.goals.new(num: 1500, type: :traffic)
        when 1999
          @campaign.goals.new(num: 45, type: :article)
          @campaign.goals.new(num: 4000, type: :traffic)
        when 4999
          @campaign.goals.new(num: 100, type: :article)
          @campaign.goals.new(num: 10000, type: :traffic)
        when 9999
          @campaign.goals.new(num: 200, type: :article)
          @campaign.goals.new(num: 25000, type: :traffic)
      end
      if @campaign.save
        Pony.mail(
          to: @campaign.user.email,
          from: 'mike@thirsty.com',
          subject: 'Thanks for signing up!',
          body: "Thanks for signing up with Thirsty!",
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
        @campaign.create_notification
        current_user.active_campaigns << @campaign
        @campaign.articles.each do |article|
          unless current_user.bits.where(article_id: article.id).first
            bitly = BitLy.shorten("#{article.url}##{current_user.id}")
            bit = article.bits.new(url: bitly.short_url, hash: bitly.user_hash)
            bit.user = current_user
            bit.save
          end
        end
      end
    else
      render 'create_fail'
    end
  end

  def callback
    rt = OAuth::RequestToken.new(con, session[:rt_token], session[:rt_secret])
    Garb::Session.access_token = rt.get_access_token oauth_verifier: params[:oauth_verifier]
    profile = Garb::Management::Profile.all.detect { |p| p.web_property_id =~ /#{campaign.analytics_id}/ }
    campaign.articles.each do |article|
      page = profile.pageviews.detect { |p| p.page_path =~ /#{article.url.gsub(campaign.url, '')}/ }
      article.update_attribute(:unique_pageviews, page.unique_pageviews.to_i) if page
    end
    redirect_to "/campaigns/#{campaign.uuid}"
  end

  def auth
    rt = con.get_request_token({oauth_callback: root_url + "campaigns/#{campaign.uuid}/callback"}, {:scope => 'https://www.google.com/analytics/feeds/data'})
    session[:rt_token] = rt.token
    session[:rt_secret] = rt.secret
    redirect_to rt.authorize_url
  end

end
