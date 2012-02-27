require 'atom/pub'

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

  def associate
    if params[:id]
      begin
        user = User.find params[:id]
        user.active_campaigns << campaign
      rescue
        current_user.active_campaigns << campaign if current_user
      end
    elsif current_user
      current_user.active_campaigns << campaign
    end
  end

  def authorize
    redirect_to '/signin' unless logged_in?
  end

  def chat_message
    Juggernaut.publish campaign.uuid, { message: params[:message], username: current_user.name, timestamp: Time.now.strftime('%H:%M') }, except: params[:sessionID]
    render nothing: true
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

  def upload_image
    campaign.update_attribute(:image, params[:image])
    respond_to :js
  end

  def install
    @plugin = Plugin.find params[:id]
    Stalker.enqueue 'tool.upload', { id: @plugin.id, cid: campaign.id }, ttr: 9999
    respond_to :js
  end

  def theme
    @plugin = Theme.find params[:id]
    Stalker.enqueue 'theme.upload', { id: @plugin.id, cid: campaign.id }, ttr: 9999
    respond_to :js
  end

  def submit
    user = User.find(params[:id])
    user.update_attribute(:bio, params[:bio]) unless user.bio
    article = campaign.articles.new(content: params[:content], title: params[:title], bio: params[:bio])
    article.user = user
    if article.save
      article.create_notification
      render json: { success: true }
    else
      render json: { success: false }
    end
  end

  def deny
    @article = Article.find(params[:id])
    @article.update_attribute(:approved, false)
    render 'deny'
  end

  def approve
    article = Article.find(params[:id])
    blog = Wordpress::Blog.new(campaign.url,campaign.username,campaign.pass)

    #post_cat = {:term => "Category", :label => "Category", :scheme => "category"}
    #blog.add_category post_cat unless blog.category_exists? post_cat

    post = Atom::Entry.new do |post|
      post.title = article.title
      post.authors << Atom::Person.new(:name => article.user.name)
      #post.categories << Atom::Category.new(post_cat)
      post.updated = article.created_at
      post.content = Atom::Content::Html.new (article.content + '<br/><br/><br/>' + article.bio)
    end

    rsp = blog.publish_post post
    article.update_attribute(:url, rsp.id)
    if article.save && article.url
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
    campaign.update_attribute(:paid, true)
    redirect_to "/campaigns/#{campaign.uuid}"
  end

  def create
    url = params[:url]
    url = 'http://' + url if url[0..6] != 'http://'
    begin
      Atom::Pub::Collection.new(href: url + '/wp-app.php/posts').publish(Atom::Entry.new, user: params[:user], pass: params[:pass])
    rescue Exception => e
      @wordpress = (e.message =~ /Internal/ && true || false)
    end
    begin
      Net::FTP.open params[:fdomain], params[:fuser], params[:fpass] do |ftp|
        root_dir = params[:root]
        root_dir += '/' if params[:root][-1] != '/'
        root_dir += 'wp-content'
        begin
          ftp.chdir root_dir
          @ftp_dir = true
        rescue Exception
          @ftp_dir = false
        end
      end
      @ftp = true
    rescue Exception
      @ftp = false
    end
    if @wordpress && @ftp && (defined?(@ftp_dir) && @ftp_dir || !defined?(@ftp_dir))
      @campaign = Campaign.new(uuid: UUID.new.generate)
      @campaign.user = current_user
      @campaign.cocktail = Cocktail.find(params[:id])
      @campaign.title = params[:name]
      @campaign.url = url
      @campaign.notes = params[:notes]
      @campaign.username = params[:user]
      @campaign.pass = params[:pass]
      @campaign.analytics_id = params[:aid]
      @campaign.ftp_user = params[:fuser]
      @campaign.ftp_pass = params[:fpass]
      @campaign.ftp_domain = params[:fdomain]
      @campaign.root_dir = params[:root]
      @campaign.create_notification if @campaign.save
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
