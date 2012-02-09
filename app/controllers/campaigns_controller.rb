require 'atom/pub'

class CampaignsController < ApplicationController

  before_filter :authorize, except: :submit

  expose(:campaign) { Campaign.where(uuid: params[:uuid]).first }
  expose(:con) {
    OAuth::Consumer.new('811319492611.apps.googleusercontent.com', 'MgExVYkbVQQViVGtTnScO8Lg',
      {:site => 'https://www.google.com',
       :request_token_path => '/accounts/OAuthGetRequestToken',
       :access_token_path => '/accounts/OAuthGetAccessToken',
       :authorize_path => '/accounts/OAuthAuthorizeToken'})
  }

  def authorize
    redirect_to '/signin' unless logged_in?
  end

  def submit
    user = User.find(params[:id])
    blog = Wordpress::Blog.new(campaign.url,campaign.username,campaign.pass)

    post_cat = {:term => "Category", :label => "Category", :scheme => "category"}
    blog.add_category post_cat unless blog.category_exists? post_cat

    post = Atom::Entry.new do |post|
      post.title = params[:title]
      post.authors << Atom::Person.new(:name => user.first_name + ' ' + user.last_name)
      post.categories << Atom::Category.new(post_cat)
      post.updated = Time.now
      post.content = Atom::Content::Html.new params[:content]
    end

    rsp = blog.publish_post post
    article = campaign.articles.new(url: rsp.id, title: rsp.title)
    article.user = user
    if article.save
      article.create_notification
      render json: { success: true }
    else
      render json: { success: false }
    end
  end

  def create
    campaign = Campaign.new(uuid: UUID.new.generate)
    campaign.user = current_user
    campaign.cocktail = Cocktail.find(params[:id])
    campaign.title = params[:name]
    campaign.url = params[:url]
    campaign.notes = params[:notes]
    campaign.username = params[:user]
    campaign.pass = params[:pass]
    campaign.analytics_id = params[:aid]
    if campaign.save
      campaign.create_notification
      redirect_to "/campaigns/#{campaign.uuid}"
    else
      render inline: 'fail'
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
