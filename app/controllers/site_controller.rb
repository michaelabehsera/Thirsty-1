class SiteController < ApplicationController

  def index
    if logged_in?
      if current_user.type == :marketer
        render 'campaigns'
      else
        render 'cocktails'
      end
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
